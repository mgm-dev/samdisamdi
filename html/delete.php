<?php
//본 파일은 view.php에서 ajax를 통해 호출 됨
//본 파일은 게시글 db의 board_file 테이블에 위치하는
//게시글 관련 정보를 삭제함

//db 설정
require_once("dbconfig.php");

//게시글 번호를 post로 받아와서
//변수가 선언 되어야함 글삭제가 가능함.
if(isset($_POST['bno'])) {
    $bNo = $_POST['bno'];
}
//게시글 번호가 없는 경우 exit
else {
    exit();
}

//현재 사용자 정보를 확인하기 위해 세션 사용
session_start();
//로그인 유무확인하고 $email 변수에 현재 사용자 이메일 정보 저장
if($_SESSION['is_login']) {
    $email = $_SESSION['email'];
}
//로그인 되지 않은 경우 exit
else {
    exit();
}

//현재 로그인된 사용자 이메일과 게시글 작성자 이메일 비교
if(isset($bNo)) {
    $sql = "SELECT b_email from board_file where b_no =" . $bNo;
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    //현재 로그인 된 사용자 이메일과 게시글 작성자 이메일이 동일한 경우
    if($email == $row['b_email']) {
        $sql2 = "DELETE FROM board_file WHERE b_no = '$bNo'";
        $result2 = $db->query($sql2);

        mysqli_close($db);

        if($result) {
            echo "삭제성공";
        }
    }
}

?>