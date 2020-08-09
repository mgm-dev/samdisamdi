<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>회원가입</title>
</head>
<body>

<header id="main-header">
    <div class="container">
        <h1>삼디삼디</h1>
        <ul>
            <li><a href="http://localhost" target="_self">Home</a></li>
            <li><a href="http://localhost/mypage.php" target="_self">MyPage</a></li>
            <li><a href="http://localhost/forum.php" target="_self">Forums</a></li>
            <li><a href="/infiniteScroll.html">News</a></li>
        </ul>
    </div>
</header>

<div class="center">
    <div class="container">
        <h1>회원가입</h1>
        <form class="form-group" action="../signup_process.php" method="post">
            <label for="email">email:</label>
            <input class="form-control" type="email" name="email">
            <label for="name">name:</label>
            <input class="form-control" type="text" name="name">
            <label for="password">password:</label>
            <input class="form-control" type="password" name="password">
            <label for="password_check">password check:</label>
            <input class="form-control" type="password" name="password_check">
            <p><input class="btn btn-primary" type="submit" value="회원가입"></p>
        </form>
    </div>
</div>

</body>
</html>