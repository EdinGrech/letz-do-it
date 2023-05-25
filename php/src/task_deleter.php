<?php
include 'envLoader.php';
use DevCoder\DotEnv;

(new DotEnv(__DIR__ . '/../.env'))->load();
//check for user session
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
}

$task_id = $_GET['task_id'];

$serverURL = getenv("PHP_DB_serverURL");
$username_db = getenv("PHP_DB_username");
$password_db = getenv("PHP_DB_password");
$database = getenv("PHP_DB_database");

$conn = new mysqli($serverURL, $username_db, $password_db, $database);
//from the task_id get the group_id and then check if the user is the owner of the group by using the $_SESSION['user'] and compare it with the owner_id
$group_id = $conn->query("SELECT group_id FROM tasks WHERE id = '$task_id'")->fetch_assoc()['group_id'];
$owner_id = $conn->query("SELECT owner_id FROM groups WHERE id = '$group_id'")->fetch_assoc()['owner_id'];
//get user_id from email ($_SESSION['user'])
$user_id = $conn->query("SELECT id FROM users WHERE email = '" . $_SESSION['user'] . "'")->fetch_assoc()['id'];
//if the user is the owner of the group then delete the task
include 'head.php';
if ($owner_id == $user_id) {
    $conn->query("DELETE FROM tasks WHERE id = '$task_id'");
    echo "Task deleted";
    echo '<br><a href="../dashboard.php">Go back</a>';
} else {
    echo "You are not the owner of this group";
    echo '<br><a href="../dashboard.php">Go back</a>';
}
?>