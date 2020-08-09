<?php
//이 파일은 view.php파일에서 ajax로 호출됨
//이 파일은 게시글의 작성자와 현재 로그인 된 사용자가 동일한지 확인함

include_once 'dbconfig.php';

//view.php 파일로 부터
//게시글 번호 POST로 받기
$bNo = $_POST['bno'];

//세션에서 부터 현재 로그인 된 사용자 이메일 확인
session_start();
$email = $_SESSION['email'];

//게시글 번호를 식별자로 db에서 해당 게시글을 찾고
//해당 댓글 작성자의 email을 $row에 저장
$sql = "SELECT b_email FROM board_file WHERE b_no = '$bNo'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
mysqli_close($db);

//db에서 받아온 해당 게시글의 작성자 email과
//현재 로그인 한 email이 같을 경우 echo success
if($email == $row['b_email']) {
    echo "success";
}
?>