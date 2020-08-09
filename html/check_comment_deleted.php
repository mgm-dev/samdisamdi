<?php
//이 파일은 comment.php파일에서 ajax로 호출됨
//이 파일은 댓글의 번호를 받아서 해당 댓글이 삭제 되었는지 유무를 확인함

include_once 'dbconfig.php';

//comment.php에서 post 방식으로
//댓글 번호를 받아서 $coNo에 저장
$coNo = $_POST['coNo'];

//삭제된 댓글인지 확인 절차, db의 comment_free 테이블에
//co_delete 열이 댓글의 삭제 유무를 boolean으로 저장하고 있음
$sql ="SELECT co_delete FROM comment_free WHERE co_no = '$coNo'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
mysqli_close($db);

//co_delete가 참인 경우
if($row['co_delete']) {
    echo "deleted";
}
?>