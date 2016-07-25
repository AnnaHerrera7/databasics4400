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

    <meta charset ='utf-8'/>
    <title>GTtravel</title>
  </head>
  <body>
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
          if(mysqli_num_rows($result) > 0) {
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
