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

    <link rel = 'stylesheet' href = './css/country_listing.css'/>

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
      <div class = "jumbotron">
          <?php
          error_reporting(E_ALL);
          ini_set("display_errors", 1);
          $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
          $country = $_GET['a'];
          echo "<h2>" . $country . "</h2>";
          $result = mysqli_query($con, "SELECT city.CityName
                                        FROM city
                                        WHERE city.CountryName =\"$country\" AND city.Capital=1;") or die(mysqli_error($con));
          $cities = "";
          while ($val = mysqli_fetch_array($result)) {
            $cities = $cities . $val[0] . " ";
          }
          echo "<h3> Capital(s): $cities </h3>";
          $result = mysqli_query($con, "SELECT country.Population
                              FROM country
                              WHERE country.CountryName=\"$country\";") or die(mysqli_error($con));
          $val = mysqli_fetch_array($result);
          $pop = number_format($val[0], 0, ".", ",");
          echo "<h3> Population: $pop </h3>";
          $result = mysqli_query($con, "SELECT DISTINCT citylanguage.LanguageName
                                        FROM citylanguage
                                        WHERE citylanguage.CountryName=\"$country\";") or die(mysqli_error($con));
          $langs = "";
          while ($val = mysqli_fetch_array($result)) {
            $langs = $langs . $val[0] . " ";
          }
          echo "<h3> Language(s): $langs </h3>";
          $sql = "SELECT City.CityName, City.Population, CityLanguage.LanguageName, AVG(Score) AS AvgScore
                  FROM City, CityLanguage, Review RIGHT OUTER JOIN Reviewable ON Reviewable.ReviewableID = Review.ReviewableID
                  WHERE City.CountryName = \"$country\"
                  AND City.CityName = CityLanguage.CityName AND City.CountryName = CityLanguage.CountryName
                  AND City.ReviewableID = Reviewable.ReviewableID
                  GROUP BY CityName, Population, LanguageName
                  ORDER BY AvgScore DESC, CityName;";
          $result = mysqli_query($con, $sql) or die(mysqli_error($con));

          if(mysqli_num_rows($result) > -1) {
            echo "<table class= \"table table-striped\" border=\"1\">";
            echo "<tr>";
                echo "<th>City</th><th>Population</th><th>Language</th><th>Score</th>";
            echo "</tr>";
            $output = array();
            $loc = 0;
            while($val = mysqli_fetch_array($result)) {
                if (count($output) == 0) {
                  $output[$loc] = array($val[0], $val[1], $val[2], $val[3]);
                } elseif ($output[$loc][0] == $val[0]) {
                  $output[$loc][2] = $output[$loc][2] . "<br/>" . $val[2];
                } else {
                  $loc++;
                  $output[$loc] = array($val[0], $val[1], $val[2], $val[3]);
                }
            }
           foreach($output as $val) {
                echo "<tr>";
                echo "<td>" . $val[0] . "</td>";
                echo "<td>" . $val[1] . "</td>";
                echo "<td>" . $val[2] . "</td>";
                echo "<td>" . $val[3] . "</td>";
                echo "</tr>";
            }
          }
          ?>
      </div>
    </div>
    <div class = "btn-group">
      <?php
        echo "<a class=\"btn btn-default\" href=\"country_search.php\">Go Back</a>";
        ?>
    </div>
  </body>
</html>
