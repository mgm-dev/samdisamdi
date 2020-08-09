<?php
$email = $_COOKIE['user_email'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../js/modal.js"></script>
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

<iframe name="my-iframe" src="../login_process.php" frameborder="0" style="width:0; height:0; border:0; border:none"></iframe>
</body>

<script>
    document.getElementById('email').value = '<?=$email?>';
</script>
</html>