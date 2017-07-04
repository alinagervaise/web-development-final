<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/7/4
 * Time: 下午6:37
 */

include("dbConfig.php");
session_start();

$eid = $_GET['eid'];

$timezone = date_default_timezone_get();
//echo "The current server timezone is: " . $timezone;
date_default_timezone_set($timezone);
$date = date('Y-m-d h:i:s', time());

$eeid = mysqli_real_escape_string($conn, $eid);
$uid = mysqli_real_escape_string($conn, $_SESSION['uid']);
$time = mysqli_real_escape_string($conn, $date);
$sql = "UPDATE test SET completed_at = '$time' WHERE evaluation_id = $eid and student_id = $uid;";
echo $sql;
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('submit successfully')</script>";
    header("Location:../student.php");
} else {
    echo "<h4>Ops, something went wrong.</h4>";
    printf("Error: %s\n", mysqli_error($conn));
    echo "<script>alert('submit error')</script>";
    header("Location:../student.php");
}