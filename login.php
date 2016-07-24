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
    <div class = "container text-center">
      <div class = "jumbotron">
        <h1>Travel Reviews</h1>
        <h2>Login</h2>
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
          <form action="" method="POST">
            Username: <input type="text" name="user" required/><br />
            Password: <input type="text" name="password" required/><br />
            <input type="submit" name="submit" value="Sign in">
          </form>
          <a href="signup.php">New to GT Travel? Sign up here! </a>
        </div>
      </div>
  </body>
</html>
