<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
}
include 'envLoader.php';
use DevCoder\DotEnv;

(new DotEnv(__DIR__ . '/../.env'))->load();

$serverURL = getenv("PHP_DB_serverURL");
$username_db = getenv("PHP_DB_username");
$password_db = getenv("PHP_DB_password");
$database = getenv("PHP_DB_database");
$conn = new mysqli($serverURL, $username_db, $password_db, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//if post method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $task_description = $_POST['task_description'];
    //nice bug if check box checked task_status is not in the form data <----------- 10x php
    if (isset($_POST['task_status'])) {
        $task_status = 1;
    } else {
        $task_status = 0;
    }
    include 'task_gettter.php';
    $task__->updateTask($task_id, $task_description, $task_status);
    header("Location: ../dashboard.php");
}
?>