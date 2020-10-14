<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "shop";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Connection Failed" . $conn->connect_error);
}
