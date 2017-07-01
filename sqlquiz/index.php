<?php
    session_start();
    if (! isset($_SESSION['uid'])){
        $_SESSION['msg'] = "Plz login first";
        header("location: login.php");
    } else {
        if ($_SESSION['trainer'] == 'yes')
            header("location: trainer.php");
        else
            header("location: student.php");
    }
?>