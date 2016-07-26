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
        $city = $_GET['a'];
        echo "<h2> $city </h2>";
        $query = "SELECT *
                  FROM City
                  WHERE CityName = \"$city\";";
        $result = mysqli_query($con, $query);
        $result_array = mysqli_fetch_array($result);
        $country = $result_array['CountryName'];
        $population = $result_array['Population'];

        echo "<h4>Country: $country</h4>";
        echo "<h4>Population: $population</h4>";
        $query_languages = "SELECT LanguageName
                            FROM CityLanguage
                            WHERE CityName = \"$city\";";
        $result_languages = mysqli_query($con, $query_languages);
        echo "<h4>Languages: ";
        while($row = mysqli_fetch_array($result_languages)) {
            $lang = $row['LanguageName'];
            echo "$lang ";
        }
        echo "</h4>";
        echo "<h4> Average Review Score: Filler</h4>";
        $lat = $result_array["Latitude"];
        $long = $result_array["Longitude"];
        echo "<h4>GPS: $lat, $long</h4>";
        echo "<h4>Locations Within: </h4>";

        $query_locations = "SELECT DISTINCT Location.LName, Location.LocationType, Location.Cost, AVG(Score) AS AvgScore
                            FROM Location, Review RIGHT OUTER JOIN Reviewable ON Review.ReviewableID=Reviewable.ReviewableID
                            WHERE Location.CityName = \"$city\"
                            AND Location.ReviewableID = Reviewable.ReviewableID
                            GROUP BY Location.LName, Location.LocationType, Location.Cost
                            ORDER BY AvgScore DESC;";

        $result_locations = mysqli_query($con, $query_locations);
        if(mysqli_num_rows($result_locations) > 0) {
          echo "<table class= \"text-center\" border=\"1\">";
          echo "<tr>";
              echo "<th>Name</th><th>Category</th><th>Cost</th><th>Score</th>";
          echo "</tr>";
          while($val = mysqli_fetch_array($result_locations)) {
              echo "<tr>";
              echo "<td>" . $val[0] . "</td>";
              echo "<td>" . $val[1] . "</td>";
              echo "<td>" . $val[2] . "</td>";
              echo "<td>" . $val[3] . "</td>";
              echo "</tr>";
          }
          echo "<br />";
        } else {
            echo "No Locations Found!";
        }

        echo "<h4> Reviews: </h4>";
        $query_reviews = "SELECT DISTINCT Review.Username, Review.RDate, Review.Score, Review.Description
                          FROM City, Review, Reviewable
                          WHERE City.CityName = \"$city\" AND City.CountryName = \"$country\"
                          AND City.ReviewableID = Reviewable.ReviewableID AND Review.ReviewableID = Reviewable.ReviewableID
                          ORDER BY Review.RDate DESC;";
        $result_reviews = mysqli_query($con, $query_reviews);
        if(mysqli_num_rows($result_reviews) > 0) {
          echo "<table class= \"text-center\" border=\"1\">";
          echo "<tr>";
              echo "<th>Username</th><th>Date</th><th>Score</th><th>Description</th>";
          echo "</tr>";
          while($val = mysqli_fetch_array($result_reviews)) {
              echo "<tr>";
              echo "<td>" . $val[0] . "</td>";
              echo "<td>" . $val[1] . "</td>";
              echo "<td>" . $val[2] . "</td>";
              echo "<td>" . $val[3] . "</td>";
              echo "</tr>";
          }
        } else {
            echo "No reviews found!";
        }
        ?>
      </div>
    </div>
  </body>
</html>
