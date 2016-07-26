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
    <div class='container text-center'>
      <div class='jumbotron'>
        <?php
          error_reporting(E_ALL);
          ini_set("display_errors", 1);
          $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
          echo "<h2>" . $_GET['a'] . "</h2>";
          $location_name = $_GET['a'];
          $query_location = "SELECT Address
                             FROM Location
                             WHERE Lname = \"$location_name\";";

          $result_location = mysqli_query($con, $query_location);
          if(mysqli_num_rows($result_location) > 0) {
              $address =  mysqli_fetch_array($result_location)[0];
              echo $address;
          }

          $query_city = "SELECT CityName, CountryName
                         FROM Location
                         WHERE Lname = \"$location_name\";";

          $result_city = mysqli_query($con, $query_city);
          if(mysqli_num_rows($result_city) > 0) {
              $city = mysqli_fetch_array($result_city)[0];
          }

          $query_country = "SELECT CountryName
                         FROM Location
                         WHERE Lname = \"$location_name\";";

          $result_country = mysqli_query($con, $query_country);
          if(mysqli_num_rows($result_country) > 0) {
              $country = mysqli_fetch_array($result_country)[0];
          }
          $query_events = "SELECT DISTINCT Event.EName, Event.EDate, Event.StartTime, Event.EventType, AVG(Score) AS AvgScore
                           FROM Event, Review RIGHT OUTER JOIN Reviewable ON Review.ReviewableID=Reviewable.ReviewableID
                           WHERE Event.Address = \"$address\"
                           AND Event.ReviewableID = Reviewable.ReviewableID
                           GROUP BY Event.EName, Event.EDate, Event.StartTime, Event.EventType
                           ORDER BY AvgScore DESC, EName;";


         $result_events = mysqli_query($con, $query_events);
         if(mysqli_num_rows($result_events) > 0 ) {
           echo "<h3>Events: </h3>";
           echo "<table class= \"text-center\" border=\"1\">";
           echo "<tr>";
               echo "<th>Event</th><th>Date</th><th>Start Time</th><th>Category</th><th>Score</th>";
           echo "</tr>";
           while($val = mysqli_fetch_array($result_events)) {
               echo "<tr>";
               echo "<td>" . $val[0] . "</td>";
               echo "<td>" . $val[1] . "</td>";
               echo "<td>" . $val[2] . "</td>";
               echo "<td>" . $val[3] . "</td>";
               echo "<td>" . $val[4] . "</td>";
               echo "</tr>";
           }
           echo "<h3>Reviews</h3>";
         }

         $query_reviews = "SELECT DISTINCT Review.Username, Review.RDate, Review.Score, Review.Description
                           FROM Location, Review, Reviewable
                           WHERE Location.CityName = \"$city\" AND Location.CountryName = \"$country\" AND Location.Address = \"$address\"
                           AND Location.ReviewableID = Reviewable.ReviewableID AND Review.ReviewableID = Reviewable.ReviewableID
                           ORDER BY Review.RDate DESC;";

        $result_reviews = mysqli_query($con, $query_reviews);
         if(mysqli_num_rows($result_reviews) > 0 ) {
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
           echo "<br />";
         }

         ?>
      </div>
    </div>
  </body>
</html>
