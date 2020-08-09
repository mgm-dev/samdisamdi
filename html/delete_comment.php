<?php
//이 파일은 comment.php파일에서 ajax로 호출됨
//이 파일은 댓글의 고유번호를 받고 해당 댓글을 삭제함

include_once 'dbconfig.php';

$coNo = $_POST['coNo'];
//삭제된 댓글인지 확인
//comment_free 테이블의 co_delete 열은 댓글의 삭제 유무를
//boolean으로 저장하고 있음
$sql1 ="SELECT * FROM comment_free WHERE co_no = '$coNo'";
$result1 = $db->query($sql1);
$row = $result1->fetch_assoc();

//이미 삭제 된 댓글일 시 종료
if($row['co_delete']) {
    exit();
}

//삭제 된 댓글이 아닐 시
//댓글 내용을 수정, 댓글 co_delete 값 true로 변경
if(!$row['co_delete']) {
    $sql2 = "UPDATE comment_free SET co_delete = TRUE, co_content='작성자가 삭제한 댓글입니다' WHERE co_no = '$coNo'";
    $result2 = $db->query($sql2);
    echo "success";
}
?>


