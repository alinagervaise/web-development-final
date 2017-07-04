<?php
/**
 * Created by PhpStorm.
 * User: zhangruoqiu
 * Date: 2017/6/29
 * Time: 上午1:50
 */
session_start();
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
                <form enctype="multipart/form-data" method="PUT">
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
                         <input id="fileInput_diagram" type="file" style="display:none;" name="fileInput_diagram"  value="30000"/>
                          <input type="text" class="form-control input-lg" disabled
                                 placeholder="<?php echo $qrow['diagram_path'];?>" id="diagram_path" name="diagram_path">
                          <span class="input-group-btn">
                            <button class="browse btn btn-primary input-lg" type="button" id="bt_diagram">
                                <i class="glyphicon glyphicon-search"></i> Browse</button>
                          </span>
                        </div>
                    </div>
                   
                     <div class="form-group">
                         <label>Script : </label>
                        <div class="input-group col-xs-12">
                          <input id="fileInput_script" type="file" style="display:none;"  name="fileInput_script" value="30000"/>
                          <input type="text" class="form-control input-lg" disabled
                                 placeholder="<?php echo $qrow['creation_script_path'];?>" id="creation_script_path"
                                 name="creation_script_path">
                          <span class="input-group-btn">
                            <button class="browse btn btn-primary input-lg" type="button" id="bt_script">
                                <i class="glyphicon glyphicon-search"></i> Browse</button>
                          </span>
                        </div>
                      </div>
             
                    <input type="hidden" id="id" name="id" value="<?php echo $qid  ?>">
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
          var diagram_data;
          var fReader = new FileReader();
          var file = new File([""],"./uploads/"+ $('#diagram_path').val());
                fReader.readAsDataURL(file);
               
                fReader.onloadend = function(event){
                 diagram_data = event.target.result;
                };
          $('#fileInput_diagram').change(function(){
              $('#diagram_path').val((this).files[0].name);
              var fReader = new FileReader();
                fReader.readAsDataURL((this).files[0]);
               
                fReader.onloadend = function(event){
                 diagram_data = event.target.result;
                };
          });
          var script_data;
          var fReader = new FileReader();
           var file2 = new File([""],"./uploads/"+ $('#creation_script_path').val());
                fReader.readAsDataURL(file2);
               
                fReader.onloadend = function(event){
                 script_data = event.target.result;
                };
          $('#fileInput_script').change(function(){
              $('#creation_script_path').val((this).files[0].name);
              var fReader = new FileReader();
                fReader.readAsDataURL((this).files[0]);
               
                fReader.onloadend = function(event){
                 script_data = event.target.result;
                };
          });
          console.log(script_data);
        $('form').on('submit', function (e) {
        //$("#bt_save").click(function (event) {
            event.preventDefault();
          
          // We need to encode the authentication
        // var auth = "Basic " + Base64.encode("admin:admin");
          var title = $('#title').val();
          var db_name = $('#db_name').val();
          var diagram_path = $('#diagram_path').val();
          var creation_script_path = $('#creation_script_path').val();
          var id = $('#id').val();
        
            var file_data = $('#fileInput_diagram').prop("files")[0];   
             var form_data = new FormData();                  
            form_data.append("file", file_data);
        
          console.log(script_data);
          $.ajax({
            type: "PUT",
            url: "controller/trainer_save_quiz.php",
         
            // Body parameters to send
            data: {
              id:id,
              title:title,
              db_name: db_name,
              creation_script_path:creation_script_path,
              diagram_path:diagram_path,
              diagram_data:diagram_data,
              script_data:script_data
            },
            // We add the auth header before sending the request
            /*beforeSend: function (xhr) {
              xhr.setRequestHeader("Authorization", auth);
            },*/
            // What to do in case of failure (400-599)
            error: function (xhr, string) {
              console.log("QUIZ ERROR"+ xhr.responseText);
            },
            // What to do if success (200-299)
            success: function (xml) {
              console.log("QUIZ SUCCESS");
               window.location='trainer_quiz.php';
            }
          });
        });

     });
           
    </script>