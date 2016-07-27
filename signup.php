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

    <link rel = 'stylesheet' href = './css/signup.css'/>

    <script src="https://code.jquery.com/jquery-3.0.0.min.js"
            integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="
            crossorigin="anonymous"></script>

    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src = "./js/signup.js"></script>


    <meta charset ='utf-8'/>
    <title>GTtravel</title>
  </head>
  <body>

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

    <div class = "container">
      <div class = "jumbotron">
        <img class="displayed" id = "mainLogo" src = "./images/LogoMakr.png">
        <h2 class = "text-center">Welcome to GT Travel!</h2>
        <?php
          error_reporting(E_ALL);
          ini_set("display_errors", 1);
          $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
          if(isset($_POST['user'])
             && isset($_POST['password'])
             && isset($_POST['cfmPassword'])
             && isset($_POST['email'])
             && isset($_POST['typeOfUser'])) {
               $username = $_POST['user'];
               $password = $_POST['password'];
               $confirm = $_POST['cfmPassword'];
               $email = $_POST['email'];
               $type = $_POST['typeOfUser'];
               $query_user = "SELECT * FROM Users WHERE Username=\"$username\"";
               $result_user = mysqli_query($con, $query_user) or die(mysqli_error());
               $num_users = mysqli_num_rows($result_user);
               if($num_users != 0) {
                  echo "Username already exists!";
               } elseif ($type == 1 && strpos($email, '@gttravel.com') === false) {
                  echo '<script language="javascript">';
                  echo 'alert("Email is not valid for Manager Signup")';
                  echo '</script>';
               }
               else {
                  $hashed = password_hash($password, PASSWORD_DEFAULT);
                  $add_user = "INSERT INTO Users VALUES (\"$username\", \"$email\", \"$hashed\", $type);";
                  $result_user = mysqli_query($con, $add_user) or die(mysqli_error($con));
                  $_SESSION['user'] = $username;
                  if($type == 0) {
                    echo "<script>window.location.href='home.php'</script>";
                  } else if($type == 1) {
                    echo "<script>window.location.href='add_city.php'</script>";
                  }
               }
             }
         ?>
          <form class = "form-horizotal" action="" method="POST" id ="new_user">
            <div class="form-group">
              <div class = "col-md-4 col-md-offset-2">
                <label for="user">Username:</label>
              </div>
              <div class = "col-md-6">
              <input type="text" class ="form-horizontal" id="user" name="user">
              </div>
            </div>
            <div class="form-group">
              <div class = "col-md-4 col-md-offset-2">
              <label for="password">Password:</label>
              </div>
              <div class = "col-md-6">
              <input type="password" class ="form-horizontal" id="password" name="password">
              </div>
            </div>
            <div class="form-group">
              <div class = "col-md-4 col-md-offset-2">
              <label for="cfmPassword">Confirm Password:</label>
              </div>
              <div class = "col-md-6">
              <input type="password" class ="form-horizontal" id="cfmPassword" name="cfmPassword">
              </div>
            </div>
            <div class="form-group">
              <div class = "col-md-4 col-md-offset-2">
              <label for="email">Email:</label>
              </div>
              <div class = "col-md-6">
              <input type="text" class ="form-horizontal" id="email" name="email">
              </div>
            </div>
            <div class = "text-center">
              <label class="radio-inline">
                <input type="radio" name="typeOfUser" id="user_radio" value="0"> I am a User
              </label>
              <label class="radio-inline ">
                <input type="radio" name="typeOfUser" id="manager_radio" value="1"> I am a Manager
              </label>
            </div>
            <div class = "form-group text-center">
              <input type="submit" name="submit" value="Start Traveling!">
            </div>
          </form>
      </div>
    </div>
  </body>
</html>
