<?php
include('config.php');

$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

$name1 = isset($_POST['name1']) ? $_POST['name1'] : '';
$email1 = isset($_POST['email1']) ? $_POST['email1'] : '';

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == "submit") {
    if ($name != "") {
        $sql = "SELECT name from user WHERE name= '$name' ";
        $result = $conn->query($sql);
        // $row = mysqli_fetch_row($result);
        if ($result->num_rows > 0) {
            echo "invalidName";
        } else {
            echo "validName";
        }
    }
    if ($email != "") {
        $sql = "SELECT email from user WHERE email= '$email' ";
        $result = $conn->query($sql);
        // $row = mysqli_fetch_row($result);
        if ($result->num_rows > 0) {
            echo "invalidEmail";
        } else {
            echo "validEmail";
        }
    }
}

if ($action == "update") {
    if ($name != "") {
        $sql = "SELECT name from user WHERE name= '$name' ";
        $result = $conn->query($sql);
        // $row = mysqli_fetch_row($result);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);
            if ($row[0] == $name1) {
                echo "validName";
            } else {
                echo "invalidName";
            }
        } else {
            echo "validName";
        }
    }
    if ($email != "") {
        $sql = "SELECT email from user WHERE email= '$email' ";
        $result = $conn->query($sql);
        // $row = mysqli_fetch_row($result);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);

            if ($row[0] == $email1) {
                echo "validEmail";
            } else {
                echo "invalidEmail";
            }
        } else {
            echo "validEmail";
        }
    }
}
