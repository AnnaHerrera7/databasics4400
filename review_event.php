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
    <div class = "container text-center">
      <div class = "jumbotron">
        <h1>Write a Location Review</h1>
        <h2>Select a Location</h2>
        <form action="" method="POST">
        <?php
          $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");

          $query_country = "SELECT * FROM Country";
          $result_country = mysqli_query($con, $query_country);
          echo "<label for=\"countrysel\">Country</label>";
          echo "<select class=\"form-control\" id=\"countrysel\" name=\"country\" >";
          while($row = mysqli_fetch_array($result_country)) {
            echo "<option value = '" . $row['CountryName'] . "'>" . $row['CountryName'] . "</option>";
          }
          echo "</select> <br />";

          $query_city = "SELECT DISTINCT City.CityName FROM City";
          $result_city = mysqli_query($con, $query_city);
          echo "<label for=\"citysel\">City</label>";
          echo "<select class=\"form-control\" id=\"citysel\" name=\"cities\">";
          while($row = mysqli_fetch_array($result_city)) {
            echo "<option value = '" . $row['CityName'] . "'>" . $row['CityName'] . "</option>";
          }
          echo "</select> <br />";

          $query_location = "SELECT DISTINCT LName FROM Location";
              $result_location = mysqli_query($con, $query_location);
              echo "<label for=\"locsel\">Location</label>";
              echo "<select class=\"form-control\" id=\"locsel\" name=\"location\">";
              while($row = mysqli_fetch_array($result_location)) {
                echo "<option value = '" . $row['LName'] . "'>" . $row['LName'] . "</option>";
              }
              echo "</select> <br />";
          $query_event = "SELECT DISTINCT EName FROM Event";
              $result_event = mysqli_query($con, $query_event);
              echo "<label for=\"eventsel\">Location</label>";
              echo "<select class=\"form-control\" id=\"eventsel\" name=\"event\">";
              while($row = mysqli_fetch_array($result_event)) {
                echo "<option value = '" . $row['EName'] . "'>" . $row['EName'] . "</option>";
              }
              echo "</select> <br />";
              echo "<input type=\"date\" name=\"edate\"><br />";
              echo "<input type=\"time\" name=\"etime\"><br />";
         ?>
          Subject <input type="text" name="subject" required/><br />
          Description <input type="text" name="description" required/><br />
          Score
              <select name="score">
                <option value = 1>1</option>
                <option value = 2>2</option>
                <option value = 3>3</option>
                <option value = 4>4</option>
                <option value = 5>5</option>
              </select><br />
          <input type="submit" name="submit" value="Submit">
        </form>
        <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
        if(isset($_POST['country']) 
          && isset($_POST['cities'])
          && isset($_POST['location'])
          && isset($_POST['event'])
          && isset($_POST['subject'])
          && isset($_POST['score'])
          && isset($_POST['description'])
          && isset($_SESSION['user'])
          && isset($_POST['edate'])
          && isset($_POST['etime'])) {
            $country = $_POST['country'];
            $city = $_POST['cities'];
            $loc = $_POST['location'];
            $eve = $_POST['event'];
            $sub = $_POST['subject'];
            $score = $_POST['score'];
            $desc = $_POST['description'];
            $user = $_SESSION['user'];
            $date = $_POST['edate'];
            $time = $_POST['etime'];
            $query1 = "SELECT Location.Address 
            FROM Location 
            WHERE Location.LName = \"$loc\" AND Location.CityName = \"$city\" AND Location.CountryName = \"$country\";";
            if($result1 = mysqli_query($con, $query1)) {
              if(mysqli_num_rows($result1) == 1) {
                $address_array=mysqli_fetch_assoc($result1);
                $address=$address_array['Address'];
                $query2 = "SELECT Event.ReviewableID 
                FROM Event 
                WHERE Event.EName = \"$eve\" AND Event.Address = \"$address\"
                AND Event.CityName = \"$city\" AND Event.CountryName = \"$country\"
                AND Event.EDate = \"$date\" AND Event.StartTime = \"$time\";";
                if($my_revid = mysqli_query($con, $query2)) {
                  if(mysqli_num_rows($my_revid) == 1) {
                    $my_revid_array=mysqli_fetch_assoc($my_revid);
                    $revid=$my_revid_array['ReviewableID'];
                    $query3 = "INSERT INTO Review (Username, RDate, RSubject, Score, ReviewableID, Description)
                    VALUES (\"$user\", $date, \"$sub\", $score, $revid, \"$desc\");";
                    if($result = mysqli_query($con, $query3)) {
                      echo "Review submitted";
                    }
                  } else {
                    echo "Event does not exist";
                  }
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