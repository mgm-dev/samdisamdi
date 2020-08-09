<?php
/**본 파일은 view.php에서 ajax로 호출 된다
 * 본 파일은 board_like 테이블에 로우를 삭제한다
 * board_like는 좋아요 중복 여부를 판단할 때 사용된다
 * 본 파일은 board_file 테이블의 게시글 번호를 post 방식으로 받고
 * 해당 게시글의 b_like 컬럼의 값을 1 감소시킨다 **/
include_once "dbconfig.php";

$bNo = $_POST['bno'];
$email = $_POST['email'];


//좋아요 관련 체크
//게시글 번호와 현재 로그인 한 사용자 이메일을 조건으로 select
$sqlLikeCheck = "SELECT COUNT(*) FROM board_like WHERE post_id = '{$bNo}' AND user_email = '{$email}'";
$resultLikeCheck = mysqli_query($db, $sqlLikeCheck);
$rowLikeCheck = $resultLikeCheck->fetch_assoc();

//현재 로그인한 사용자가 게시글을 좋아요 했는지 변수로 저장
//해당 변수에 따라 좋아요 버튼을 활성화 비활성화 결정
$didUserLike = false;
if($rowLikeCheck["COUNT(*)"] == 1 ) {
    $didUserLike = true;
}

//사용자가 이미 게시글에 좋아요를 하지 않은 경우 exit
if(!$didUserLike) {
    exit();
}

//좋아요 기록 테이블 board_like에 해당하는 row 삭제
$sqlDelete = "delete from board_like where post_id = '$bNo' and user_email='$email'";
$resultDelete = mysqli_query($db, $sqlDelete);

//게시글 기록 테이블 board_file에 좋아요 값 수정
$sqlUpdate = "update board_file set b_like = b_like - 1 where b_no = '$bNo'";
$resultUpdate = mysqli_query($db, $sqlUpdate);


if($resultDelete && $resultUpdate) {
    echo "success";
}
