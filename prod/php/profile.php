<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
}
?>
<html lang="en">

<?php
include 'components/head.php';
?>

<body>
    <?php
    include 'src/envLoader.php';
    use DevCoder\DotEnv;
    
    (new DotEnv(__DIR__ . '/.env'))->load();

    $serverURL = getenv("PHP_DB_serverURL");
    $username_db = getenv("PHP_DB_username");
    $password_db = getenv("PHP_DB_password");
    $database = getenv("PHP_DB_database");

    $conn = new mysqli($serverURL, $username_db, $password_db, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    include 'components/header.php';
    ?>
    <div style="margin: 20px;">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $upload_file = 'images/' . basename($_FILES['img_link']['name']);
            $email = $_POST['email'];
            if (move_uploaded_file($_FILES['img_link']['tmp_name'], $upload_file)) {
                $conn->query("UPDATE users SET img_link = '$upload_file' WHERE email = '$email'");
                echo "<div class='alert alert-success' role='alert'>
            Email updated: $email
            </div>
            <div class='alert alert-success' role='alert'>
            <img src='$upload_file' alt='profile picture' width='100' height='100'>
            </div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>
            Error uploading file
            </div>";
            }
        } else {
            $url = $_SERVER['REQUEST_URI'];
            //form to change email and upload image to imaged folder, once uploaded save the link to the image in the db
            echo '  <form enctype="multipart/form-data" method="POST" action=' . $url . '>
        <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" name="email" value="' . $_SESSION['user'] . '" class="form-control" id="email" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
        <label for="img_link">Profile Picture</label>
        <input type="file" name="img_link" class="form-control-file" id="img_link">
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
                </form>';
        } ?>
    </div>

</body>

</html>