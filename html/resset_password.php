<?php
//랜덤 문자열 생성 함수
//임시 비밀번호를 생성할 때 사용 됨
//입력값은 문자열 길이, 리턴 값은 문자열
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//패스워드 리셋할 사용자의 이메일
$email = $_POST['email'];

//임시 비밀번호
$tempPassword = generateRandomString(10);
//db에 저장할 패스워드 해쉬
$passwordHash = password_hash($tempPassword, PASSWORD_DEFAULT);

//db 접속 하고 비밀번호 수정
//db명 user_info, 테이블 user, 변경 컬럼 password, 조건 컬럼 email
$dbConnection = mysqli_connect('localhost', 'mysql', 'EnterPasswordHere', 'user_info');
if ($dbConnection->connect_error) {
    die('Connection failed');
}

//db에 email을 조건으로 select 쿼리를 날리고
//리턴 된 로우의 개수를 $hits 변수에 저장
$sql1 = "select * from user where email='$email'";
$result1 = mysqli_query($dbConnection, $sql1);
$hits = mysqli_num_rows($result1);

//히트 수가 1이 아닐 시 회원가입 하지 않았다고 알림 후
//이전 페이지로 리다이렉트, php 종료
if($hits != 1) {
    echo "<script> alert('가입하지 않은 이메일입니다');</script>";
    echo "<script> window.location.href = 'password_resset.html'</script>";
    exit();
}

//exit 하지 않은 경우, 임시 비밀번호로 password 수정
//이때 입력 되는 값은 $tempPassword가 아닌 $passwordHash임
$sql2 = "update user set password='$passwordHash' where email='$email'";
$result2 = mysqli_query($dbConnection, $sql2);
mysqli_close($dbConnection);


//smtp에 접속하여 메일을 전송하는 php 클래스
include "Sendmail.php";

//오브젝트를 생성할 때 값을 지정하지 않으면
//발송자는 tommin231@naver.com
//smtp 서버는 smtp.naver.com

$testObject = new Sendmail();

$to=$email;
$from="SamdiSamdi";
$subject="비밀번호가 리셋 되었습니다";
$body="임시 비밀번호는 {$tempPassword} 입니다.";

/* 메일 보내기 */
$testObject->send_mail($to, $from, $subject, $body);

echo "<script> alert('변경된 비밀번호가 전송되었습니다');</script>";
echo "<script> window.location.href = 'password_resset.html'</script>";
