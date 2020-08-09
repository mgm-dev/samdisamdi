<?php
//본 파일은 사용자 계정 활성화를 담당함
//signup_process.php에서 본 파일의 링크를 사용자에게 이메일로 보냄
//사용자가 해당 링크를 통해 본 파일에 접근하면 db의 값을 수정하여 계정 활성화가 이루어짐

//사용자를 식별할 해쉬를 get방시으로 받아옴
//이메일에 링크를 포함하는 방식으로 인증하기 때문에 get 방식 사용
$hash = $_GET['hash'];
$primaryKey = $_GET['pk'];

//계정 정보를 조회 쿼리 및, $row에 계정 정보를 저장
$conn = mysqli_connect("localhost", "mysql", "EnterPasswordHere", "user_info");
$conn->set_charset('utf8');
$sql = "SELECT * FROM user WHERE  hash = '$hash'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_array(MYSQLI_ASSOC);

//계정 활성화 쿼리
$sqlActivate = "update user set active = 1 where hash = '$hash' and id ='$primaryKey'";
$result = mysqli_query($conn, $sqlActivate);

//로그인 되어있는 경우 로그아웃 시킴
//새롭게 인증한 이메일로 로그인 시키기 위해서임
session_start();
session_destroy();

//활성화 된 계정의 이메일을 쿠키에 저장함
//해당 쿠키는 로그인 폼의 이메일 인풋에 삽입됨
setcookie('user_email', $row['email'], time() + (10 * 365 * 24 * 60 * 60));
echo '<script> alert("계정이 활성화 되었습니다")</script>';
echo '<script> window.location.href = \'https://www.samdisamdi.com/mypage.php\'</script>';