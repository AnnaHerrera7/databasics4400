<?php
    include 'database_con.php';
    session_start();
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
    $cur_date = date('Y-m-d');
    $old_date = $_POST['date'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $id = $_POST['id'];
    $score = $_POST['score'];
    $user = $_SESSION['user'];
    $sql = "UPDATE Review
            SET RDate=\"$cur_date\", Score=\"$score\", Description=\"$description\",
                RSubject=\"$subject\"
            WHERE RDate=\"$old_date\" AND Username=\"$user\" AND ReviewableID=$id;";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    header("Location: see_reviews.php");

?>
