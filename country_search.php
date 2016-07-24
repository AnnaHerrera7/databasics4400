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
        <div class="jumbotron">
          <h2>Country Search</h2>
          <?php
          $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
          if(isset($_POST['country'])
            && isset($_POST['minimum'])
            && isset($_POST['maximum'])
            && isset($_POST['language'])) {
                echo $_POST['language'];
            }
           ?>
            <form action="" method="POST">
              <?php
                  $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                  $query = "SELECT * FROM Country";
                  $result = mysqli_query($con, $query);
                  echo "<select name=\"country\">";
                  while($row = mysqli_fetch_array($result)) {
                    echo "<option value = '" . $row['CoName'] . "'>" . $row['CoName'] . "</option>";
                  }
                  echo "</select>";
               ?>
               <br />
               <b>Population</b>
               <input type="text" name="minimum" placeholder="Minimum"/> to
               <input type="text" name="maximum" placeholder="Maximum"/><br />
               <b class="text-center">Languages</b>
               <?php
                  $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                  $query = "SELECT * FROM Languages";
                  $result = mysqli_query($con, $query);
                  echo "<fieldset id=\"languages\">";
                  while($row = mysqli_fetch_array($result)) {
                      echo "<input type = \"radio\" name=\"language\" value = '" . $row['LanguageName'] . "'>" .  $row['LanguageName'] . "</input><br />";
                  }
                ?>
                <input type="submit" name="submit" value="Search">
            </form>
  </body>
</html>
