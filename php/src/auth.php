<?php
include '../src/envLoader.php';
use DevCoder\DotEnv;

(new DotEnv(__DIR__ . '../../.env'))->load();
//get env details and connect to db
$serverURL = getenv("PHP_DB_serverURL");
$username_db = getenv("PHP_DB_username");
$password_db = getenv("PHP_DB_password");
$database = getenv("PHP_DB_database");

$email = $_POST['email'];
$password = $_POST['password'];
//encrip password with sha1
$password = sha1($password);

$conn = new mysqli($serverURL, $username_db, $password_db, $database);
//check if email already exists
$query = "SELECT * FROM users WHERE email = '$email'";
if ($conn->query($query)->num_rows > 0) {
    //well formatted echo to indicare that email already exists
    include '../components/head.php';
    echo "
    <html lang='en'>
    <head>
        <link rel='stylesheet' href='../styles/styles.css'>
    </head>
    <body>
        <div class='auth-cont'>
            <div class='auth-form'>
                <h3>Email already exists</h3>
                <a href='../index.php'>Sign up</a>
            </div>
        </div>
    </body>
    </html>";
} else {
    $query = "INSERT INTO users (email, password)
        VALUES ('$email', '$password')";
    $conn->query($query);
    //create user group
    $user_id = $conn->insert_id;
    $conn->query("INSERT INTO groups (owner_id) VALUES ('$user_id')");
    session_start();
    header("Location: ../dashboard.php");
}
?>