<?php
session_start();
if ($_POST["action"] == "taskcheck") {
    if (!isset($_SESSION["completetask"])) {
        $_SESSION["completetask"] = array();
    }
    foreach ($_SESSION["todo"] as $key => $value) {

        if ($key == $_POST['id']) {
            array_push($_SESSION['completetask'], $value);
            array_splice($_SESSION['todo'], $key, 1);
        }
    }
}
if ($_POST["action"] == "completedcheck") {
    foreach ($_SESSION["completetask"] as $key => $value) {
        if($key == $_POST['id']){
            array_push($_SESSION['todo'],$value);
            array_splice($_SESSION['completetask'],$key,1);
        }
    }
}
if ($_POST["action"] == "deletecompleted") {
    foreach ($_SESSION['completetask'] as $key => $value) {
        if($key == $_POST['id']){
            array_splice($_SESSION['completetask'],$key,1);
        }
    }
}
$_SESSION["new"] = array();
$_SESSION["new"] =  array("todo" => json_encode($_SESSION['todo']), 
"completetask"=>json_encode($_SESSION['completetask']));
return print_r(json_encode($_SESSION["new"]));
