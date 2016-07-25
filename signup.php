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

    <script src="https://code.jquery.com/jquery-3.0.0.min.js"
            integrity="sha256-JmvOoLtYsmqlsWxa7mDSLMwa6dZ9rrIdtrrVYRnDRH0="
            crossorigin="anonymous"></script>

    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src = "./js/signup.js"></script>


    <meta charset ='utf-8'/>
    <title>GTtravel</title>
  </head>
  <body>
    <div class = "container text-center">
      <div class = "jumbotron">
        <h2>Welcome to GT Travel</h2>
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
               }
             }
         ?>
         <form action="" method="POST" id="new_user">
           Username: <input type="text" name="user" placeholder="Username" required/><br />
           Password: <input type="text" name="password" placeholder="Password" id="password" required/><br />
           Confirm Password: <input type="text" name="cfmPassword"
                                    placeholder="Confirm Password" id="cfmPassword" required/><br />
           Email: <input type="text" name="email" placeholder="Email" required/><br />
           User <input type="radio" value = "0" name="typeOfUser" />
           Manager <input type="radio" value = "1" name="typeOfUser" /><br />
           <input type="submit" name="submit" value="Sign Up">
         </form>
      </div>
    </div>
  </body>
</html>
