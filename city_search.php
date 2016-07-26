<?php
include 'database_con.php';
session_start();
?>
<html>
  <head>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous"/>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"
          rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1"
          crossorigin="anonymous">

    <link rel = 'stylesheet' href = './css/city_search.css'/>
    <meta charset ='utf-8'/>
    <title>GTtravel</title>
  </head>
  <body>
    <nav class = 'navbar navbar-light navbar-fixed-top'>
        <div id = "spy-scroll-id" class = 'container'>
          <ul class="nav navbar-nav navbar-right">
            <li class = 'active'><a href="home.php"><i class="fa fa-home"></i>Home</a></li>
            <li><a href = "login.php"><i class ="fa fa-user"></i>Logout</a></li>
          </ul>
          <a href = '#' class = "pull-left navbar-left"><img id = "logo" src = "./images/LogoMakr.png"></a>
        </div>
      </nav>
    <div class="container text-center">
      <div class='jumbotron'>
        <h2><center>City Search</center></h2>
          <form action = "" method="POST" role="form">
            <div class="form-group">
            <?php
              $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");

              $query_country = "SELECT * FROM Country";
              $result_country = mysqli_query($con, $query_country);
              echo "<label for=\"countrysel\">Country: </label>";
              echo "<select class=\"form-control\" id=\"countrysel\" name=\"country\" >";
              echo "<option value =\"empty\"></option>";
              while($row = mysqli_fetch_array($result_country)) {
                echo "<option value = '" . $row['CountryName'] . "'>" . $row['CountryName'] . "</option>";
              }
              echo "</select> <br />";

              $query_city = "SELECT City.CityName FROM City";
              $result_city = mysqli_query($con, $query_city);
              echo "<label for=\"citysel\">City: </label>";
              echo "<select class=\"form-control\" id=\"citysel\" name=\"cities\">";
              echo "<option value =\"empty\"></option>";
              while($row = mysqli_fetch_array($result_city)) {
                echo "<option value = '" . $row['CityName'] . "'>" . $row['CityName'] . "</option>";
              }
              echo "</select> <br />";
             ?>
             </div>
             <div class="form-group">
              <div class = "col-md-2">
              <label for="pop">Population: </label>
              </div>
              <input type="number" class="form-horizontal" id="pop" name="minimum" placeholder="Minimum"/> to 
              <input type="number" class="form-horizontal" id="pop" name="maximum" placeholder="Maximum"/><br />
              </div>
             <b class="text-center">City Languages:</b>
             <?php
                $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                $query = "SELECT * FROM Languages";
                $result = mysqli_query($con, $query);
                echo "<fieldset id=\"group1\">";
                while($row = mysqli_fetch_array($result)) {
                    echo "<input type = \"radio\" name=\"language\" value = '" . $row['LanguageName'] . "'>" .  $row['LanguageName'] . "</input><br />";
                }
                echo "</fieldset>"
              ?>
              <br/>
              <b>Sort Review Scores: </b>
              <select name="scoresort">
                <option value = 'AvgScore ASC'>Ascending</option>
                <option value = 'AvgScore DESC'>Descending</option>
              </select><br />
              <br/>
              <input type="submit" name="submit" value="Search">
          </form>
          <?php
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
            if (isset($_POST['cities'])
              || isset($_POST['country'])
              || isset($_POST['minimum'])
              || isset($_POST['maximum'])
              || isset($_POST['language'])
              || isset($_POST['scoresort'])) {
              if (!isset($_POST['cities']) || $_POST['cities'] == "empty") {
                $city = "";
              } else {
                $city = "City.CityName = \"". $_POST['cities'] ."\" AND ";
              }
              if (!isset($_POST['country']) || $_POST['country'] == "empty") {
                $country = "";
              } else {
                $country = "City.CountryName = \"". $_POST['country'] ."\" AND ";
              }
              if (!isset($_POST['minimum']) || $_POST['minimum'] == "") {
                $minimum = 0;
              } else {
                $minimum = $_POST['minimum'];
              }
              if (!isset($_POST['maximum']) || $_POST['maximum'] == "") {
                $maximum = 2147483647;
              } else {
                $maximum = $_POST['maximum'];
              }
              if (!isset($_POST['language'])) {
                $language = ") AND ";
              } else {
                $language = "WHERE CityLanguage.LanguageName = \"". $_POST['language']."\") AND ";
              }
              $sort = $_POST['scoresort'];
              $sql = "SELECT DISTINCT City.CityName, City.CountryName, City.Population, LanguageName, AVG(Score) AS AvgScore
                      FROM City, Country, CityLanguage, Review RIGHT OUTER JOIN Reviewable ON Review.ReviewableID=Reviewable.ReviewableID
                      WHERE
                      $city
                      $country
                      Country.Population BETWEEN $minimum AND $maximum
                      AND (City.CityName, City.CountryName) IN
                          (SELECT CityLanguage.CityName, CityLanguage.CountryName
                              FROM CityLanguage
                              $language
                              City.CityName = CityLanguage.CityName AND City.CountryName = CityLanguage.CountryName
                      AND City.ReviewableID = Reviewable.ReviewableID
                      GROUP BY CityName, CountryName, Population, LanguageName
                      ORDER BY $sort , City.CityName ASC;";
              $result = mysqli_query($con, $sql) or die(mysqli_error($con));
              if(mysqli_num_rows($result) > 0) {
                  $_SESSION['country_search'] = $result;
                  echo "<br/><br/>";
                  echo "<table class= \"table\">";
                  echo "<tr>";
                      echo "<th> City </th><th> Country </th><th> Population </th><th>Language</th><th>Score</th>";
                  echo "</tr>";
                  $output = array();
                  $loc = 0;
                  while($val = mysqli_fetch_array($result)) {
                      if (count($output) == 0) {
                        $output[$loc] = array($val[0], $val[1], $val[2], $val[3], $val[4]);
                      } elseif ($output[$loc][0] == $val[0]) {
                        $output[$loc][3] = $output[$loc][3] . "<br/>" . $val[3];
                      } else {
                        $loc++;
                        $output[$loc] = array($val[0], $val[1], $val[2], $val[3], $val[4]);
                      }
                  }
                  $_SESSION['city_search_result'] = $output;
                  foreach($output as $row) {
                      echo "<tr>";
                      echo "<td>" . $row[0] . "</td>";
                      echo "<td>" . $row[1] . "</td>";
                      echo "<td>" . $row[2] . "</td>";
                      echo "<td>" . $row[3] . "</td>";
                      echo "<td>" . $row[4] . "</td>";
                      echo "</tr>";
                  }
                  echo "</table>";
              } else {
                  echo "<div>No results found!</div>";
              }
            }
          ?>
      </div>
    </div>

  </body>
</html>
