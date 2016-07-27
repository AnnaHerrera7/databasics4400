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
        $event = $_GET['a'];
        echo "<h2>" . $event . "</h2>";

        $query = "SELECT *
                  FROM Event
                  WHERE Ename = \"$event\";";

        $result = mysqli_query($con, $query);
        $result_array = mysqli_fetch_array($result);
        $address = $result_array['Address'];
        $city = $result_array['CityName'];
        $country = $result_array['CountryName'];
        $location = "<h4>Location: $address $city, $country</h4>";
        $date = $result_array['EDate'];
        $startTime = $result_array['StartTime'];
        $endTime = $result_array['EndTime'];
        $dateTime = "<h4>Date & Time: $date at $startTime - $endTime";
        $cost = $result_array['Cost'];
        $category = $result_array['EventType'];
        $discount = $result_array['StudentDiscount'];
        $description = $result_array['Description'];
        if($discount == 0) {
            $discount_string = "No";
        } else {
            $discount_string = "Yes";
        }
        echo $location;
        echo $dateTime;
        echo "<h4>Cost: $cost Euros</h4>";
        echo "<h4>Category: $category";
        echo "<h4>Discount: $discount_string</4>";
        echo "<h4>Description: $description</h4>";
        echo "Reviews:";
        $query_reviews = "SELECT Review.Username, Review.RDate, Review.Score, Review.Description
                          FROM Event, Review, Reviewable
                          WHERE Event.CityName = \"$city\" AND Event.CountryName = \"$country\" AND Event.Address = \"$address\"
                          AND Event.EName = \"$event\" AND Event.StartTime = \"$startTime\" AND Event.EDate = \"$date\"
                          AND Event.ReviewableID = Reviewable.ReviewableID AND Review.ReviewableID = Reviewable.ReviewableID
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
          echo "<br />";
        } else {
            echo "No reviews found!";
        }
        ?>
      </div>
    </div>
  </body>
</html>
