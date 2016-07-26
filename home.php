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

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"
          rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1"
          crossorigin="anonymous">

    <link rel = 'stylesheet' href = './css/home.css'/>


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
                    <li><a href="see_reviews.php">See all Reviews</a></li>
                  </ul>
                </li>
              </ul>
          </div>
        </nav>
      </header>

      <div class='container text-center'>
      <div class = "jumbotron">
          <h1>Time to Explore Outside of the Bubble</h1>
          <h2>Let's help you find a...</h2>
          <div class = "btn-group">
            <a class="btn btn-default" href="country_search.php">Country</a>
            <a class="btn btn-default" href="city_search.php">City</a>
            <a class="btn btn-default" href="location_search.php">Location</a>
            <a class="btn btn-default" href="event_search.php" id="event">Event</a>
          </div>
          <h4>Pick one of the following in order to begin your search.</h4>
      </div>
      </div>
  </body>
</html>
