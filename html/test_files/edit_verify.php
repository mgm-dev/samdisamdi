<?php

require_once("dbconfig.php");

//$_GET['bno']이 있어야만 글삭제가 가능함.
if(isset($_GET['bno'])) {
    $bNo = $_GET['bno'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>게시판 글수정</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/verify.css">
</head>
<body>

<header id="my-main-header">
    <div class="my-container">
        <h1>삼디삼디</h1>
        <ul>
            <li><a href="/index.php" target="_self">Home</a></li>
            <li><a href="/mypage.php" target="_self">MyPage</a></li>
            <li><a href="/forum.php">Forums</a></li>
            <li><a href="/infiniteScroll.html">News</a></li>
        </ul>
    </div>
</header>

<article class="container">
    <?php
    if(isset($bNo)) {
        $sql = 'select count(b_no) as cnt from board_free where b_no = ' . $bNo;
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
    if(empty($row['cnt'])) {
        ?>
        <script>
            alert('글이 존재하지 않습니다.');
            history.back();
        </script>

    <?php
    exit;
    }

    $sql = 'select b_title from board_free where b_no = ' . $bNo;
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    ?>
        <div class="form-group">
            <img src="../images/edit.png" alt="">
            <form action="../edit_write.php" method="post">
                <input type="hidden" name="bno" value="<?php echo $bNo?>">
                <label for="bPassword">비밀번호</label>
                <input type="password" class="form-control" name="bPassword" id="bPassword" required>
                <div class="d-flex justify-content-sm-end" style="margin-top: 5px">
                    <a href="../forum.php" class="btn btn-light">목록</a>
                    <button type="submit" class="btn btn-primary">수정</button>
                </div>
            </form>
        </div>
    <?php
    //$bno이 없다면 수정 실패
    } else {
    ?>
        <script>
            alert('정상적인 경로를 이용해주세요.');
            history.back();
        </script>
        <?php
        exit;
    }
    ?>
</article>
</body>
</html>
