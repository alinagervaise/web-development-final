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
 $web_root = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
 $logout=''.$web_root.'controller/logout.php';
 
include ("controller/dbConfig.php");
session_start();


// Get trainer information
$trainerId = mysqli_real_escape_string($conn, $_SESSION['uid']);
$sql = "SELECT user_id, email, name, first_name from user WHERE user_id = '$trainerId'";
$trainer_RS = mysqli_query($conn, $sql);

// Get class information
//$class_RS = ClassModel::getAll($conn);
$csql = "SELECT * from class c
        LEFT OUTER JOIN 
        (SELECT  e.class_id, e.trainer_id, count(distinct e.evaluation_id) as no_evaluation 
            FROM class c 
            LEFT OUTER JOIN  evaluation e
            on c.class_id = e.class_id
            WHERE e.trainer_id= '$trainerId'
            GROUP BY e.class_id , e.trainer_id)as t
            ON  t.class_id = c.class_id";
$class_RS = mysqli_query($conn, $csql);

if (!$class_RS) {
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

            <h2 class="sub-header">All Courses Available</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>My Evaluations</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($class_RS)){
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        if (empty($row['no_evaluation'])) {
                            $var = 0;
                        }
                        else{
                            $var = $row['no_evaluation'];
                        }
                        echo "<td>" . $var . "</td>";
                        echo "<td><form action='class_add_evaluation.php?'>"
                        . "<input type='hidden' name='id' value='".$row['class_id']."' />"
                                . " <button type='submit'>Add Evaluations</button></td></form>";
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