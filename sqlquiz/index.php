<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="../script/jquery-1.11.2.min.js"></script>
    </head>
    <body>
        <table>
            <thead>
                <th>Evaluation</th>
            </thead>
            <tbody>
                <tr>
                    <td>Evaluation 1</td>
                </tr>
                <tr>
                    <td>Evaluation 2</td>
                </tr>
            </tbody>
            
        </table>
    </body>
</html>

 <script>
      $(document).ready(function () {
        // Get data from server when click on Reload button
        $("#login").click(function (event) {
          $.ajax({
            // HTTP mthod
            type: "POST",
            url: "authentitcation",
            // return type
            dataType: "json",
            // error processing
            // xhr is the related XMLHttpRequest object
            error: function (xhr, string) {
              var msg = (xhr.status == 404)
                      ? "Person  <?= $id ?> not found"
                      : "Error : " + xhr.status + " " + xhr.statusText;
              $("#message").html(msg);
            },
            // success processing (when 200,201, 204 etc)
            success: function (data) {
              $("#name").val(data.name);
              $("#message").html("Person <?= $id ?> loaded")
            }
          });
        });

       
      });

    </script>
