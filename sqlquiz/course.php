<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/28
 * Time: 下午9:44
 */
/* TODO
    change status
    profile button
*/

include ("controller/dbConfig.php");
session_start();


//$ evaluation_RS = classModel.getEvaluation($classId, $trainerId) ;
$trainerId = mysqli_real_escape_string($conn,$_SESSION['uid']);
$trainer_RS = TrainerModel::get($trainerId);

$class_RS = ClassModel::getAll();

$sid = mysqli_real_escape_string($conn,$_SESSION['uid']);
$sql = "SELECT * FROM class_member WHERE user_id = '$sid'";
$class_result = mysqli_query($conn,$sql);
$class_row = mysqli_fetch_array($class_result);

$cid = mysqli_real_escape_string($conn, $class_row['class_id']);
$csql = "SELECT * FROM evaluation WHERE class_id = '$cid'";
$result = mysqli_query($conn,$csql);

if (!$result) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <?php include("view/bootstrap.php");?>
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>
<?php include("view/header-student.php"); ?>

<div class="container-fluid">
    <div style="height: 60px"></div>
    <div class="row">
        <?php include("view/sider-trainer.php") ?>
        <div class="col-md-10 main">
            <h1 class="page-header">Welcome, <?php echo $_SESSION['name']; ?></h1>

            <h2 class="sub-header">Courses</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($class_RS)){
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        /*
                        $eid = mysqli_real_escape_string($conn, $row['evaluation_id']);
                        $qsql = "SELECT * FROM test WHERE evaluation_id = '$eid'";
                        $qresult = mysqli_query($conn, $qsql);
                        if ($qrow = mysqli_fetch_array($qresult))
                            echo "<td>" . $qrow['validated_at'] . "</td>";
                        else
                            echo "<td> - </td>";
                        echo "<td> - </td>";
                        */
                        
                        echo "<td><form action='evaluation.php?'><input type='hidden' name='id' value='".$row['evaluation_id']."' /> <button type='submit'>Info</button></td></form>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>