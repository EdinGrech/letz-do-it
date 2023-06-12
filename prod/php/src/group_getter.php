<?php
function get_owner_user_groups($user_id, $serverURL, $username_db, $password_db, $database)
{
    $conn = new mysqli($serverURL, $username_db, $password_db, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $result = $conn->query("SELECT * FROM _groups_ WHERE owner_id = '$user_id'");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    
    $_groups_ = array();
    while ($row = $result->fetch_assoc()) {
        $_groups_[] = $row;
    }
    
    $result->free();
    $conn->close();
    
    return $_groups_;
}

function get_user_groups($user_id, $serverURL, $username_db, $password_db, $database)
{
    $conn = new mysqli($serverURL, $username_db, $password_db, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $result = $conn->query("SELECT group_id FROM user_group_relations WHERE user_id = '$user_id'");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    
    $_groups_ = array();
    while ($row = $result->fetch_assoc()) {
        $_groups_[] = $row;
    }
    
    $result->free();
    $conn->close();
    
    return $_groups_;
}
