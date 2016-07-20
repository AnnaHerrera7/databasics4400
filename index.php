<?php include 'database.php' ; ?>
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

      <header>
        <nav class = 'navbar navbar-default navbar-fixed-top'>
            <div id = "spy-scroll-id" class = 'container'>
              <ul class="nav navbar-nav navbar-right">
      					<li class = 'active'><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href = "login.php"><i class ="fa fa-user"></i> Login</a></li>
                <li><a href = "signup.php">Sign Up</a></li>
              </ul>
              <a href = '#' class = "pull-left navbar-left"><img id = "logo" src = "./images/gt-logo.png"></a>
            </div>
          </nav>
        </header>
        <div class = 'container text-center' id = 'intro'>
          <h1>Georgia Tech Travel</h1>
          <div class = "panel panel-primary panel-transparent">
              <div class = "panel-heading">
                  <h2 class = 'panel-title'>Trust us. We all need a vacation.</h2>
              </div>
              <div class = "panel-body">
                <p>This site allows fellow Georgia Tech students to post and share
                about their travel experiences. If you want to know the best places to go,
              look nowhere else but here!</p>
                <p> <br /></p>
              <div class = 'btn'>Login</div>
              <div class = 'btn'>Sign Up</div>
              </div>
        </div>
</html>
