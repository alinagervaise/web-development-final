<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/28
 * Time: 下午9:44
 */

include ("controller/dbConfig.php");
session_start();
$sid = mysqli_real_escape_string($conn,$_SESSION['uid']);
$sql = "SELECT * FROM test WHERE student_id = '$sid'";
$result = mysqli_query($conn,$sql);
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
    <div style="height: 80px"></div>
    <div class="row">
        <?php include("view/sider-student.php") ?>
        <div class="col-md-10 main">
            <h1 class="page-header">Welcome, <?php echo $_SESSION['name']; ?></h1>

            <h2 class="sub-header">My Evaluations</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Valid Time</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<td>" . $row['started_at'] . "</td>";
                        echo "<td>" . $row['completed_at'] . "</td>";
                        echo "<td>" . $row['validated_at'] . "</td>";
                        if ($row['validated_at'] == '')
                            echo "<td><form action=''><button type='button'>submitted</button></td></form>";
                        else
                            echo "<td><form action=''><button type='button'>validated</button></td></form>";
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