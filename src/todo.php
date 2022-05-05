<?php
session_start();

if (!isset($_SESSION["todo"])) {
    $_SESSION["todo"] = array();
}
if ($_POST["action"] == "add") {
    $task = $_POST["val"];
    array_push($_SESSION["todo"], $task);
}

if ($_POST["action"] == "delete") {
    foreach ($_SESSION['todo'] as $key => $value) {
        if ($key == $_POST['id']) {
            array_splice($_SESSION['todo'], $key,1);
        }
    }
}
if ($_POST["action"] == "update") {
    foreach ($_SESSION['todo'] as $key => $value) {
        if ($key == $_POST['id']) {
        $_SESSION['todo'][$key]= $_POST['val'];
        }
    }
}
return print_r(json_encode($_SESSION['todo']));
