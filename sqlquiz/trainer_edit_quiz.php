<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/29
 * Time: 上午1:50
 */
include('controller/dbConfig.php');
$qid = mysqli_real_escape_string($conn,$_GET['id']);
$qsql = "SELECT * FROM quiz WHERE quiz_id = '$qid'";
$qresult = mysqli_query($conn, $qsql);
$qrow = mysqli_fetch_array($qresult);

$qq_sql = "SELECT *  FROM sql_question sq
        INNER JOIN quiz_question qq
        ON  sq.question_id = qq.question_id
        WHERE qq.quiz_id='$qid'";
$quiz_question_RS = mysqli_query($conn, $qq_sql);
$qqrow = mysqli_fetch_array($quiz_question_RS);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Evaluation Page</title>
    <?php include("view/bootstrap.php");?>
     <script src="./script/jquery-1.11.2.min.js"></script>
   
</head>
<body>
<?php include("view/header-student.php"); ?>
<div class="container-fluid">
    <div style="height: 60px"></div>
    <div class="row">
        <?php include("view/sider-trainer.php") ?>
        <div class="col-md-10 main">
            <h1 class="page-header">Edit  <?php echo $qrow['title']; ?></h1>
            
            <div class="col-md-5">
                <form >
                    <div class="form-group">
                        <label>Title: </label>
                        <input  class="form-control" type="text" name="title" value="<?php echo $qrow['title'];?>" id="title">
                    </div>
                    <div class="form-group">
                        <label>DB Name: </label>
                        <input  class="form-control" type="text" name="db_name" value="<?php echo $qrow['db_name'];?>" id="db_name">
                    </div>
                     <div class="form-group">
                        <label>Diagram : </label>
                         <div class="input-group col-xs-12">
                         <input id="fileInput_diagram" type="file" style="display:none;""/>
                          <input type="text" class="form-control input-lg" disabled
                                 placeholder="<?php echo $qrow['diagram_path'];?>" id="diagram_path">
                          <span class="input-group-btn">
                            <button class="browse btn btn-primary input-lg" type="button" id="bt_diagram">
                                <i class="glyphicon glyphicon-search"></i> Browse</button>
                          </span>
                        </div>
                    </div>
                   
                     <div class="form-group">
                         <label>Script : </label>
                        <div class="input-group col-xs-12">
                          <input id="fileInput_script" type="file" style="display:none;" />
                          <input type="text" class="form-control input-lg" disabled
                                 placeholder="<?php echo $qrow['creation_script_path'];?>" id="creation_script_path">
                          <span class="input-group-btn">
                            <button class="browse btn btn-primary input-lg" type="button" id="bt_script">
                                <i class="glyphicon glyphicon-search"></i> Browse</button>
                          </span>
                        </div>
                      </div>
             
                    <input type="hidden" name="input_id" value="<?php echo $qid  ?>">
                    <button class="btn btn-lg btn-primary" type="submit"  id="bt_save"><h3>Save</h3></button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

 <script>
     $(document).ready(function(){
          $('#bt_diagram').click(function(){
              $('#fileInput_diagram').click();
          });
          $('#bt_script').click(function(){
              $('#fileInput_script').click();
          });
          $('#fileInput_diagram').change(function(){
              $('#diagram_path').val((this).files[0].name);
          });
          $('#fileInput_script').change(function(){
              $('#creation_script_path').val((this).files[0].name);
          });
        
        $("#bt_save").click(function (event) {
          // We need to encode the authentication
          var auth = "Basic " + Base64.encode("admin:admin");
          var title = $('#title').val;
          var db_name = $('#db_name').val;
          var diagram_path = $('#diagram_path').val;
          var creation_script_path = $('#creation_script_path').val;
          var id = $('#input_id').val;
          $.ajax({
            type: "PUT",
            url: "controller/trainer_save_quiz.php",
            // Body parameters to send
            data: {
              id:id,
              title:title,
              db_name: db_name,
              creation_script_path:creation_script_path,
              diagram_path:diagram_path
            },
            // We add the auth header before sending the request
            /*beforeSend: function (xhr) {
              xhr.setRequestHeader("Authorization", auth);
            },*/
            // What to do in case of failure (400-599)
            error: function (xhr, string) {
              console.log("QUIZ UPDATED"+ xhr.responseText);
            },
            // What to do if success (200-299)
            success: function (xml) {
              console.log("QUIZ UPDATED");
            }
          });
        });

     });
           
    </script>