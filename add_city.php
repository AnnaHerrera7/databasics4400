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
    <div class = "container text-center">
      <div class = "jumbotron">
        <h2>Welcome to GT Travel</h2>
        <form action = "" method="POST" role="form">
            <div class="form-group">
            <?php
              $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");

              $query_country = "SELECT * FROM Country";
              $result_country = mysqli_query($con, $query_country);
              echo "<label for=\"countrysel\">Country</label>";
              echo "<select class=\"form-control\" id=\"countrysel\" name=\"country\" >";
              echo "<option value =\"empty\"></option>";
              while($row = mysqli_fetch_array($result_country)) {
                echo "<option value = '" . $row['CountryName'] . "'>" . $row['CountryName'] . "</option>";
              }
              echo "</select> <br />";

              $query_city = "SELECT * FROM City";
              $result_city = mysqli_query($con, $query_city);
              echo "<label for=\"citysel\">City</label>";
              echo "<select class=\"form-control\" id=\"citysel\" name=\"cities\">";
              echo "<option value =\"empty\"></option>";
              while($row = mysqli_fetch_array($result_city)) {
                echo "<option value = '" . $row['CityName'] . "'>" . $row['CityName'] . "</option>";
              }
              echo "</select> <br />";
             ?>
             </div>
             <div class="form-group">
              <label for="pop">Population</label>
        <!--      <b>Population</b> -->
             <!-- <input type="range" name="points" min="0" max="10"> -->
              <input type="number" class="form-control" id="pop" name="minimum" placeholder="Minimum"/> to
              <input type="number" class="form-control" id="pop" name="maximum" placeholder="Maximum"/><br />
            </div>
             <b class="text-center">City Languages</b>
             <?php
                $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                $query = "SELECT * FROM Languages";
                $result = mysqli_query($con, $query);
                echo "<fieldset id=\"group1\">";
                while($row = mysqli_fetch_array($result)) {
                    echo "<input type = \"radio\" name=\"language\" value = '" . $row['LanguageName'] . "'>" .  $row['LanguageName'] . "</input><br />";
                }
                echo "</fieldset>"
              ?>


            <input type="submit" name="submit" value="Search">
        </form>
      </div>
    </div>
  </body>
</html>
