<?php
require_once("dbconfig.php");

//$_POST['bno']이 있을 때만 $bno 선언
if(isset($_POST['bno'])) {
    $bNo = $_POST['bno'];
}

$bPassword = $_POST['bPassword'];

echo $bNo, '<br/>', $bPassword, '<br/>';

//$bNO 설정 유무 확인
if(isset($bNo)) {
    //삭제 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크
    $sql = 'select b_password from board_free where b_no =' . $bNo;
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $password = $row[b_password];
    echo $password, '<br/>';

    if(password_verify($bPassword, $password)) {
        echo "match";
        $sql = 'delete from board_free where b_no = ' . $bNo;
    }
    else {
        $msg = '비밀번호가 틀립니다';
        ?>
        <script>
            alert("<?php echo $msg?>");
            history.back();
        </script>
        <?php
        exit;
    }
}

$result = $db->query($sql);

if($result) {
    $msg = '삭제 완료';
    $replaceURL = '/forum.php';
}
else {
    $msg = '삭제 실패';
    ?>
    <script>
        alert("<?php echo $msg?>");
        history.back()
    </script>
    <?php
    exit;
}
?>

<script>
    alert("<?php echo $msg?>");
    location.replace("<?php echo $replaceURL?>");
</script>
