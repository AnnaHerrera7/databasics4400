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

    <script src="https://code.jquery.com/jquery-3.0.0.min.js"
            integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="
            crossorigin="anonymous"></script>

    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <!-- <script src = "./js/signup.js"></script> -->


    <meta charset ='utf-8'/>
    <title>GTtravel</title>
  </head>
  <body>
    <div class = "container text-left">
      <div class = "jumbotron">
        <h2><center>Add a City</center></h2>
        <form action = "" method="POST" role="form">

            <div class="form-group">
              <label for="cityin">City Name</label>
              <input type="text" class="form-control" id="cityin" name="city" placeholder="(e.g. Barcelona)">
            </div>
            <div class="form-group">
            <?php
              $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");

              $query_country = "SELECT * FROM Country";
              $result_country = mysqli_query($con, $query_country);
              echo "<label for=\"countrysel\">Country</label>";
              echo "<select class=\"form-control\" id=\"countrysel\" name=\"country\" >";
              echo "<option value =\"empty\">Select Country</option>";
              while($row = mysqli_fetch_array($result_country)) {
                echo "<option value = '" . $row['CountryName'] . "'>" . $row['CountryName'] . "</option>";
              }
              echo "</select>";
             ?>
             </div>
              <div class="form-group row">
                <label for="latitude" class="col-md-1 control-label">Latitude</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="lat" id="latitude" placeholder="0 0 N">
                </div>
                <label for="longitude" class="col-md-1 control-label">Longitude</label>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="lon" id="longitude" placeholder="0 0 E">
                </div>
              </div>

<!--               <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email">
              </div> -->

             <div class="form-group">
              <label for="pop">Population</label>
        <!--      <b>Population</b> -->
             <!-- <input type="range" name="points" min="0" max="10"> -->
              <input type="number" class="form-control" min="0" id="pop" name="pop" placeholder="Enter a number"/><br />
            </div>
            <div class="form-group row">
                <label for="latitude" class="col-md-1 control-label">Capital?</label>
                <label><input type="radio" value="0" name="capital">No</label>
                <label><input type="radio" value="1" name="capital">Yes</label>
            </div>
             <b class="text-center">City Languages</b>
             <?php
                $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                $query = "SELECT * FROM Languages";
                $result = mysqli_query($con, $query);
                echo "<fieldset id=\"group1\">";
                while($row = mysqli_fetch_array($result)) {
                    echo "<input type = \"checkbox\" name=\"language[]\" value = '" . $row['LanguageName'] . "'>" .  $row['LanguageName'] . "</input><br />";
                }
                echo "</fieldset>"
              ?>

            <input type="submit" name="submit" value="Add City">
        </form>
        <?php
        // Adding the city to the database
          error_reporting(E_ALL);
          ini_set("display_errors", 1);
          if (isset($_POST['city']) && $_POST['city'] != ""
            && isset($_POST['country']) && $_POST['country'] != "empty"
            && isset($_POST['lat']) && $_POST['lat'] != ""
            && isset($_POST['lon']) && $_POST['lon'] != ""
            && isset($_POST['pop'])
            && isset($_POST['capital'])
            && isset($_POST['language']) && count($_POST['language']) > 0)  {
              $city = $_POST['city'];
              $country = $_POST['country'];
              $lat = $_POST['lat'];
              $lon = $_POST['lon'];
              $pop = $_POST['pop'];
              $lang = $_POST['language'];
              // TAKE OUT LATER
              $_SESSION['user'] = "origin";
              $user = $_SESSION['user'];
              $capital = $_POST['capital'];
              $lang_insert = "";
              foreach ($lang as $language) {
                $lang_insert = $lang_insert . "INSERT INTO CityLanguage VALUES (\"$country\", \"$city\", \"$language\");";
              }
              $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
              $query = "INSERT INTO Reviewable SELECT 1 + MAX(ReviewableID) FROM Reviewable; INSERT INTO City VALUES (\"$city\", \"$country\", \"$lat\", \"$lon\", \"$user\", (SELECT MAX(ReviewableID) FROM Reviewable), $capital, $pop); $lang_insert";
              $result_country = mysqli_multi_query($con, $query) or die(mysqli_error($con));
              echo '<script language="javascript">';
              echo 'alert("City Added!")';
              echo '</script>';
          }
        ?>
      </div>
    </div>
  </body>
</html>
