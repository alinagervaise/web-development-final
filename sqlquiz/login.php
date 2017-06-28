<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/28
 * Time: 下午3:52
 */

/* TODO
   register button.
*/
session_start();
include("view/bootstrap.php");
?>
<html>
<head>
    <title>login</title>
    <script src="js/signin.js"></script>
    <link href="css/signin.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <form class="form-signin" name="loginForm" method="post" action="controller/logincheck.php">
            <h2 class="form-signin-heading">Please sign in</h2>
    <h4 class="bg-danger"><?php if (isset($_SESSION['msg'])) {echo $_SESSION['msg']; $_SESSION['msg'] = '';} ?></h4>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control"  placeholder="Password" name="pwd" required>
            <div class="checkbox">
                <label><input type="checkbox" name="is_trainer" value="yes"> I am trainer</label>
            </div>
            <input class="btn btn-lg btn-primary btn-block" type="submit" onclick="return check(this)" value="Sign in">
            <a class="btn btn-lg btn-primary btn-block" href="regist.jsp">Register</a>
        </form>

    </div>
</body>
</html>