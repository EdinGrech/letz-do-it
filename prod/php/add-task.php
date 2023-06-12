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
            $task_description = mysqli_real_escape_string($conn, trim($_POST['task_description']));
            $task_status = mysqli_real_escape_string($conn, trim($_POST['task_status']));
            $group_id = mysqli_real_escape_string($conn, trim($_GET['group_id']));
            //include 'src/user_id_getter.php';
            $user_id = $user->get_user_id($_SESSION['user']);
            include 'src/group_getter.php';
            $groups_owner = get_owner_user_groups($user_id, $serverURL, $username_db, $password_db, $database);
            //echo all veriables with lables
            if (!in_array($group_id, array_column($groups_owner, 'id'))) {
                echo "  <div class='alert alert-success' role='alert'>
                        You are not the owner of this group
                    </div>
                    <a style='padding-left:20px' href='dashboard.php'>go back</a>";
                exit();
            }
            if ($task_description != null && $task_status != null) {
                include 'src/task_gettter.php';
                $task__->createTask($task_description, $task_status, $group_id);
                echo "<div class='alert alert-success' role='alert'>
                    Task Description: $task_description
                    </div>
                        <div class='alert alert-success' role='alert'>
                            Task Status: $task_status
                        </div>
                        <div class='alert alert-success' role='alert'>
                            Group ID: $group_id
                        </div>
                        <div class='alert alert-success' role='alert'>
                            User ID: $user_id
                        </div>";
                echo "  <div class='alert alert-success' role='alert'>
                        Task added successfully
                    </div>
                    <a style='padding-left:20px' href='dashboard.php'>go back</a>";
            }
        } else {
            $url = $_SERVER['REQUEST_URI'];
            echo '  <form method="POST" action=' . $url . '>
                <div class="form-group">
                    <label for="task_description">Task Description</label>
                    <input type="text" class="form-control" id="task_description" name="task_description"
                        placeholder="Task Description">
                </div>
                <div class="form-group">
                    <label for="task_status">Task Status</label>
                    <input type="hidden" name="task_status" value="0">
                </div>
                <input type="hidden" name="group_id" value="<?php echo $group_id_furl ?>">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>';

        } ?>
    </div>
</body>

</html>