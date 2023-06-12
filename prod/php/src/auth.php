<?php
include '../src/envLoader.php';
use DevCoder\DotEnv;
(new DotEnv(__DIR__ . '/../.env'))->load();
$serverURL = getenv("PHP_DB_serverURL");
$username_db = getenv("PHP_DB_username");
$password_db = getenv("PHP_DB_password");
$database = getenv("PHP_DB_database");
$conn = new mysqli($serverURL, $username_db, $password_db, $database);
$email = mysqli_real_escape_string($conn, trim($_POST['email']));
$password = mysqli_real_escape_string($conn, trim($_POST['password']));
$password = crypt($password, '$2a$07$usesomesillystringforsalt$');
$query = "SELECT * FROM users WHERE email = '$email'";
if ($conn->query($query)->num_rows > 0) {
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
    $user_id = $conn->insert_id;
    $conn->query("INSERT INTO _groups_ (owner_id) VALUES ('$user_id')");
    session_start();
    $_SESSION['user'] = $email;
    header("Location: ../dashboard.php");
}
?>
