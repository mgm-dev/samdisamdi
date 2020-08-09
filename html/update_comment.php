<?php
//본 파일은 comment.php에서 ajax로 호출 됨
//본 파일은 댓글의 고유번호와 새로운 내용을 받아서
// 댓글의 내용을 수정함
include_once 'dbconfig.php';

//coNo = 댓글 번호
//content = 댓글 내용
$coNo = $_POST['coNo'];
$content = $_POST['content'];

$sql = "UPDATE comment_free SET co_content = '$content' WHERE co_no = '$coNo'";
$result = $db->query($sql);
mysqli_close($db);

if($result) {
    echo $result;
}
?>