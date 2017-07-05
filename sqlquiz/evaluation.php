<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/29
 * Time: 上午1:50
 */
include('controller/dbConfig.php');
$eid = mysqli_real_escape_string($conn,$_GET['id']);
$esql = "SELECT * FROM evaluation WHERE evaluation_id = '$eid'";
$eresult = mysqli_query($conn,$esql);
$erow = mysqli_fetch_array($eresult);

$qid = mysqli_real_escape_string($conn,$erow['quiz_id']);
$qsql = "SELECT * FROM quiz WHERE quiz_id = '$qid'";
$qresult = mysqli_query($conn,$qsql);
$qrow = mysqli_fetch_array($qresult);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Evaluation Page</title>
    <?php include("view/bootstrap.php");?>
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>
<?php include("view/header-student.php"); ?>
<div class="container-fluid">
    <div style="height: 60px"></div>
    <div class="row">
        <?php include("view/sider-student.php") ?>
        <div class="col-md-10 main">
            <h1 class="page-header">Welcome to <?php echo $qrow['title']; ?></h1>
            <img src="<?php echo $qrow['diagram_path'] ?>" class="col-md-7">
            <div class="col-md-5">
                <h2>DB Name: <?php echo $qrow['db_name'];?></h2>
                <h2>Start Time: <?php echo $erow['scheduled_at'];?></h2>
                <h2>End Time: <?php echo $erow['ending_at'];?></h2>
                <h2>Duration: <?php echo $erow['nb_minutes'];?> min.</h2><br><br>
                <h2><a href="<?php echo $qrow['creation_script_path'];?>">Download Script</a></h2>
                <form action="quiz.php">
                    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <button class="btn btn-lg btn-primary" type="submit"><h3>Start</h3></button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>