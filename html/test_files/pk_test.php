<?php
require_once ("../dbconfig.php");

//post 방식으로 db에 저장될 값 받아오고 db에 새로운 row 추가
$bName = 'test';
$bEmail = 'test';;
$bTitle = 'test';;
$bContent = 'test';;
$date = date('Y-m-d H:i:s');


$sql = "INSERT INTO board_file (b_no, b_title, b_content, b_date, b_hit, b_name, b_email) 
        VALUES (null, '$bTitle', '$bContent', '$date', 0, '$bName', '$bEmail')";
$result = $db->query($sql);

if($result) {
    $last_uid = mysqli_insert_id($db);
    echo var_dump($last_uid);
    echo "성공";
}
else {
    echo "실패";
}

$sql2 = "SELECT LAST_INSERT_ID()";
$result2 = $db->query($sql2);

echo var_dump($result2);