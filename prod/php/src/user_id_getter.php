<?php

class user
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

    public function get_user_id($email)
    {
        $conn = new mysqli($this->serverURL, $this->username_db, $this->password_db, $this->database);
        $user_id = $conn->query("SELECT id FROM users WHERE email = '$email'")->fetch_assoc()['id'];
        return $user_id;
    }

    public function get_user_img_url($email)
    {
        $conn = new mysqli($this->serverURL, $this->username_db, $this->password_db, $this->database);
        $user_img_url = $conn->query("SELECT img_link FROM users WHERE email = '$email'")->fetch_assoc()['img_link'];
        return $user_img_url;
    }

}

$serverURL_g = getenv("PHP_DB_serverURL");
$username_db_g = getenv("PHP_DB_username");
$password_db_g = getenv("PHP_DB_password");
$database_g = getenv("PHP_DB_database");

$user = new user($serverURL_g, $username_db_g, $password_db_g, $database_g);