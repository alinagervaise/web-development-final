<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/30
 * Time: 上午12:22
 */

session_start();
include('controller/dbConfig.php');

$timezone = date_default_timezone_get();
date_default_timezone_set($timezone);
$date = date('Y-m-d h:i:s', time());
$eid = mysqli_real_escape_string($conn,$_GET['id']);
$uid = mysqli_real_escape_string($conn,$_SESSION['uid']);
$time = mysqli_real_escape_string($conn,$date);
$sql = "INSERT INTO test (student_id, evaluation_id, started_at)VALUES($uid, $eid, '$date')";
if (! mysqli_query($conn, $sql)) {
    $sql = "SELECT * FROM test where student_id = $uid and evaluation_id = $eid";
    $rs = mysqli_query($conn, $sql);
    $rw = mysqli_fetch_array($rs);
    if ($rw['completed_at'] != ''){
        echo "<script>alert('You have already submitted your work');</script>";
        echo "<script>window.location.href = 'evaluation.php?id=".$_GET['id']."'</script>";
    }
}

$esql = "SELECT * FROM evaluation WHERE evaluation_id = '$eid'";
$eresult = mysqli_query($conn,$esql);
$erow = mysqli_fetch_array($eresult);

$qid = mysqli_real_escape_string($conn,$erow['quiz_id']);
$qsql = "SELECT * FROM quiz WHERE quiz_id = '$qid'";
$qresult = mysqli_query($conn,$qsql);
$qrow = mysqli_fetch_array($qresult);

$qssql = "SELECT * FROM quiz_question WHERE quiz_id = '$qid'";
$qsresult = mysqli_query($conn,$qssql);

if (!$qsresult) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quiz</title>
    <?php include("view/bootstrap.php");?>
    <script>

        var array = [];
        var seconds = localStorage.getItem('seconds');
        function submit() {
            if(seconds > 0){
                if (confirm('Are you sure you want to submit?')){
                    window.location.href = 'controller/quizSave.php?eid=<?php echo $_GET['id']; ?>&uid=<?php echo $_SESSION['uid']; ?>';
                    localStorage.clear();
                }
            } else {
                window.location.href = 'controller/quizSave.php?eid=<?php echo $_GET['id']; ?>&uid=<?php echo $_SESSION['uid']; ?>';
                localStorage.clear();
            }
        }

        if (seconds == null)
            seconds = 60 * <?php echo $erow['nb_minutes'];?>;
        function secondPassed() {
            var minutes = Math.round((seconds - 30)/60);
            var remainingSeconds = seconds % 60;
            if (remainingSeconds < 10) {
                remainingSeconds = "0" + remainingSeconds;
            }
            document.getElementById('timmer').innerHTML = minutes + ":" + remainingSeconds;
            if (seconds <= 0) {
                clearInterval(countdownTimer);
                document.getElementById('timmer').innerHTML = "Buzz Buzz";
                localStorage.clear();
                alert("timeup, auto submit!");
                submit();
            } else {
                seconds--;
                localStorage.setItem("seconds", seconds);
            }
        }

        var countdownTimer = setInterval('secondPassed()', 1000);

        function getQuestion(id){
            var xhr = new XMLHttpRequest();
            var str = "id=<?php echo $erow['evaluation_id']; ?>";
            str += "&qid=";
            str += id;
            str += "&uid=<?php echo $_SESSION['uid']?>";
            xhr.open('GET', 'controller/quizGet.php?' + str, true);
            xhr.send(str);
            //alert("clicked");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200){
                    var display = document.getElementById("question");
                    display.innerHTML = xhr.responseText;
                    banid = "btn" + id;
                    var banners = document.getElementsByClassName("banner");
                    for (var i = 0; i < banners.length; i++){
                        banners[i].classList.remove("btn-primary");
                        if (array.includes(banners[i].id))
                            banners[i].classList.add("btn-success");
                    }
                    var banner = document.getElementById(banid);
                    banner.classList.add("btn-primary");
                    banner.classList.remove("btn-success");
                }
            }
        }

        function sendAnswer(id){
            var xhr = new XMLHttpRequest();
            var str = "id=<?php echo $erow['evaluation_id']; ?>";
            str += "&qid=";
            str += id;
            str += "&uid=<?php echo $_SESSION['uid']?>";
            str += "&quizid=<?php echo $erow['quiz_id'] ?>";
            var query = document.getElementById('answer').value;
            str += "&q=";
            str += query;
            xhr.open('POST', 'controller/quizGet.php', true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(str);
            //alert("clicked");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200){
                    var display = document.getElementById("question");
                    display.innerHTML = xhr.responseText;
                    banid = "btn" + id;
                    array.push(banid);
                    var banner = document.getElementById(banid);
                    banner.classList.remove("btn-primary");
                    banner.classList.add("btn-success");
                    banid = "btn" + (id + 1);
                    var banner = document.getElementById(banid);
                    banner.classList.add("btn-primary");
                    banner.classList.remove("btn-success");
                }
            }
        }

        if (seconds > 0){
            window.onbeforeunload = function(e) {
                submit();
                return 'Are you sure you want to quite?';
            };
            window.onbeforeunload = function() {
                submit();
                return "Dude, are you sure you want to leave? Think of the kittens!";
            }
        }
    </script>

</head>
<body>
<?php include("view/header-student.php"); ?>
<div class="container-fluid">
    <div style="height: 60px"></div>
    <div class="col-sm-3 col-md-2 sidebar">
        <div><h2 id="timmer">- -:- -</h2></div>
        <ul class="nav nav-sidebar">
            <?php
                while ($row = mysqli_fetch_array($qsresult)){
                    echo "<li><button class='banner' style='width: 100%;' id='btn". $row['question_id'] ."' onclick='getQuestion(". $row['question_id'] .")'><h4>".$row['rank']."</h4></button></li>";
                }
            ?><br>
            <li><button class='banner' style='width: 100%;' id='btn' onclick='submit()'><h4>Submit</h4></button></li>
        </ul>
    </div>
    <div class="col-md-10 main">
        <h1 class="page-header">Welcome to <?php echo $qrow['title']; ?></h1>
        <div id="question">
            <h2>The quiz is started, click on the banner to see the questions.</h2>
        </div>
    </div>
</body>