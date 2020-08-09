<?php
    require_once("dbconfig.php");

    $now = DateTime::createFromFormat('U.u', microtime(true));

    $bID = $_POST[bID];
    $bPassword = $_POST[bPassword];
    $bTitle = $_POST[bTitle];
    $bContent = $_POST[bContent];
    $date = date("Y-m-d H:m:s.U");
    $hash = password_hash($bPassword, PASSWORD_DEFAULT);

//    echo $bID, $bPassword, $bTitle, $bContent, $date;

    $sql = "INSERT INTO board_free (b_no, b_title, b_content, b_date, b_hit, b_id, b_password) 
            VALUES (null, '$bTitle', '$bContent', '$date', 0, '$bID', '$hash')";

//    echo $sql;
    $result = $db->query($sql);

    if($result) { // query가 정상실행 되었다면,
        $msg = "글 등록 성공";
        $bNo = $db->insert_id;
        //글 등록 성공시 해당 글로 이동함
        $replaceURL = './view_old.php?bno=' . $bNo;
    } else {
        $msg = "글 등록 실패";
    ?>
        <script>
            alert("<?php echo $msg?>");
            history.back();
        </script>
    <?php
        }
    ?>
<script>
    alert("<?php echo $msg?>");
    location.replace("<?php echo $replaceURL?>");
</script>