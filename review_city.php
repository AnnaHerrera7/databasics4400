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
        <h1>Write a City Review</h1>
        <h2>Select a City</h2>
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
          && isset($_POST['subject'])
          && isset($_POST['score'])
          && isset($_POST['description'])
          && isset($_SESSION['user'])) {
            $country = $_POST['country'];
            $city = $_POST['cities'];
            $sub = $_POST['subject'];
            $score = $_POST['score'];
            $desc = $_POST['description'];
            $user = $_SESSION['user'];
            $date = date('m/d/Y');
            $query1 = "SELECT City.ReviewableID 
            FROM City 
            WHERE City.CityName = \"$city\" AND City.CountryName = \"$country\";";
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
                echo "City does not exist";
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