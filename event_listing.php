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

    <link rel = 'stylesheet' href = './css/event_listing.css'/>

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
        $dateTime = "<h4>Date & Time: $date at $startTime";
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
        echo "<h4>Discount: $discount_string</h4>";
        echo "<h4 id = \"DescripTitle\">Description: </h4>";
        echo "<div class = \"container text-center\" id = \"Descrip\">";
        echo "<h4>$description</h4>";
        echo "</div>";
        echo "<br/>";
        echo "<h3>Reviews:</h3>";
        $query_reviews = "SELECT Review.Username, Review.RDate, Review.Score, Review.Description
                          FROM Event, Review, Reviewable
                          WHERE Event.CityName = \"$city\" AND Event.CountryName = \"$country\" AND Event.Address = \"$address\"
                          AND Event.EName = \"$event\" AND Event.StartTime = \"$startTime\" AND Event.EDate = \"$date\"
                          AND Event.ReviewableID = Reviewable.ReviewableID AND Review.ReviewableID = Reviewable.ReviewableID
                          ORDER BY Review.RDate DESC;";

        $result_reviews = mysqli_query($con, $query_reviews);
        if(mysqli_num_rows($result_reviews) > 0) {
          echo "<table class= \"table table-striped\" border=\"1\">";
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
