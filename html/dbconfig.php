<?php
    //해당 db에는 게시글과 댓글이 저장 되어있음
    $db = new mysqli('localhost', 'mysql', 'EnterPasswordHere', 'db');

    if($db->connect_errno) {
        die('데이터베이스 연결에 문제가 있습니다.');
    }

    //한글 저장하기 위해 utf8로 charset 설정
    $db->set_charset('utf8');
?>