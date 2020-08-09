<?php

require_once("dbconfig.php");

session_start();

if(!$_SESSION['is_login']) {
    $is_login = $_SESSION['is_login'];
    $user_name = $_SESSION['user_name'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Write</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/write.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
<header id="my-main-header">
    <div class="my-container">
        <h1>삼디삼디</h1>
        <ul>
            <li><a href="http://localhost" target="_self">Home</a></li>
            <li><a href="http://localhost/mypage.php" target="_self">MyPage</a></li>
            <li><a href="http://localhost/forum.php">Forums</a></li>
            <li><a href="/infiniteScroll.html">News</a></li>
        </ul>
    </div>
</header>

<?php
if(!$_SESSION['is_login']) {
?>
<link rel="stylesheet" href="../css/login.css">
<div class="center">
    <img src="../images/login.png" alt="">
    <form id="my-form" action="../login_process.php" target="my-iframe" method="post">
        <h1>로그인</h1>
        <div class="msg"></div>
        <div>
            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <input class="btn" type="submit" value="로그인">

        <div style="display: flex; justify-content: center">
            <a class="btn btn-dark" href="../signup.php">회원가입</a>
        </div>
    </form>
</div>


<?php
}
else {
?>

<div class="container" style="margin-bottom: 0">
    <h1> 게시판 글쓰기</h1>
    <form id="my-form" action="write_update_old.php" method="post">
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
            <textarea class="form-control" name="bContent" id="bContent" required></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <a href="http://localhost/forum.php" class="btn-light btn">목록</a>
            <button id="submit-button" type="submit" class="btn btn-primary">글쓰기</button>
        </div>
    </form>
</div>

<?php
}
?>


<iframe name="my-iframe" src="../login_process.php" frameborder="0" style="width:0; height:0; border:0; border:none"></iframe>
<script src="../js/modal.js"></script>
<script>
    $( "form" ).submit(function( event ) {
        if ( $( "$bTitle" ).val() === "correct" ) {
            return;
        }

        Swal.fire("test")
        event.preventDefault();
    });
</script>
</body>
</html>