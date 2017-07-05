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
$qId = mysqli_real_escape_string($conn, $_GET['id']);
$sql = " SELECT  * from sql_question sq
            INNER JOIN quiz_question qq
            ON sq.question_id = qq.question_id WHERE quiz_id = '$qId'";
$Question_RS = mysqli_query($conn, $sql);

$osql = " SELECT  * from sql_question sq
            INNER JOIN quiz_question qq
            ON sq.question_id = qq.question_id WHERE quiz_id != '$qId'";
$OQuestion_RS = mysqli_query($conn, $osql);

if (!$Question_RS) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <?php include("view/bootstrap.php");?>
    <script src="./script/jquery-1.11.2.min.js"></script>
    <script src="./js/questions_script.js"></script>
  
</head>
<body>
<?php include("view/header-student.php"); ?>

<div class="container-fluid">
    <div style="height: 60px"></div>
    <div class="row">
        <?php include("view/sider-trainer.php") ?>
        <div class="col-md-10 main">
            <h1 class="page-header">Welcome, <?php echo $_SESSION['name']; ?></h1>

            <h2 class="sub-header"></h2>
            <div >
 <h2>All Questions Available</h2>
 <hr>

    <div class="col-sm-12">
        <div class="panel-group ng-scope" id="accordion">
            <?php
            $index = 0;
            while ($row = mysqli_fetch_array($Question_RS)){
                $index = $index +1;
                echo '<div class="panel panel-default" ">';
                echo '          <div class="panel-heading">';
                echo '              <h4 class="panel-title">';
                echo '               <a data-toggle="collapse" data-parent="#accordion" href="#collapse"'.$index.'">';
                echo '                    <div >
                                        <div class="row">
                                            <div class="col-md-2 ">
                                            <div class="col-md-2  checkbox">
                                                <input type="checkbox" value="'.$row['question_id'].'" checked="checked"></label>
                                            </div>
                                            </div>
                                             <div class="col-md-8 ">'.$row['question_text'].'</div>
                                         
                                       </div>

                                    </div>
                                </a>
                                </h4>
                            </div>';
                    echo '        <div id="#collapse"'.$index.'"  class="panel-collapse accordion-body collapse in"">
                                <div class="panel-body">'.
                                   $row["correct_answer"];
                    echo'            </div>
                            </div>
                        </div>';
                                
                 }
                 
                 
                while ($row = mysqli_fetch_array($OQuestion_RS)){
                     $index = $index +1;
                echo '<div class="panel panel-default" >';
                echo '          <div class="panel-heading">';
                echo '              <h4 class="panel-title">';
                echo '               <a data-toggle="collapse" data-parent="#accordion" href="#collapse"'.$index.'">';
                echo '                    <div >
                                        <div class="row">
                                            <div class="col-md-2 ">
                                            <div class="col-md-2  checkbox">
                                                <input type="checkbox" value="'.$row['question_id'].'" ></label>
                                            </div>
                                            </div>
                                             <div class="col-md-8 ">'.$row['question_text'].'</div>
                                            <span class="label-info pull-right" data-toggle="collapse" 
                                           
                                       </div>

                                    </div>
                                </a>
                                </h4>
                            </div>';
                    echo '        <div id="#collapse"'.$index.'" class="panel-collapse accordion-body collapse in">
                                <div class="panel-body">'.
                                   $row["correct_answer"];
                    echo'            </div>
                            </div>
                        </div>';
                                
                 }
            ?>
         </div>
    </div>
   
</div>
</body>
</html>