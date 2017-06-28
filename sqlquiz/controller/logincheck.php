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
    $row = mysqli_fetch_array($result);

    $count = mysqli_num_rows($result);
    //echo $count;
    if($count == 1) {
        if ($_POST['is_trainer'] == 'yes'){
            $myuid = mysqli_real_escape_string($conn, $row['user_id']);
            $tsql = "SELECT * FROM trainer WHERE user_id = '$myuid'";
            $tresult = mysqli_query($conn,$tsql);
            $tcount = mysqli_num_rows($tresult);
            if($tcount == 1)
                $_SESSION['trainer'] = $_POST['is_trainer'];
            else{
                $_SESSION['msg'] = "Your are not trainer, plz login as student";
                header("location: ../login.php");
                exit;
            }
        }
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['uid'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
//        echo "<h1>login success</h1>";
        header("location: ../index.php");
    }else {
        $_SESSION['msg'] = "Your Login Name or Password is invalid";
        header("location: ../login.php");
    }
}