<?php
//본 파일은 signup.js에서 ajax로 호출됨
//본 파일은 이메일 중복 유무를 검사함

if($_POST['email'] != NULL) {
    $email = $_POST['email'];
    $conn = mysqli_connect("localhost", "mysql", "EnterPasswordHere", "user_info");
    $sql = "SELECT * FROM user WHERE  email = '$email'";
    $result = mysqli_query($conn, $sql);

    if($result->num_rows >= 1) {
        echo "cannot_use";
    }
}
?>