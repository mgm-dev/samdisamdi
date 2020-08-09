<?php
/**
 * 본파일은 index.php에서 ajax로 호출 됨
 * 본파일은 네이버 smtp를 통해 tommin231@naver.com에 이메일을 보냄
 * 보내는 이메일의 내용은 사용자 불만 및 사이트 개선사항임
 */

include_once "Sendmail.php";

//post 방식으로 사용자 이메일, 이름, 문의사항 받아 오기
$email = $_POST['email'];
$name = $_POST['name'];
$content = $_POST['content'];

$mailer = new Sendmail($config);

$to="tommin231@naver.com";
$from="SamdiSamdi";
$subject="유저 문의사항";
$body="이메일 : {$email} \n 이름 : {$name} \n 문의사항: {$content}";

/* 메일 보내기 */
$result = $mailer->send_mail($to, $from, $subject, $body);

echo "<script> alert('문의사항이 전송 되었습니다')</script>";
echo "<script> location.replace('index.php')</script>";