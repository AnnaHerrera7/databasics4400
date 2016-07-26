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

    <link rel = 'stylesheet' href = './css/country_search.css'/>


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
        <div class="jumbotron">
          <h2>Country Search</h2>
            <form action="" method="POST" role = "form">
            <div class = "form-group">
              <?php
                  $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                  $query = "SELECT * FROM Country";
                  $result = mysqli_query($con, $query);
                  echo "<label for=\"countrysel\">Country: </label>";
                  echo "<select class=\"form-control\" id=\"countrysel\" name=\"country\">";
                  echo "<option value = 'empty'></option>";
                  while($row = mysqli_fetch_array($result)) {
                    echo "<option value = '" . $row['CountryName'] . "'>" . $row['CountryName'] . "</option>";
                  }
                  echo "</select>";
               ?>
               <br />
             </div>
             <div class="form-group">
              <div class = "col-md-2">
              <label for="pop">Population: </label>
              </div>
              <input type="number" class="form-horizontal" id="pop" name="minimum" placeholder="Minimum"/> to 
              <input type="number" class="form-horizontal" id="pop" name="maximum" placeholder="Maximum"/><br />
              </div>
              <b class="text-center">Languages</b>
               <?php
                  $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                  $query = "SELECT * FROM Languages";
                  $result = mysqli_query($con, $query);
                  echo "<fieldset id=\"languages\">";
                  while($row = mysqli_fetch_array($result)) {
                      echo "<input type = \"radio\" name=\"language\" value = '" . $row['LanguageName'] . "'>" .  $row['LanguageName'] . "</input><br />";
                  }
                ?>
                <br />
                <input type="submit" name="submit" value="Search">
            </form>
            <?php
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
            if (isset($_POST['minimum']) && $_POST['minimum'] != ""
              && isset($_POST['maximum']) && $_POST['maximum'] != "") {
                $pop = "Country.Population BETWEEN ". $_POST['minimum'] ." AND ". $_POST['maximum'] . " AND ";
            } else {
                $pop = "";
            }
            if (isset($_POST['language']) && $_POST['language'] != "") {
                $lang = "Country.CountryName IN
                       (SELECT CountryLanguage.CountryName
                         FROM CountryLanguage
                         WHERE CountryLanguage.LanguageName = \"". $_POST['language'] ."\") AND ";
            } else {
                $lang = "";
            }
            if (isset($_POST['country'])) {
                  if($_POST['country'] == "empty") {
                    $country = "";
                  } else {
                    $country = "Country.CountryName = \"". $_POST['country'] ."\" AND ";
                  }
                  $sql = "SELECT DISTINCT Country.CountryName, City.CityName, Country.Population, LanguageName
                      FROM Country, CountryLanguage, City
                      WHERE $country $pop $lang 
                      City.CountryName = Country.CountryName AND City.Capital = 1 AND 
                      Country.CountryName = CountryLanguage.CountryName;";
                  $result = mysqli_query($con, $sql);
                  if(mysqli_num_rows($result) > 0) {
                      $_SESSION['country_search'] = $result;
                      //echo "<script>window.location.href='country_search_results.php'</script>";
                      echo "<table class= \"text-center\" border=\"1\">";
                      echo "<tr>";
                          echo "<th> Country </th><th> Capital City </th><th> Population </th><th>Language</th>";
                      echo "</tr>";
                      while($val = mysqli_fetch_array($result)) {
                          echo "<tr>";
                          echo "<td><a href= \"country_listing.php?a=$val[0]\">" . $val[0] . "</a></td>";
                          echo "<td>" . $val[1] . "</td>";
                          echo "<td>" . $val[2] . "</td>";
                          echo "<td>" . $val[3] . "</td>";
                          echo "</tr>";
                      }
                      echo "</table>";
                  } else {
                      echo "No results found!";
                  }
              }
             ?>

  </body>
</html>
