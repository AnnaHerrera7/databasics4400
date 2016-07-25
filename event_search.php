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
        <h2>Event Search</h2>
          <form action = "" method="POST">
            <?php
              $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");

              $query_country = "SELECT DISTINCT EName FROM Event";
              $result_country = mysqli_query($con, $query_country);
              echo "<select name=\"event\">";
                echo "<option value = 'empty'></option>";
              while($row = mysqli_fetch_array($result_country)) {
                echo "<option value = '" . $row['EName'] . "'>" . $row['EName'] . "</option>";
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
              echo "<input type=\"date\" name=\"edate\"><br />";
             ?>
            
             <b>Cost</b>
             <input type="text" name="minimum" placeholder="Minimum"/> to
             <input type="text" name="maximum" placeholder="Maximum"/><br />
             <b>Student Discount</b>
              <select name="discount">
                <option value = "empty"></option>
                <option value = "1">Yes</option>
                <option value = "0">No</option>
              </select><br />
             <b class="text-center">Category</b>
             <?php
                $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                $query = "SELECT DISTINCT EventType FROM Event";
                $result = mysqli_query($con, $query);
                echo "<fieldset id=\"group1\">";
                while($row = mysqli_fetch_array($result)) {
                    echo "<input type = \"radio\" name=\"etype\" value = '" . $row['EventType'] . "'>" .  $row['EventType'] . "</input><br />";
                }
              ?>
              <b>Sort Review Scores</b>
              <select name="scoresort">
                <option value = 'ASC'>Ascending</option>
                <option value = 'DESC'>Descending</option>
              </select><br />
              <input type="submit" name="submit" value="Search"><br />
          </form>
          <?php
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
            if (isset($_POST['minimum']) && $_POST['minimum'] != ""
              && isset($_POST['maximum']) && $_POST['maximum'] != "") {
                $cost = "Event.Cost BETWEEN ". $_POST['minimum'] ." AND ". $_POST['maximum'] . " AND ";
            } else {
                $cost = "";
            }
            if (isset($_POST['etype']) && $_POST['etype'] != "") {
                $type = "Event.EventType = \"". $_POST['etype'] ."\" AND ";
            } else {
                $type = "";
            }
            if (isset($_POST['edate']) && $_POST['edate'] != "") {
                $date = "Event.Date = \"". $_POST['edate'] ."\" AND ";
            } else {
                $date = "";
            }

            if(isset($_POST['event'])
              && isset($_POST['city'])
              && isset($_POST['discount'])
              /*&& isset($_POST['edate'])
              && isset($_POST['minimum'])
              && isset($_POST['maximum'])
              && isset($_POST['etype'])*/ 
              && isset($_POST['scoresort'])) {
                  /*$eve = $_POST['event'];
                  $city = $_POST['city'];
                  $date = $_POST['edate'];
                  $sdiscount = $_POST['discount'];
                  $min = $_POST['minimum'];
                  $max = $_POST['maximum'];
                  $type = $_POST['etype'];*/
                  if($_POST['event'] == "empty") {
                    $eve = "";
                  } else {
                    $eve = "Event.EName = \"". $_POST['event'] ."\" AND ";
                  }
                  if($_POST['city'] == "empty") {
                    $city = "";
                  } else {
                    $city = "Event.CityName = \"". $_POST['city'] ."\" AND ";
                  }
                  if($_POST['discount'] == "empty") {
                    $sdiscount = "";
                  } else {
                    $sdiscount = "Event.StudentDiscount = \"". $_POST['discount'] ."\" AND ";
                  }
                  $sort = $_POST['scoresort'];
                  $sql = "SELECT DISTINCT Event.EName, Event.CityName, Event.EDate, Event.StartTime, Event.Cost, Event.EventType, AVG(Score) AS AvgScore
                          FROM Event, Review RIGHT OUTER JOIN Reviewable ON Review.ReviewableID=Reviewable.ReviewableID
                          WHERE $eve $city $sdiscount $cost $type                          
                          Event.ReviewableID = Reviewable.ReviewableID
                          GROUP BY Event.EName, Event.CityName, Event.EDate, Event.StartTime, Event.Cost, Event.EventType
                          ORDER BY AvgScore $sort;";
                  $result = mysqli_query($con, $sql);
                  if(mysqli_num_rows($result) > 0) {
                      $_SESSION['location_search'] = $result;
                      //echo "<script>window.location.href='country_search_results.php'</script>";
                      echo "<table class= \"text-center\" border=\"1\">";
                      echo "<tr>";
                          echo "<th> Event Name </th><th> City </th><th> Date </th><th>Start Time</th><th> Cost </th><th>Category</th><th>Average Score</th>";
                      echo "</tr>";
                      while($val = mysqli_fetch_array($result)) {
                          echo "<tr>";
                          echo "<td>" . $val[0] . "</td>";
                          echo "<td>" . $val[1] . "</td>";
                          echo "<td>" . $val[2] . "</td>";
                          echo "<td>" . $val[3] . "</td>";
                          echo "<td>" . $val[4] . "</td>";
                          echo "<td>" . $val[5] . "</td>";
                          echo "<td>" . $val[6] . "</td>";
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
