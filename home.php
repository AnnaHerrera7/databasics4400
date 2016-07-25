<?php
include 'database_con.php';
session_start();
?>
<!DOCTYPE html>
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
      <div class='container text-center'>
          <h1>Time to Explore Outside of the Bubble</h1>
          <h2>Let's help you find a...</h2>
          <ul id="buttons">
              <li><a href="country_search.php">Country</a></li>
              <li><a href="city_search.php">City</a></li>
              <li><a href="location_search.php">Location</a></li>
              <li><a href="event_search.php">Event</a></li>
          </ul>
      </div>
      <?php
      echo $_SESSION['user'];
       ?>
  </body>
</html>
