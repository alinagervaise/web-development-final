<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/28
 * Time: 下午4:05
 */

include("dbConfig.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $myusername = mysqli_real_escape_string($conn,$_POST['email']);
    $mypassword = mysqli_real_escape_string($conn,$_POST['pwd']);

    $sql = "SELECT * FROM user WHERE email = '$myusername' and pwd = '$mypassword'";
    $result = mysqli_query($conn,$sql);

    $count = mysqli_num_rows($result);
    //echo $count;
    if($count == 1) {
        $_SESSION['login_user'] = $_POST['email'];
//        echo "<h1>login success</h1>";
        header("location: ../index.php");
    }else {
        $_SESSION['msg'] = "Your Login Name or Password is invalid";
        header("location: ../login.php");
    }
}