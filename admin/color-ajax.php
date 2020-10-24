<?php
include('config.php');

$name = isset($_POST['name']) ? $_POST['name'] : '';

$name1 = isset($_POST['name1']) ? $_POST['name1'] : '';

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == "submit") {
    if ($name != "") {
        $sql = "SELECT name from colors WHERE name= '$name' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "invalidName";
        } else {
            echo "validName";
        }
    }
}

if ($action == "update") {

    if ($name != "") {
        $sql = "SELECT name from colors WHERE name= '$name' ";
        $result = $conn->query($sql);

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
}
