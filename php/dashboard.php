<?php
include 'src/envLoader.php';
use DevCoder\DotEnv;

(new DotEnv(__DIR__ . '/.env'))->load();
session_start();
$serverURL = getenv("PHP_DB_serverURL");
$username_db = getenv("PHP_DB_username");
$password_db = getenv("PHP_DB_password");
$database = getenv("PHP_DB_database");

if (!isset($_SESSION['user'])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 3) {
        include '../components/head.php';
        echo "
        <html lang='en'>
        <head>
            <link rel='stylesheet' href='../styles/styles.css'>
        </head>
        <body>
            <div class='auth-cont'>
                <div class='auth-form'>
                    <h3>Invalid email or password</h3>
                    <a href='../index.php'>Sign up</a>
                </div>
            </div>
        </body>
        </html>";
        die();
    }
    $password = crypt($password, '$2a$07$usesomesillystringforsalt$');

    $conn = new mysqli($serverURL, $username_db, $password_db, $database);

    if ($conn->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'")->num_rows > 0) {
        $_SESSION['user'] = $email;
    } else {
        header("Location: login.php");
    }
}

?>
<html lang="en">

<?php
include 'components/head.php';
?>

<body>
    <?php
    include 'components/header.php';
    include 'src/task_gettter.php';
    include 'src/group_getter.php';
    $user_id = $user->get_user_id($_SESSION['user']);
    $groups_owner = get_owner_user_groups($user_id, $serverURL, $username_db, $password_db, $database);
    $groups_user = get_user_groups($user_id, $serverURL, $username_db, $password_db, $database);
    $tasks = $task__->getTasks($groups_owner[0]['id']);
    ?>
    <div style="display: flex; flex-direction: column; margin: 20px 30px;">
        <h1>Dashboard</h1>
        <div style="display: flex; flex-direction: coloum; justify-content: space-between;">
            <div style="width: 40%;">
                <div style="display: flex; flex-direction: row; justify-content: space-between;">
                    <h2>
                        Personal List
                    </h2>
                    <div style="width: 35%; margin-top: 10px; display:flex; justify-content: flex-end; max-height:40px">
                        <a href="add-task.php<?php echo '?group_id=' . $groups_owner[0]['id'] ?>"
                            class="btn btn-primary">
                            Add Task
                        </a>
                    </div>
                </div>
                <?php
                //Array ( [id] => 1 [group_id] => 1 [content] => some task here [task_status] => 0 )
                //print_r($tasks);
                //echo a table with all the tasks
                echo '<table class="table table-striped table-dark">
                <thead>
                <tr>
                <th style="background: #b38d10;" scope="col">Task</th>
                <th style="background: #b38d10;" scope="col">Status</th>
                            <th style="background: #b38d10;" scope="col">Delete</th>
                        </tr>
                        </thead>
                        <tbody>';
                foreach ($tasks as $task) {

                    echo '  <tr>
                                <td>' . $task['content'] . '</td>
                                <td>' .
                        '<form action="src/task_updater.php" method="post">' .
                        '<input type="hidden" name="task_id" value="' . $task['id'] . '">' .
                        '<input type="hidden" name="task_description" value="' . $task['content'] . '">' .
                        '<input type="checkbox"' . ($task['task_status'] == 1 ? 'checked' : '') . ' name="task_status" value="' . $task['task_status'] . '" onchange="this.form.submit()" ' . '>' .
                        '</form>' .
                        '</td>
                                <td><a href="src/task_deleter.php?task_id=' . $task['id'] . '">Delete</a></td>
                            </tr>';
                }
                echo "</tbody></table>";
                ?>
            </div>
            <div style="width: 70%; margin-left: 15px;">
                <div style="display:flex; justify-content: space-between;">
                    <h2>Your Group Lists</h2>
                    <div style="width: 35%; margin-top: 10px; display:flex; justify-content: flex-end; max-height:40px">
                        <a href="add-group.php" class="btn btn-primary">
                            Create Group
                        </a>
                    </div>
                </div>
                <?php
                //for group in $groups_owner (execept the firt one) create a table and load the tasks
                foreach ($groups_owner as $group) {
                    if ($group['id'] != $groups_owner[0]['id']) {
                        $tasks = $task__->getTasks($group['id']);
                        echo '<table class="table table-striped table-dark style="min-width: 34%;">
                            <thead>
                            <tr>
                            <th style="background: #b38d10;" scope="col"> <div style="display:flex; justify-content: space-between;"> <div style="padding-top:10px;"> <div> Tasks' . " for group " . $group['id'] - 1 . '</div></div><a href="add-task.php?group_id=' . $group['id'] . '"
                                    class="btn btn-primary" style="max-height:40px;">
                                    Add Task
                                </a></div>' . '</th>
                            <th style="background: #b38d10;" scope="col">Status</th>
                                        <th style="background: #b38d10;" scope="col">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>';
                        foreach ($tasks as $task) {
                            echo '  <tr>
                                        <td>' . $task['content'] . '</td>
                                        <td>' . '<form action="src/task_updater.php" method="post">' . '<input type="hidden" name="task_id" value="' . $task['id'] . '">' . '<input type="hidden" name="task_description" value="' . $task['content'] . '">' . '<input type="checkbox" name="task_status" value="' . $task['task_status'] . '" onchange="this.form.submit()" ' . ($task['task_status'] == 1 ? 'checked' : '') . '>' . '</form>' . '</td>
                                        <td><a href="src/task_deleter.php?task_id=' . $task['id'] . '">Delete</a></td>
                                    </tr>';
                        }
                        echo "</tbody></table>";
                    }
                }
                ?>
            </div>
            <div style="width: 70%; margin-left: 15px;">
                <div style="display:flex; justify-content: space-between;">
                    <h2>Group Lists</h2>
                </div>
                <?php
                //for group in $groups_user create a table and load the tasks
                foreach ($groups_user as $group) {
                    $tasks = $task__->getTasks($group['id']);
                    echo '<table class="table table-striped table-dark style="min-width: 34%;">
                            <thead>
                            <tr>
                            <th style="background: #b38d10;" scope="col"> <div style="display:flex; justify-content: space-between;"> <div style="padding-top:10px;">Tasks' . " for group " . $group['id'] . '</div></div>' . '</th>
                            <th style="background: #b38d10;" scope="col">Status</th>
                                        <th style="background: #b38d10;" scope="col">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>';
                    foreach ($tasks as $task) {
                        echo '  <tr>
                                        <td>' . $task['content'] . '</td>
                                        <td>' . '<form action="src/task_updater.php" method="post">' . '<input type="hidden" name="task_id" value="' . $task['id'] . '">' . '<input type="hidden" name="task_description" value="' . $task['content'] . '">' . '<input type="checkbox" name="task_status" value="' . $task['task_status'] . '" onchange="this.form.submit()" ' . ($task['task_status'] == 1 ? 'checked' : '') . '>' . '</form>' . '</td>
                                        <td><a href="src/task_deleter.php?task_id=' . $task['id'] . '">Delete</a></td>
                                    </tr>';
                    }
                    echo "</tbody></table>";
                }
                ?>
            </div>
        </div>
        <?php
        include 'components/footer.php';
        ?>
    </div>
</body>

</html>