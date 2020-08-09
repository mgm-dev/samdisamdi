<?php

session_start();
$email = $_SESSION['email'];

if($email == NULL) {
    echo "<script>alert('로그인이 필요합니다')</script>";
    echo "<script>location.replace('password_change.html')</script>";
    exit();
}

//post로 받아온 값 중 null이 없는지 체크
if($_POST['currentPassword'] != NULL && $_POST['changePassword'] != NULL && $_POST['changePasswordCheck'] != NULL) {
    $currentPassword = $_POST['currentPassword'];
    $changePassword = $_POST['changePassword'];
    $changePasswordCheck = $_POST['changePasswordCheck'];

    //바꿀 비밀번호와 바꿀 비밀번호 확인이 다른 경우 체크
    //두 값이 다르면 실패 메시지 출력 후 본 파일 동작 중지
    if($changePassword != $changePasswordCheck) {
        echo "<script>alert('새 비밀번호를 확인 해주세요')</script>";
        echo "<script>location.replace('password_change.html')</script>";
        exit();
    }

    //바꿀 비밀번호와 예전 비밀번호가 같은 경우 체크
    //두 값이 같으면 실패 메시지 출력 후 본 파일 동작 중지
    if($changePassword == $currentPassword) {
        echo "<script>alert('새 비밀번호는 예전 비밀번호와 달라야합니다')</script>";
        echo "<script>location.replace('password_change.html')</script>";
        exit();
    }

    //db 설정
    $conn = mysqli_connect("localhost", "mysql", "EnterPasswordHere", "user_info");
    $conn -> set_charset('utf8');
    $sql = "select * from user where email = '$email'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();


    //실패 메시지 출력 후 본 파일 동작 중지
    if(!$result) {
        echo "<script>alert('db 오류')</script>";
        echo "<script>location.replace('password_change.html')</script>";
        exit();
    }

    //현재 비밀번호 검증
    if(!password_verify($currentPassword, $row['password'])) {
        echo "<script>alert('현재 비밀번호를 확인해 주세요')</script>";
        echo "<script>location.replace('password_change.html')</script>";
        exit();
    }

    //새로운 비밀번호 해싱 후 db 변경
    $hash = password_hash($changePassword, PASSWORD_DEFAULT);
    $sql = "update user set password = '$hash' where email = '$email'";
    $result = $conn->query($sql);

    //퀴리 성공 검증
    if(!$result) {
        echo "<script>alert('db 오류')</script>";
        echo "<script>location.replace('password_change.html')</script>";
        exit();
    }

    echo "<script>alert('비밀번호를 변경했습니다')</script>";
    echo "<script>location.replace('password_change.html')</script>";
    exit();
}