<?php
include 'database_con.php';
session_start();
?>
<html>
  <head>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

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
          <ul class="nav navbar-nav navbar-left">
            <li><a href = "country_search.php"><i class="fa fa-globe"></i> Country</a></li>
            <li><a href = "city_search.php"><i class="fa fa-building-o"></i> City</a></li>
            <li><a href = "location_search.php"><i class="fa fa-map-marker"></i> Location</a></li>
            <li><a href = "event_search.php"><i class="fa fa-calendar"></i> Event</a></li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class = "fa fa-pencil"></i> Reviews <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="review_city.php">Review a City</a></li>
                <li><a href="review_event.php">Review an Event</a></li>
                <li><a href="review_location.php">Review a Location</a></li>
                <li><a href="see_reviews.php">See All Reviews</a></li>
              </ul>
            </li>
          </ul>
        </div>
    </nav>
      <div class="container text-center">
        <div class="jumbotron">
          <h2><center>Country Search</center></h2>
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
                      echo "<br/><br/>";
                      echo "<table class= \"table table-striped\" border=\"1\">";
                      echo "<tr>";
                          echo "<th> Country </th><th> Capital City </th><th> Population </th><th>Language</th>";
                      echo "</tr>";
                      $output = array();
                      $loc = 0;
                      while($val = mysqli_fetch_array($result)) {
                          if (count($output) == 0) {
                            $output[$loc] = array($val[0], $val[1], $val[2], $val[3]);
                          } elseif ($output[$loc][0] == $val[0]) {
                            $output[$loc][3] = $output[$loc][3] . "<br/>" . $val[3];
                          } else {
                            $loc++;
                            $output[$loc] = array($val[0], $val[1], $val[2], $val[3]);
                          }
                      }
                      foreach($output as $val) {
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
