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

    <link rel = 'stylesheet' href = './css/login.css'/>

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

    <div class = "container text-center">
      <div class = "jumbotron">
        <a href = '#' class = "img-responsive "><img id = "mainLogo" src = "./images/LogoMakr.png"></a>
        <h1>Login</h1>
        <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
        if(isset($_POST['user']) && isset($_POST['password'])) {
            $username = $_POST['user'];
            $pass = $_POST['password'];
            $query = "SELECT * FROM Users WHERE Username=\"$username\"
                                                and UPassword =\"$pass\"
                                                and IsManager = 0";
            if($result = mysqli_query($con, $query)) {
              if(mysqli_num_rows($result) == 1) {
                $_SESSION['user'] = $username;
                echo "<script>window.location.href='home.php'</script>";
              } else {
                echo "wrong credentials";
              }
            }
        } else {
          echo "All fields are required";
        }
        ?>
          <form class = "form-horizotal" action="" method="POST">
            <div class="form-group">
              <label for="username_input">Username:</label>
              <input type="text" class ="form-horizontal" id="username_input">
            </div>
            <div class="form-group">
              <label for="password_input">Password:</label>
              <input type="text" class ="form-horizontal" id="password_input">
            </div>
            <input type="submit" name="submit" value="Sign in">
          </form>
          <a href="signup.php">New to GT Travel? Sign up here! </a>
        </div>
      </div>
  </body>
</html>
