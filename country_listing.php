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
      <div class = "jumbotron">
          <?php
          error_reporting(E_ALL);
          ini_set("display_errors", 1);
          $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
          $country = $_GET['a'];
          echo "<h2>" . $country . "</h2>";
          $sql = "SELECT City.CityName, Population, LanguageName, AVG(Score) AS AvgScore
                  FROM City, CityLanguage, Review, Reviewable
                  WHERE City.CountryName = \"$country\"
                  AND City.CityName = CityLanguage.CityName AND City.CountryName = CityLanguage.CountryName
                  AND City.ReviewableID = Reviewable.ReviewableID AND Review.ReviewableID = Reviewable.ReviewableID
                  GROUP BY CityName, Population, LanguageName
                  ORDER BY AvgScore DESC, CityName;";
          $result = mysqli_query($con, $sql);
          if(mysqli_num_rows($result) > -1) {
            echo "<table class= \"text-center\" border=\"1\">";
            echo "<tr>";
                echo "<th>City</th><th>Population</th><th>Language</th><th>Score</th>";
            echo "</tr>";
            while($val = mysqli_fetch_array($result)) {
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
  </body>
</html>
