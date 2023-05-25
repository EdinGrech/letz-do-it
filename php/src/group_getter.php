<?php
function get_owner_user_groups($user_id, $serverURL, $username_db, $password_db, $database)
{
    $conn = new mysqli($serverURL, $username_db, $password_db, $database);
    $result = $conn->query("SELECT * FROM groups WHERE owner_id = '$user_id'");
    $groups = array();
    while ($row = $result->fetch_assoc()) {
        $groups[] = $row;
    }
    return $groups;
}

function get_user_groups($user_id, $serverURL, $username_db, $password_db, $database)
{
    $conn = new mysqli($serverURL, $username_db, $password_db, $database);
    $result = $conn->query("SELECT * FROM user_group_relations WHERE user_id = '$user_id'");
    $groups = array();
    while ($row = $result->fetch_assoc()) {
        $groups[] = $row;
    }
    return $groups;
}