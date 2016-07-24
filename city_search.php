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
        <h2>City Search</h2>
          <form action = "" method="POST">
            <?php
              $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");

              $query_country = "SELECT * FROM Country";
              $result_country = mysqli_query($con, $query_country);
              echo "<select name=\"country\">";
              while($row = mysqli_fetch_array($result_country)) {
                echo "<option value = '" . $row['CoName'] . "'>" . $row['CoName'] . "</option>";
              }
              echo "</select> <br />";

              $query_city = "SELECT * FROM City";
              $result_city = mysqli_query($con, $query_city);
              echo "<select name=\"cities\">";
              while($row = mysqli_fetch_array($result_city)) {
                echo "<option value = '" . $row['CName'] . "'>" . $row['CName'] . "</option>";
              }
              echo "</select> <br />";
             ?>
             <b>Population</b>
             <input type="text" name="minimum" placeholder="Minimum"/> to
             <input type="text" name="maximum" placeholder="Maximum"/><br />
             <b class="text-center">City Languages</b>
             <?php
                $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                $query = "SELECT * FROM Languages";
                $result = mysqli_query($con, $query);
                echo "<fieldset id=\"group1\">";
                while($row = mysqli_fetch_array($result)) {
                    echo "<input type = \"radio\" name=\"language\" value = '" . $row['LanguageName'] . "'>" .  $row['LanguageName'] . "</input><br />";
                }
              ?>
              <input type="submit" name="submit" value="Search">
          </form>
      </div>
    </div>

  </body>
</html>
