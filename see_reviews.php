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
        <h2>See All Reviews</h2>
          <?php
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
            if(isset($_SESSION['user'])) {
                  $user = $_SESSION['user'];
                  $sql = "SELECT Review.RSubject, Review.RDate, Review.Score, Review.Description, Review.ReviewableID
                    FROM Review
                  WHERE Review.Username = \"$user\";";
                  $result = mysqli_query($con, $sql);
                  if(mysqli_num_rows($result) > 0) {
                      $_SESSION['user_reviews'] = $result;
                      //echo "<script>window.location.href='country_search_results.php'</script>";
                      echo "<table class= \"text-center\" border=\"1\">";
                      echo "<tr>";
                          echo "<th>Subject</th><th>Date</th><th>Score</th><th>Description</th>";
                      echo "</tr>";
                      while($val = mysqli_fetch_array($result)) {
                          $date = urlencode($val[1]);
                          echo "<tr>";
                          echo "<td><a href = \"update_review.php?id=$val[4]&date=$date\">" . $val[0] . "</td>";
                          echo "<td>" . $val[1] . "</td>";
                          echo "<td>" . $val[2] . "</td>";
                          echo "<td>" . $val[3] . "</td>";
                          echo "</tr>";
                      }
                      echo "</table>";
                  } else {
                      echo "You have not written any reviews";
                  }
              }
             ?>
      </div>
    </div>

  </body>
</html>
