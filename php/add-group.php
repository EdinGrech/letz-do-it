<html lang="en">

<?php
include 'components/head.php';
?>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ../index.php");
    }
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
        $user_id = $user->get_user_id($_SESSION['user']);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $users = $_POST['users'];
            //insert group into db with owner_id = $user->get_user_id($_SESSION['user']));
            $conn->query("INSERT INTO groups (owner_id) VALUES ('$user_id')");
            //last group added id = $conn->insert_id
            $group_id = $conn->insert_id;
            foreach ($users as $user__) {
                //add user to db in table user_group_relations group_id = $_GET['group_id'], user_id = $user_id
                $user_id = $user->get_user_id($user__);
                $conn->query("INSERT INTO user_group_relations (group_id, user_id) VALUES ('$group_id', '$user_id')");
            }
            header("Location: dashboard.php");
        } else {
            //get list of all user emails
            $emails = $conn->query("SELECT email FROM users WHERE id != '$user_id'");
            //have a form to add people to the group by email (dropdown with emails and serch bar
            echo "<form action='" . $_SERVER['PHP_SELF'] .
                "' method='post'>
                <div class='form-group'>
                    <label for='users'>Select users to add to group</label>
                    <select multiple class='form-control' id='users' name='users[]'>";
            while ($row = $emails->fetch_assoc()) {
                echo "<option>" . $row['email'] . "</option>";
            }
            echo "      </select>
                </div>
                <button type='submit' class='btn btn-primary'>Submit</button>
            </form>";
        }
        ?>
    </div>
</body>

</html>