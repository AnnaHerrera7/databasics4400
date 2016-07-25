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

              $query_country = "SELECT * FROM Location";
              $result_country = mysqli_query($con, $query_country);
              echo "<select name=\"location\">";
              while($row = mysqli_fetch_array($result_country)) {
                echo "<option value = '" . $row['LName'] . "'>" . $row['LName'] . "</option>";
              }
              echo "</select> <br />";

              $query_city = "SELECT * FROM City";
              $result_city = mysqli_query($con, $query_city);
              echo "<select name=\"city\">";
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
              <input type="submit" name="submit" value="Search">
          </form>
          <?php
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
            if(isset($_POST['location'])
              && isset($_POST['city'])
              && isset($_POST['minimum'])
              && isset($_POST['maximum'])
              && isset($_POST['ltype'])) {
                  $loc = $_POST['location'];
                  $city = $_POST['city'];
                  $min = $_POST['minimum'];
                  $max = $_POST['maximum'];
                  $type = $_POST['ltype'];
                  $sql = "SELECT DISTINCT LName, CityName, LocationType, Cost, AVG(Score) AS AvgScore
                          FROM Location, Review RIGHT OUTER JOIN Reviewable ON Review.ReviewableID=Reviewable.ReviewableID
                          WHERE Location.LName = \"$loc\"
                          AND Location.CityName = \"$city\"
                          AND Location.LocationType IN \"$type\"
                          AND Location.Cost BETWEEN \"$min\" AND \"$max\"
                          AND Location.ReviewableID = Reviewable.ReviewableID
                          GROUP BY LName, CityName, LocationType, Cost
                          ORDER BY AvgScore DESC;";
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
                          echo "<td>" . $val[0] . "</td>";
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
