<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <?php include("view/bootstrap.php");?>
    <link href="../css/dashboard.css" rel="stylesheet">
</head>
<body>
    <?php include("view/header.php"); ?>

    <div class="container-fluid">
        <div style="height: 80px"></div>
        <div class="row">
        <?php include ("view/sider.php")?>
            <div class="col-md-10 main">
                <h1 class="page-header">Welcome </h1>

                <h2 class="sub-header">My Evaluations</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Teacher</th>
                            <th>Groups</th>
                            <th>Info</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>