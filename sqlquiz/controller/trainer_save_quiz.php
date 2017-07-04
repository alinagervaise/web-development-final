<?php

/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/30
 * Time: 下午5:52
 */
include ('dbConfig.php');
session_start();
  
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    $eid = $_PUT['id'];
    $id = mysqli_real_escape_string($conn, $eid);
    $tid = $_PUT['title'];
    $title = mysqli_real_escape_string($conn, $tid);
    $did = $_PUT['db_name'];
    
    $db_name = mysqli_real_escape_string($conn, $did);

    $sid = $_PUT['creation_script_path'];
    $creation_script_path = mysqli_real_escape_string($conn, $sid);
    $dpid = $_PUT['diagram_path'];
    $diagram_path = mysqli_real_escape_string($conn, $dpid);

    $sql = "UPDATE quiz SET"
            . " title= '$title', db_name='$db_name', creation_script_path='$creation_script_path', "
            . "  diagram_path='$diagram_path' WHERE quiz_id = '$id'";
    
    $result = mysqli_query($conn, $sql);
    $sdid = $_PUT['script_data'];
    $script_data = mysqli_real_escape_string($conn, $sdid);
    save_file( $creation_script_path, $script_data);
    
     $ddid = $_PUT['diagram_data'];
    $diagram_data = mysqli_real_escape_string($conn, $ddid);
    save_file( $diagram_path, $diagram_data);
    $_SESSION['msg'] = "Quiz update success";
   
}

function save_file($file_name, $file_data){
    file_put_contents("../uploads/".$file_name, base64_decode($file_data));
}