<?php
$email = $_COOKIE['user_email'];

session_start();

//세션 시작후 로그인 유무 확인, 로그인이 안되어있을 시 로그인 페이지로 이동
if($_SESSION['is_login']) {
    $is_login = $_SESSION['is_login'];
    $user_name = $_SESSION['user_name'];
    $email = $_SESSION['email'];
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SignUp</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/signup.js"></script>
</head>
<body>
<header id="main-header">
    <div class="container">
        <h1>삼디삼디</h1>
        <ul>
            <li><a href="/index.php" target="_self">Home</a></li>
            <li><a href="/mypage.php" target="_self">MyPage</a></li>
            <li><a href="/forum.php" target="_self">Forums</a></li>
            <li><a href="/infiniteScroll.html">News</a></li>
        </ul>
    </div>
</header>

<?php
if($_SESSION['is_login']) {
    ?>

    <div class="container">
        <div style="width: 100%; height: 50vh; margin-top: 100px; padding-top: 50px; background: white">
            <h1>마이페이지</h1>
            <h5><?=$user_name?></h5>
            <h5><?=$email?></h5>
            <a href="logout.php">로그아웃</a>
            <h5>내정보</h5>
            <h5>내가쓴글</h5>
            <h5>내가쓴댓글</h5>
        </div>
    </div>

    <?php
}
else {
    ?>

    <div class="center">
        <img src="images/signup2.png" alt="">
        <form id="my-form" action="signup_process.php" target="my-iframe" method="post">
            <h1>회원가입</h1>
            <div class="msg"></div>
            <div>
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" autocomplete="off" required>
            </div>
            <div class="alert alert-danger" id="alert-used">이미 사용 된 이메일입니다.</div>
            <div class="alert alert-danger" id="alert-not-email">유효한 이메일이 아닙니다.</div>
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" autocomplete="off" required>
            </div>
            <div class="alert alert-danger" id="alert-taken">이미 사용 된 닉네임입니다.</div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="password_check">Password Check:</label>
                <input type="password" id="password_check" name="password_check" required>
            </div>
            <div class="alert alert-success" id="alert-success">비밀번호가 일치합니다.</div>
            <div class="alert alert-danger" id="alert-danger">비밀번호가 일치하지 않습니다.</div>
            <input id="submit" class="btn" type="submit" value="회원가입">
        </form>
    </div>

    <?php
}
?>

<iframe name="my-iframe" src="login_process.php" frameborder="0" style="width:0; height:0; border:0; border:none"></iframe>
</body>

</html>
