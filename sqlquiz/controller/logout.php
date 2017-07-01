<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  if (! isset($_SESSION['uid'])){
        
        session_start() ;
        session_destroy();
        $_SESSION['msg'] = "You have been logout successfully.";
        header("location: ../login.php");
       
    }


?>

