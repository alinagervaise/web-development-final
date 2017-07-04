<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/30
 * Time: 下午5:52
 */

include ('dbConfig.php');

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    
    $eid = $_GET['id'];
    $eeid = mysqli_real_escape_string($conn,$eid);
    $qid = $_GET['qid'];
    $qqid = mysqli_real_escape_string($conn,$qid);
    $uid = $_GET['uid'];
    $uuid = mysqli_real_escape_string($conn,$uid);

    $sql = "SELECT * FROM sql_question WHERE question_id = '$qqid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo "<h3>Q: ".$row['question_text']."</h3>";
    $answer = "answer here";
    echo "<textarea class='form-control' id='answer' rows='5'>".$answer."</textarea>";
    echo "<button onclick='sendAnswer(".$qid.")' style='float: right'><h3>Validate and Next</h3></button>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $eid = $_POST['id'];
    $eeid = mysqli_real_escape_string($conn,$eid);
    $qid = $_POST['qid'];
    $qqid = mysqli_real_escape_string($conn,$qid);
    $uid = $_POST['uid'];
    $uuid = mysqli_real_escape_string($conn,$uid);
    $query = $_POST['q'];
    $qquery = mysqli_real_escape_string($conn,$query);
    $quizid = $_POST['quizid'];
    $qquizid = mysqli_real_escape_string($conn,$quizid);

    $sql = "INSERT INTO sql_answer (question_id, student_id, evaluation_id, query,is_validated,gives_correct_result) 
                            VALUES ('$qqid', '$uuid', '$eeid', '$qquery', 0, 0)";
    if(mysqli_query($conn, $sql)){
        getQuestion($qqid, $qquizid, $conn);
    } else{
        $sql = "UPDATE sql_answer SET query='$qquery' where question_id='$qqid' and student_id='$uuid' and evaluation_id='$eeid'";
        if (mysqli_query($conn, $sql))
            getQuestion($qqid, $qquizid, $conn);
        else
            echo "<h3><span class=\"label label-danger\">Exam finished, you are no longer allowed to submit any answer.</span></h3>";
    }
}

function getQuestion($qid, $qzid, $con){
    $tsql = "SELECT * FROM quiz_question where question_id='$qid' AND quiz_id='$qzid'";
    $tresult = mysqli_query($con, $tsql);
    $trow = mysqli_fetch_array($tresult);
    $rank = $trow['rank'] + 1;
    $srank = mysqli_escape_string($con, $rank);
    $tsql = "SELECT * FROM quiz_question where rank='$srank' AND quiz_id='$qzid'";
    $tresult = mysqli_query($con, $tsql);
    $trow = mysqli_fetch_array($tresult);
    $tqid = $trow['question_id'];
    $tqqid = mysqli_real_escape_string($con,$tqid);
    $tsql = "SELECT * FROM sql_question WHERE question_id = '$tqqid'";
    $tresult = mysqli_query($con, $tsql);
    if ($trow = mysqli_fetch_array($tresult)){
        echo "<h3>Q: ".$trow['question_text']."</h3>";
        $tanswer = "answer here";
        echo "<textarea class='form-control' id='answer' rows='5'>".$tanswer."</textarea>";
        echo "<button onclick='sendAnswer(".$tqid.")' style='float: right'><h3>Validate and Next</h3></button>";
    } else {
        echo "<h3>It seems you have finished.</h3>";
        echo "<button onclick='sendAnswer(".$tqid.")' class=\"btn btn-lg btn-primary\" style='width: 120px;'><h3>Submit</h3></button>";
    }
}