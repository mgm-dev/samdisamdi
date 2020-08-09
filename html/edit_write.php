<?php
require_once("dbconfig.php");

//$_POST['bno']이 있을 때만 $bno 선언
if(isset($_POST['bno'])) {
    $bNo = $_POST['bno'];
    $bPassword = $_POST['bPassword'];
}

if(isset($bNo)) {
    //수정 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크
    $sql = 'select b_password from board_free where b_no =' . $bNo;
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $password = $row[b_password];

    if(!password_verify($bPassword, $password)) {
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

if(isset($bNo)) {
    $sql = 'select b_title, b_content, b_id from board_free where b_no = ' . $bNo;
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Write</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/write.css">
</head>

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
<div class="container">
    <h1> 게시판 글수정</h1>
    <form id="my-form" action="./edit_update.php" method="post">
        <input type="hidden" name="bNo" id="bNo" value="<?php echo $bNo?>">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="bID">아이디</label>
                    <input type="text" class="form-control" name="bID" id="bID" maxlength="20" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="bPassword">비밀번호</label>
                    <input type="password" class="form-control" name="bPassword" id="bPassword" minlength="5" maxlength="100" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="bTitle">제목</label>
            <input type="text" class="form-control" name="bTitle" id="bTitle" maxlength="100" required>
        </div>
        <div class="form-group">
            <label for="bContent">내용</label>
            <textarea class="form-control" name="bContent" id="bContent" required><?php echo $row[b_content]?></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <a href="/forum.php" class="btn-light btn">목록</a>
            <button type="submit" class="btn btn-primary">글수정</button>
        </div>
    </form>
</div>
<script>
    document.getElementById("bID").setAttribute("value", "<?php echo $row[b_id]?>")
    document.getElementById("bTitle").setAttribute("value", "<?php echo $row[b_title]?>");
</script>
</body>
</html>