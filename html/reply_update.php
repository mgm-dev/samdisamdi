<?php
require_once("dbconfig.php");

$email = $_POST['email'];
$name = addslashes($_POST['name']);
$bNo = $_POST['bno'];
$reContent = addslashes($_POST['reContent']);
$cNo = $_POST['cno'];

if($_POST['email'] == null) {
    ?>
    <script>
        alert('로그인이 필요합니다');
        location.replace("./view.php?bno=<?=$bNo?>");
    </script>
    <?php
    exit();
}

$sql = "INSERT INTO comment_free (co_no, b_no, co_order, co_content, co_email, co_name)
            VALUE (null, '$bNo', '$cNo', '$reContent', '$email', '$name')";

$result =$db->query($sql);

if($result) {
    echo 'success';
}
?>