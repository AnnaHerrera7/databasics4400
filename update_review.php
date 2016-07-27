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

    <link rel = 'stylesheet' href = './css/update_review.css'/>

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
      <div class = "jumbotron">
          <?php
          error_reporting(E_ALL);
          ini_set("display_errors", 1);
          $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
          $review_id = $_GET['id'];
          $date = urldecode($_GET['date']);
          $current_user = $_SESSION['user'];
          echo "<h2> Update Review </h2>";
          $sql = "SELECT RDate, Score, Description, RSubject
                  FROM Review
                  WHERE RDate = \"$date\"
                  AND Review.Username = \"$current_user\"
                  AND Review.ReviewableID = $review_id;";
          $result = mysqli_query($con, $sql) or die(mysqli_error($con));
          if(mysqli_num_rows($result) > 0) {
            $val = mysqli_fetch_array($result);
            $date = $val[0];
            $score = $val[1];
            $desc = $val[2];
            $subject = $val[3];
          } else {
            die("malformed query");
          }
          ?>
          <form action="update_review_action.php" method="POST">
            <div>
              <label for="sub">Subject: </label>
              <input type="text" class="form-control" id="sub" name="subject" value="<?PHP echo $subject; ?>" required>
            </div>
            <div>
              <label for="datepick">Date: </label>
              <input type="date" class="form-control" id="datepick" name="datepick" value="<?PHP echo date('Y-m-d'); ?>" disabled>
            </div>
            <div>
              <label for="desc">Description: </label>
              <textarea class="form-control" rows="5" id="description" name="description" required><?PHP echo $desc; ?></textarea>
            </div>
            <div>
            <br/>
            <label for = "score"> Score: </label>
              <select name="score">
              <?php
              for ($i = 1; $i < 6; $i++) {
                if ($i == $score) {
                  echo "<option value = $i selected=\"selected\">$i</option>";
                } else {
                  echo "<option value = $i>$i</option>";
                }

              }
              ?>
              </select>
            </div>
            <div>
              <input type="hidden" value="<?PHP echo $review_id; ?>" name="id"></input>
              <input type="hidden" value="<?PHP echo $date; ?>" name="date"></input>
            </div>
            <br/>
          <input type="submit" name="submit" value="Submit">
        </form>
      </div>
    </div>
  </body>
</html>
