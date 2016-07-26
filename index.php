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

    <link rel = 'stylesheet' href = './css/index.css'/>

    <script src="https://code.jquery.com/jquery-3.0.0.min.js"
            integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="
            crossorigin="anonymous"></script>

    <script src = "./js/index.js"></script>

    <meta charset ='utf-8'/>
    <title>GTtravel</title>
  </head>
  <body>
    <?php
      $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
     ?>

      <header>
        <nav class = 'navbar navbar-light navbar-fixed-top'>
            <div id = "spy-scroll-id" class = 'container'>
              <ul class="nav navbar-nav navbar-right">
      					<li class = 'active'><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href = "login.php"><i class ="fa fa-user"></i>Login</a></li>
              </ul>
              <a href = '#' class = "pull-left navbar-left"><img id = "logo" src = "./images/LogoMakr.png"></a>
            </div>
          </nav>
        </header>

        <div class = 'container text-center' id = 'intro'>
        <img class="displayed" id = "mainLogo" src = "./images/LogoMakr.png">
          <div class = "panel panel-primary panel-transparent">
              <div class = "panel-heading">
                  <h2 class = 'panel-title'>Time to explore outside The Bubble.</h2>
              </div>
              <div class = "panel-body">
                <p>GT Travel allows fellow Yellow Jackets to post and share stories
                from their travel experiences. If you want to know the best places to go,
                log in and find your new vacation spot. If you are new to GT Travel, we are
                excited to see where you go. Sign up and let us know!</p>
                <p> <br /></p>
              <a href = "login.php"><div class = 'btn'>Login</div></a>
              <a href = "signup.php"><div class = 'btn'>Sign Up</div></a>
              </div>
        </div>
    </body>
</html>
