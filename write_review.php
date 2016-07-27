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

    <link rel = 'stylesheet' href = './css/write_review.css'/>

    <meta charset ='utf-8'/>
    <title>GTtravel</title>
  </head>
  <body>
      <header>
        <nav class = 'navbar navbar-light navbar-fixed-top'>
          <div id = "spy-scroll-id" class = 'container'>
              <ul class="nav navbar-nav navbar-right">
              <li class = 'active'><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
              <li><a href = "home.php"><i class ="fa fa-user"></i> <?php echo $_SESSION['user']; ?></a></li>
              </ul>
              <a href = '#' class = "pull-left navbar-left"><img id = "logo" src = "./images/LogoMakr.png"></a>
              <ul class="nav navbar-nav navbar-left">
                <li><a href = "country_search.php"><i class="fa fa-globe"></i> Country</a></li>
                <li><a href = "city_search.php"><i class="fa fa-building-o"></i> City</a></li>
                <li><a href = "location_search.php"><i class="fa fa-map-marker"></i> Location</a></li>
                <li><a href = "event_search.php"><i class="fa fa-calendar"></i> Event</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class = "fa fa-pencil"></i> Reviews <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="review_city.php">Review a City</a></li>
                    <li><a href="review_event.php">Review an Event</a></li>
                    <li><a href="review_location.php">Review a Location</a></li>
                    <li><a href="see_reviews.php">See All Reviews</a></li>
                  </ul>
                </li>
              </ul>
          </div>
        </nav>
      </header>

    <div class = "container text-center">
      <div class = "jumbotron">
        <h1>Write a Review</h1>
        <form action="" method="POST">
          <label for "subject">Subject: </label>
          <input class = "form-control" type="text" name="subject" required/><br />
          <label for "subject">Description: </label>
          <input class = "form-control" type="text" name="description" required/><br />
          <label for = "select">Score: </label>
              <select name="score">
                <option value = 1>1</option>
                <option value = 2>2</option>
                <option value = 3>3</option>
                <option value = 4>4</option>
                <option value = 5>5</option>
              </select><br />
              <br/>
          <input type="submit" name="submit" value="Submit">
        </form>
        <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
        $revid = $_GET['a'];
        if (isset($_POST['subject'])
          && isset($_POST['score'])
          && isset($_POST['description'])
          && isset($_SESSION['user'])) {
            $sub = $_POST['subject'];
            $score = $_POST['score'];
            $desc = $_POST['description'];
            $user = $_SESSION['user'];
            $date = date('m/d/Y');
            $query2 = "INSERT INTO Review (Username, RDate, RSubject, Score, ReviewableID, Description)
            VALUES (\"$user\", $date, \"$sub\", $score, $revid, \"$desc\");";
            if($result = mysqli_query($con, $query2)) {
              echo "Review submitted";
            }
        } else {
          echo "All fields are required";
        }
        ?>
        </div>
      </div>
  </body>
</html>