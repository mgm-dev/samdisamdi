<?php
//본 파일은 게시글 조회 페이지를 출력하는 view.php에서 a 링크 형태로 사용 됨

//get 방식으로 파일 저장 폴더 위치와 파일 번호 받아서 옴
$dir = $_GET['dir'];
$num = $_GET['num'];

$filepath = $dir . '/stl' . $num . '.stl';
$filesize = filesize($filepath);
$path_parts = pathinfo($filepath);
$filename = $path_parts['basename'];
$extension = $path_parts['extension'];

header("Pragma: public");
header("Expires: 0");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Transfer-Encoding: binary");
header("Content-Length: $filesize");

ob_clean();
flush();
readfile($filepath);
?>
