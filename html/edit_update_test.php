<?php
    require_once ("dbconfig.php");
    echo '1';

    //post 방식으로 db에 저장될 값 받아오고 db에 해당 row 수정
    $bTitle = addslashes($_GET['bTitle']);
    $bContent = addslashes($_GET['bContent']);
    $bNo = $_GET['bno'];

    //게시글 제목, 내용 업데이트
    $sql = "UPDATE board_file SET b_title ='$bTitle', b_content_'$bContent' WHERE b_no ='$bNo'";
    $result = mysqli_query($db, $sql);

    echo var_dump($sql);
