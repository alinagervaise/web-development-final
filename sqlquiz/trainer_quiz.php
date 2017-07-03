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


// Get trainer information
$qsql = "SELECT * from quiz";
$quiz_RS = mysqli_query($conn, $qsql);


if (!$quiz_RS) {
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

            <h2 class="sub-header">Available Quizzes</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>DB Name</th>
                        <th>Diagram Path</th>
                        <th>Script Path</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($quiz_RS)){
                        echo "<tr>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['db_name'] . "</td>";
                        echo "<td>" . $row['diagram_path'] . "</td>";
                        echo "<td>" . $row['creation_script_path'] . "</td>";
                        echo "<td><form action='trainer_edit_quiz.php?'>"
                        . "<input type='hidden' name='id' value='".$row['quiz_id']."' />"
                                . " <button type='submit'>Edit</button></td></form>";
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