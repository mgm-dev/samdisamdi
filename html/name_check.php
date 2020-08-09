<?php

if($_POST['name'] != NULL) {
    $name = $_POST['name'];
    $conn = mysqli_connect("localhost", "mysql", "EnterPasswordHere", "user_info");
    $sql = "SELECT * FROM user WHERE BINARY user_name = '$name'";
    $result = mysqli_query($conn, $sql);

    if($result->num_rows >= 1) {
        echo "cannot_use";
    }
}
?>