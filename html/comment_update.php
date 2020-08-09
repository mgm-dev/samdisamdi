<?php
    require_once("dbconfig.php");

    $email = $_POST['email'];
    $name = addslashes($_POST['name']);
    $bNo = $_POST['bno'];
    $coContent = addslashes($_POST['coContent']);

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
            VALUE (null, '$bNo', null, '$coContent', '$email', '$name')";

    $result =$db->query($sql);

    //뎁스 1 댓글의 경우
    $coNo = $db->insert_id;
    $sql2 = "UPDATE comment_free SET co_order = co_no WHERE co_no = '$coNo'";
    $result2 = $db->query($sql2);

    if($result && $result2) {
        echo 'success';
    }
?>
