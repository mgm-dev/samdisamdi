<?php

//smtp에 접속하여 메일을 전송하는 php 클래스
//오브젝트를 생성할 때 값을 지정하지 않으면
//발송자는 tommin231@naver.com
//smtp 서버는 smtp.naver.com
include "Sendmail.php";

$config = array(
    'debug'=>1
);

$testObject = new Sendmail($config);

$to="tommin231@naver.com";
$from="SamdiSamdi";
$subject="메일 제목입니다.";
$body="메일 내용입니다.";

/* 메일 보내기 */
$result = $testObject->send_mail($to, $from, $subject, $body);
