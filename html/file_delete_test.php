<?php

require_once("dbconfig.php");

$bNO = $_GET['bno'];

$sqlEmailCheck = "SELECT * FROM board_file WHERE b_no = '$bNO'";
$result = mysqli_query($db, $sqlEmailCheck);
$row = mysqli_fetch_array($result);

mysqli_close($db);

//파일이 저장 되어 있는 다이렉토리(폴더 이름)를 쿼리로 리턴된 배열에서 조합
//다이렉토리 : uploads/유저이름/유저이메일/글작성시간
$dir = "uploads/" .
    $row['b_name'] .
    $row['b_email'] .
    date("YmdHis", strtotime($row[b_date]));

//glob 함수로 확장자별로 구분 된 파일 다이렉토리 배열 생성
//$images = {uploads/유저1/이메일1/시간1/사진1, uploads/유저1/이메일1/시간1/사진2, ...}
//$stls = {uploads/유저1/이메일1/시간1/stl1, uploads/유저1/이메일1/시간1/stl2, ...}
if (glob($dir . "/*.{jpg,png}", GLOB_BRACE) != false) {
    $images = glob($dir . "/*.{jpg,png}", GLOB_BRACE);
}
if (glob($dir . "/*.stl") != false) {
    $stls = glob($dir . "/*.stl");
}

//이미지가 몇개인지 확인해서 변수로 저장, 추후 html 코드 추가 할때 사용
$imagesNumber = count($images);
//stl 파일이 몇장인지 확인해서 변수로 저장, 추후 html 코드 추가 할때 사용
$stlsNumber = count($stls);

echo $imagesNumber;
echo $stlsNumber;

foreach($images as $value) {
    echo $value."<br/>";
    unlink($value);
}

foreach ($stls as $value) {
    echo $value."<br/>";
    unlink($value);
}

