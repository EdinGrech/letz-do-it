<?php

class Task
{
    public $serverURL;
    public $username_db;
    public $password_db;
    public $database;

    public function __construct($serverURL, $username_db, $password_db, $database)
    {
        $this->serverURL = $serverURL;
        $this->username_db = $username_db;
        $this->password_db = $password_db;
        $this->database = $database;
    }

    public function getTasks($group_id)
    {
        $conn = new mysqli($this->serverURL, $this->username_db, $this->password_db, $this->database);
        $result = $conn->query("SELECT * FROM tasks WHERE group_id = '$group_id'");
        $tasks = array();
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    public function createTask($task_description, $task_status, $group_id)
    {
        $conn = new mysqli($this->serverURL, $this->username_db, $this->password_db, $this->database);
        $conn->query("INSERT INTO tasks (content, task_status, group_id) VALUES ('$task_description', '$task_status', '$group_id')");
    }

    public function updateTask($task_id, $task_description, $task_status)
    {
        $conn = new mysqli($this->serverURL, $this->username_db, $this->password_db, $this->database);
        $conn->query("UPDATE tasks SET content = '$task_description', task_status = '$task_status' WHERE id = '$task_id'");
    }
}

$serverURL_g = getenv("PHP_DB_serverURL");
$username_db_g = getenv("PHP_DB_username");
$password_db_g = getenv("PHP_DB_password");
$database_g = getenv("PHP_DB_database");

$task__ = new Task($serverURL_g, $username_db_g, $password_db_g, $database_g);