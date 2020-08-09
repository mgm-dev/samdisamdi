<?php
//이 파일은 comment.php파일에서 ajax로 호출됨
//이 파일은 댓글의 작성자와 현재 로그인 된 사용자가 동일한지 확인함

include_once 'dbconfig.php';

//comment.php 파일로 부터
//댓글 번호와 현재 로그인한 유저의 email을 POST로 받기
$coNo = $_POST['coNo'];
$email = $_POST['email'];

//댓글 번호를 식별자로 db에서 해당 댓글을 찾고
//해당 댓글 작성자의 email을 $row에 저장
$sql = "SELECT co_email FROM comment_free WHERE co_no = '$coNo'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
mysqli_close($db);

//db에서 받아온 해당 댓글의 작성자 email과
//현재 로그인 한 email이 같을 경우 echo success
if($email == $row['co_email']) {
    echo "success";
}
?>