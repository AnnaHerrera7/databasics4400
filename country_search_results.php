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
        <h2>Country Search Results</h2>
          <p>Select a Country to see more about it!</p>
          <?php
            $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            $result = $_SESSION['country_search'];
            if(isset($result)) {
              $num = mysqli_num_rows($_SESSION['country_search']);

            }
            echo "<table>";
            echo "<tr>";
            $count = 0;

           ?>
      </div>
    </div>
  </body>
</html>
