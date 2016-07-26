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

    <link rel = 'stylesheet' href = './css/location_search.css'/>

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
      <div class='jumbotron'>
        <h2><center>Location Search</center></h2>
          <form action = "" method="POST" role="form">
            <div class = "form-group">
            <?php
              $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");

              $query_location = "SELECT DISTINCT LName FROM Location";
              $result_location = mysqli_query($con, $query_location);
              echo "<label for=\"countrysel\">Country: </label>";
              echo "<select class=\"form-control\" id=\"countrysel\" name=\"location\">";
              echo "<option value = 'empty'></option>";
              while($row = mysqli_fetch_array($result_location)) {
                echo "<option value = '" . $row['LName'] . "'>" . $row['LName'] . "</option>";
              }
              echo "</select> <br />";

              $query_city = "SELECT DISTINCT CityName FROM City";
              $result_city = mysqli_query($con, $query_city);
              echo "<label for=\"citysel\">City: </label>";
              echo "<select class=\"form-control\" id=\"citysel\" name=\"city\">";
              echo "<option value = 'empty'></option>";
              while($row = mysqli_fetch_array($result_city)) {
                echo "<option value = '" . $row['CityName'] . "'>" . $row['CityName'] . "</option>";
              }
              echo "</select> <br />";
             ?>
            </div>
            <div class="form-group">
             <div class = "col-md-2">
             <label for="cost">Cost: </label>
             </div>
             <input type="text" class="form-horizontal" id="cost" name="minimum" placeholder="Minimum"/> to
             <input type="text" class="form-horizontal" id="cost" name="maximum" placeholder="Maximum"/><br />
             </div>
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
              <br/>
              <b>Order By</b>
              <select name="scoresort">
                <option value = 'AvgScore ASC'>Score Ascending</option>
                <option value = 'AvgScore DESC'>Score Descending</option>
                <option value = 'Location.LocationType DESC'>Category</option>
              </select><br />
              <br/>
              <input type="submit" name="submit" value="Search"><br />
              <br/>
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
                      echo "<table class= \"table table-striped\" border=\"1\">";
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

  </body>
</html>
