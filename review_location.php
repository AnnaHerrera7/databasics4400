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

    <link rel = 'stylesheet' href = './css/review_event.css'/>

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
    <div class = "container text-center">
      <div class = "jumbotron">
        <h1>Write a Location Review</h1>
        <h2>Select a Location</h2>
        <form action="" method="POST">
        <?php
          $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");

          $query_country = "SELECT * FROM Country";
          $result_country = mysqli_query($con, $query_country);
          echo "<label for=\"countrysel\">Country:</label>";
          echo "<select class=\"form-control\" id=\"countrysel\" name=\"country\" >";
          while($row = mysqli_fetch_array($result_country)) {
            echo "<option value = '" . $row['CountryName'] . "'>" . $row['CountryName'] . "</option>";
          }
          echo "</select> <br />";

          $query_city = "SELECT DISTINCT City.CityName FROM City";
          $result_city = mysqli_query($con, $query_city);
          echo "<label for=\"citysel\">City:</label>";
          echo "<select class=\"form-control\" id=\"citysel\" name=\"cities\">";
          while($row = mysqli_fetch_array($result_city)) {
            echo "<option value = '" . $row['CityName'] . "'>" . $row['CityName'] . "</option>";
          }
          echo "</select> <br />";

          $query_location = "SELECT DISTINCT LName FROM Location";
              $result_location = mysqli_query($con, $query_location);
              echo "<label for=\"locsel\">Location:</label>";
              echo "<select class=\"form-control\" id=\"locsel\" name=\"location\">";
              while($row = mysqli_fetch_array($result_location)) {
                echo "<option value = '" . $row['LName'] . "'>" . $row['LName'] . "</option>";
              }
              echo "</select> <br />";
         ?>
         <div>
         <label for="subject">Subject: </label>
         <input class="form-control" type="text" name="subject" required/><br />
         </div>
         <div>
         <label for="description">Description: </label>
         <textarea class = "form-control" rows = "5" id="descrip" name="description" required></textarea><br />
         </div>

         <label for="score">Score: </label>
              <select name="score">
                <option value = 1>1</option>
                <option value = 2>2</option>
                <option value = 3>3</option>
                <option value = 4>4</option>
                <option value = 5>5</option>
              </select><br />
              <br/>
          <input type="submit" name="submit" value="Submit">
        </form>
        <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
        if(isset($_POST['country'])
          && isset($_POST['cities'])
          && isset($_POST['location'])
          && isset($_POST['subject'])
          && isset($_POST['score'])
          && isset($_POST['description'])
          && isset($_SESSION['user'])) {
            $country = $_POST['country'];
            $city = $_POST['cities'];
            $loc = $_POST['location'];
            $sub = $_POST['subject'];
            $score = $_POST['score'];
            $desc = $_POST['description'];
            $user = $_SESSION['user'];
            $date = date('m/d/Y');
            $query1 = "SELECT Location.ReviewableID
            FROM Location
            WHERE Location.LName = \"$loc\" AND Location.CityName = \"$city\" AND Location.CountryName = \"$country\";";
            if($my_revid = mysqli_query($con, $query1)) {
              if(mysqli_num_rows($my_revid) == 1) {
                $my_revid_array=mysqli_fetch_assoc($my_revid);
                $revid=$my_revid_array['ReviewableID'];
                $query2 = "INSERT INTO Review (Username, RDate, RSubject, Score, ReviewableID, Description)
                VALUES (\"$user\", $date, \"$sub\", $score, $revid, \"$desc\");";
                if($result = mysqli_query($con, $query2)) {
                  echo "Review submitted";
                }
              } else {
                echo "Location does not exist";
              }
            }
        } else {
          echo "All fields are required";
        }
        ?>
        </div>
      </div>
  </body>
</html>
