<?php

//해당 파일은 mypage.php 파일에서 ajax를 통해 post 방식으로 다음과 같은 값을 받아옴
//유저 이메일, 유저 현재 패스워드, 바꿀 패스워드, 바꿀 패스워드 확인

//해당

//post로 받아온 값 중 null이 없는지 체크
if($_POST['email'] != NULL && $_POST['currentPassword'] != NULL && $_POST['changePassword'] != NULL && $_POST['changePasswordCheck'] != NULL) {
    $email = $_POST['email'];
    $currentPassword = $_POST['currentPassword'];
    $changePassword = $_POST['changePassword'];
    $changePasswordCheck = $_POST['changePasswordCheck'];

    //바꿀 비밀번호와 바꿀 비밀번호 확인이 다른 경우 체크
    //두 값이 다르면 실패 메시지 출력 후 본 파일 동작 중지
    if($changePassword != $changePasswordCheck) {
        echo "fail";
        exit();
    }

    //
    $conn = mysqli_connect("localhost", "mysql", "EnterPasswordHere", "user_info");
    $conn -> set_charset('utf8');
    $sql = "select * from user where email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    //db에서
    //실패 메시지 출력 후 본 파일 동작 중지
    if(!$result) {
        echo "fail";
        exit();
    }

    //현재 비밀번호 검증
    if(!password_verify($currentPassword, $row['password'])) {
        echo "fail";
        exit();
    }

    //새로운 비밀번호 해싱 후 db 변경
    $hash = password_hash($changePassword, PASSWORD_DEFAULT);
    $sql = "update user set password = '$hash' where email = '$email'";
    $result = $conn->query($sql);

    //퀴리 성공 검증
    if(!$result) {
        echo "fail";
        exit();
    }

    echo "success";
}
