<?php
session_start();
?>
<html>

<head>
    <title>TODO List</title>
    <link href="style.css" type="text/css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body>
    <div class="container">
        <h2>TODO LIST</h2>
        <h3>Add Item</h3>
        <p>
            <input id="task" type="text"><input type="text" hidden id="hiddenid">
            <button id="addtask">Add</button>
            <button id="updatetask">Update</button>
        </p>

        <h3>Todo</h3>
        <ul id="incomplete-tasks">

        </ul>

        <h3>Completed</h3>
        <ul id="completed-tasks">

        </ul>
    </div>


    <script>
        $(document).ready(function() {
            $(document).on('click', '#addtask', function() {
                let addtask = $("#task").val();
                $.ajax({
                    type: "POST",
                    url: "todo.php",
                    data: {
                        val: addtask,
                        action: "add"
                    },
                    datatype: "JSON",
                    success: function(response) {
                        data = JSON.parse(response);
                        displaytodo(data);
                    }

                })

            });
            console.log("h")
            $(document).on('click', '.deletetask', function() {
                let id = this.id;
                let idi = delete(id)[1];
                $.ajax({
                    type: "POST",
                    url: "todo.php",
                    data: {
                        id: id,
                        action: "delete"
                    },
                    datatype: "JSON",
                    success: function(response) {
                        data = JSON.parse(response);
                        displaytodo(data);
                    }
                })
                console.log("hop")
            });
            console.log("h ")
            $(document).on('click', '.edittask', function() {
                $("#addtask").hide();
                $('#updatetask').show();
                let id = this.id;
                let idi = id.split([1]);
                let val = $(`#${idi}`).val();
                $('#task').val(val);
                $('#hiddenid').val(id)

            });
            $(document).on('click', '#updatetask', function() {
                $("#addtask").show();
                $('#updatetask').hide();
                let taskupdate = $("#task").val();
                let id = $('#hiddenid').val();
                $.ajax({
                    type: "POST",
                    url: "todo.php",
                    data: {
                        val: taskupdate,
                        id: id,
                        action: "update"
                    },
                    datatype: "JSON",
                    success: function(response) {
                        data = JSON.parse(response);
                        displaytodo(data);
                    }
                });

            });

            $('#updatetask').hide();
        });
        $(document).on('click' , ".check", function(){
      
      var val = this.value;
      $.ajax({
          type:"POST",
          url: "todo1.php",
          data: {id:val,action:"taskcheck"},
          datatype:"JSON",
          success: function(response){
              
              data = JSON.parse(response);
              taskdata = JSON.parse(data.todo);
              completetask = JSON.parse(data.completetask)
              displaytodo(taskdata);
              completeTask(completetask);
          }
      })
  });


  $(document).on("click" , ".checked", function(){
    
      var val = this.value;
      $.ajax({
          type:"POST",
          url: "todo1.php",
          data: {id:val,action:"completedcheck"},
          datatype:"JSON",
          success: function(response){
              
              data = JSON.parse(response);
              taskdata = JSON.parse(data.todo);
              completetask = JSON.parse(data.completetask)
              displaytodo(taskdata);
              completeTask(completetask);
          }
      })
  });
  
  $(document).on('click', '.delete1',function(){
      var x = this.id;
      var id = delete(x)[1];
      $.ajax({
          type:"POST",
          url: "todo1.php",
          data: {id:id,action:"deletecompleted"},
          datatype:"JSON",
          success: function(response){
              data = JSON.parse(response);
              
              completetask = JSON.parse(data.completetask)
              
              completeTask(completetask);
          }
      })
  });

    </script>
    <script>
        function displaytodo(data) {
            html = "";
            $.each(data, function(key, element) {
                html += `<li><input type="checkbox" class="check" value="${key}"><label>${element}</label><input type="text" hidden id=${key} value="${element}"><button id="${key}" class="edittask">Edit</button><button class="deletetask" id="${key}" >Delete</button></li>`;
            });
            $("#incomplete-tasks").html(html);
        }
        function completeTask(data){
                html="";
                $.each(data , function(key,element){
                    html += `<li><input type="checkbox" class="checked" value="${key}" ><label>${element}</label><input type="text" hidden id=${key} value="${element}"><button class="delete1" id="delete_${key}" >Delete</button></li>`; 
                });
                $("#completed-tasks").html(html);
            }
    </script>
</body>

</html>