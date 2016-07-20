<?php

#USE YOUR OWN CREDENTIALS
$db_user = 'root';
$db_password = 'b4rcA2016';
$db_host = 'localhost';
$db_database = 'travelreviews';

$con =  mysqli_connect($db_host, $db_user, $db_password, $db_database);

//Test connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
