<?php

#USE YOUR OWN CREDENTIALS
$db_user = 'admin';
$db_password = 'b4rcA2016';
$db_host = 'ec2-54-191-75-254.us-west-2.compute.amazonaws.com';
$db_database = 'cs4400';

$con =  mysqli_connect($db_host, $db_user, $db_password, $db_database);

//Test connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
