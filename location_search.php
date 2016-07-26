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
      <div class='jumbotron'>
        <h2>Location Search</h2>
          <form action = "" method="POST">
            <?php
              $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");

              $query_location = "SELECT DISTINCT LName FROM Location";
              $result_location = mysqli_query($con, $query_location);
              echo "<select name=\"location\">";
                echo "<option value = 'empty'></option>";
              while($row = mysqli_fetch_array($result_location)) {
                echo "<option value = '" . $row['LName'] . "'>" . $row['LName'] . "</option>";
              }
              echo "</select> <br />";

              $query_city = "SELECT DISTINCT CityName FROM City";
              $result_city = mysqli_query($con, $query_city);
              echo "<select name=\"city\">";
                echo "<option value = 'empty'></option>";
              while($row = mysqli_fetch_array($result_city)) {
                echo "<option value = '" . $row['CityName'] . "'>" . $row['CityName'] . "</option>";
              }
              echo "</select> <br />";
             ?>

             <b>Cost</b>
             <input type="text" name="minimum" placeholder="Minimum"/> to
             <input type="text" name="maximum" placeholder="Maximum"/><br />
             <b class="text-center">Category</b>
             <?php
                $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                $query = "SELECT DISTINCT LocationType FROM Location";
                $result = mysqli_query($con, $query);
                echo "<fieldset id=\"group1\">";
                while($row = mysqli_fetch_array($result)) {
                    echo "<input type = \"radio\" name=\"ltype\" value = '" . $row['LocationType'] . "'>" .  $row['LocationType'] . "</input><br />";
                }
              ?>
              <b>Order By</b>
              <select name="scoresort">
                <option value = 'AvgScore ASC'>Score Ascending</option>
                <option value = 'AvgScore DESC'>Score Descending</option>
                <option value = 'Location.LocationType DESC'>Category</option>
              </select><br />
              <input type="submit" name="submit" value="Search"><br />
          </form>
          <?php
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
            if (isset($_POST['minimum']) && $_POST['minimum'] != ""
              && isset($_POST['maximum']) && $_POST['maximum'] != "") {
                $cost = "Location.Cost BETWEEN ". $_POST['minimum'] ." AND ". $_POST['maximum'] . " AND ";
            } else {
                $cost = "";
            }
            if (isset($_POST['ltype']) && $_POST['ltype'] != "") {
                $type = "Location.LocationType = \"". $_POST['ltype'] ."\" AND ";
            } else {
                $type = "";
            }
            if (isset($_POST['location'])
              && isset($_POST['city'])
              && isset($_POST['scoresort'])) {
                  if($_POST['location'] == "empty") {
                    $loc = "";
                  } else {
                    $loc = "Location.LName = \"". $_POST['location'] ."\" AND ";
                  }
                  if($_POST['city'] == "empty") {
                    $city = "";
                  } else {
                    $city = "Location.CityName = \"". $_POST['city'] ."\" AND ";
                  }
                  $sort = $_POST['scoresort'];
                  $sql = "SELECT DISTINCT Location.LName, Location.CityName, Location.LocationType, Location.Cost, AVG(Score) AS AvgScore
                          FROM Location, Review RIGHT OUTER JOIN Reviewable ON Review.ReviewableID=Reviewable.ReviewableID
                          WHERE $loc $city $cost $type
                          Location.ReviewableID = Reviewable.ReviewableID
                          GROUP BY Location.LName, Location.CityName, Location.LocationType, Location.Cost
                          ORDER BY $sort;";
                  $result = mysqli_query($con, $sql);
                  if(mysqli_num_rows($result) > 0) {
                      $_SESSION['location_search'] = $result;
                      //echo "<script>window.location.href='country_search_results.php'</script>";
                      echo "<table class= \"text-center\" border=\"1\">";
                      echo "<tr>";
                          echo "<th> Location Name </th><th> City </th><th> Category </th><th>Cost</th><th>Average Score</th>";
                      echo "</tr>";
                      while($val = mysqli_fetch_array($result)) {
                          echo "<tr>";
                          echo "<td><a href=\"location_listing.php?a=$val[0]\">" . $val[0] . "</a></td>";
                          echo "<td>" . $val[1] . "</td>";
                          echo "<td>" . $val[2] . "</td>";
                          echo "<td>" . $val[3] . "</td>";
                          echo "<td>" . $val[4] . "</td>";
                          echo "</tr>";
                      }
                      echo "</table>";
                  } else {
                      echo "No results found!";
                  }
              }
             ?>
      </div>
    </div>

  </body>
</html>
