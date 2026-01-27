<?php
$host = "localhost"; //Database Host
$user = "root"; //Database User
$password = ""; //Database Password
$db = "library_db"; //Database Name

//Create Connection
$conn = new mysqli($host, $user, $password, $db);

//Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>