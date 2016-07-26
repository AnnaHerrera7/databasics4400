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
          $query_events = "SELECT DISTINCT Event.EName, Event.EDate, Event.StartTime, Event.Category, AVG(Score) AS AvgScore
                           FROM Event, Review RIGHT OUTER JOIN Reviewable ON Review.ReviewableID=Reviewable.ReviewableID
                           WHERE Event.Address = \"$address\"
                           AND Event.ReviewableID = Reviewable.ReviewableID
                           GROUP BY Event.EName, Event.EDate, Event.StartTime, Event.Category
                           ORDER BY AvgScore DESC, EName;";

          
         ?>
      </div>
    </div>
  </body>
</html>
