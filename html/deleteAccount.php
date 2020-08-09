<?php
//본 파일은 mypage.php에서 ajax로 호출됨
//본 파일은 현재 로그인 된 사용자의 계정을 비활성화 시킴
if($_POST['email'] != NULL) {
    $email = $_POST['email'];
    $conn = mysqli_connect("localhost", "mysql", "EnterPasswordHere", "user_info");

    $sql = "update user set active = false where email = '$email'";
    $result = $conn->query($sql);
    
    session_start();
    session_destroy();

    if($result) {
        echo 'success';
    }
}
?>