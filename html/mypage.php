<?php
//로그인 되어있지 않은 경우, 쿠키에서 사용자 이메일 받아서 이메일 input란에 추가함
//해당 쿠키는 signup_process.php와 activate_account.php에서 설정됨
//헤딩 쿠키는 로그인 시 삭제됨 todo:새로고침시에도 쿠키가 삭제됨, 이유 확인필요
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-166857850-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-166857850-1');
    </script>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/mypage.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="title" content="마이페이지-3D 프린팅 파일 공유 커뮤니티 samdisamdi">
    <meta name="keywords" content="삼디삼디, 3D3D, samdisamdi, 3프린팅, 3D모델, 3D프린터, 마이페이지">
    <meta name="description" content="3D프린팅 파일 공유 및 3D프린팅 관련 취미 정보 공유 커뮤니티 삼디삼디의 마이페이지입니다.">
    <title>마이페이지-3D 프린팅 파일 공유 커뮤니티 samdisamdi</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body style="background-color: transparent">
<script>
    function openAlert() {
        Swal.fire(
            '로그인 실패',
            '아이디와 비밀번호를 확인 해주세요',
            'error'
        )
    }

    function success() {
        location.reload();
    }

    window.addEventListener("message", function(event) {
        if(event.data === "openAlert") {
            openAlert();
        }
        if(event.data === "success") {
            success();
        }
    });
</script>

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
if(!$_SESSION['is_login']) {
?>
<div class="center">
    <img src="images/login.png" alt="">
    <form id="my-form" action="login_process.php" target="my-iframe" method="post">
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
            <a class="btn btn-dark" href="signup.php">회원가입</a>
        </div>
        <div style="display: flex; justify-content: center">
            <a class="btn btn-light" onclick="newWindow()">비밀번호 찾기</a>
        </div>
    </form>
</div>

<?php
}
else {
?>
<div class="container" style="text-align: center">
    <div id="mypage-icon-box">
        <h2>마이페이지</h2>
        <hr style="margin-bottom: 0">
        <div style="background-color: lightgrey; padding: 15px 0">
            <div style="font-weight: bold"><?=$user_name?></div>
            <div><?=$email?></div>
        </div>

        <div class="parent">
            <div class="first">
                <a href="forum.php?search-type=writer&search=<?=$user_name?>"><img class="icon-image" src="images/my_posts.png" alt="my_posts"></a>
                <div><a href="forum.php?search-type=writer&search=<?=$user_name?>">내가 쓴글</a></div>
            </div>
            <div class="second">
                <a href="forum.php?search-type=like&search=<?=$email?>"><img class="icon-image" src="images/my_likes.png" alt=""></a>
                <a href="forum.php?search-type=like&search=<?=$email?>"><div>좋아요 한 글</div></a>
            </div>
            <div class="third">
                <a onclick="newWindowChangePassword()"><img class="icon-image" src="images/change_password.png"></a>
                <div><a onclick="newWindowChangePassword()">비밀번호 변경</a></div>
            </div>
        </div>

        <div class="parent">
            <div class="first">
                <a href="logout.php"><img class="icon-image" src="images/logout.png" alt="my_posts"></a>
                <div><a href="logout.php">로그아웃</a></div>
            </div>
            <div class="second">
                <a onclick="deleteAccount()"><img class="icon-image" src="images/delete_account.png" alt=""></a>
                <div><a onclick="deleteAccount()">회원탈퇴</a></div>
            </div>
            <div class="third">
                <a href="personal_info.html" target="new"><img class="icon-image" src="images/personal_info.png"></a>
                <div><a href="personal_info.html" target="new">개인정보 처리 방침</a></div>
            </div>
        </div>

<!--        <div>-->
<!--            <label for="current-password">현재 비밀번호:</label>-->
<!--            <input id="current-password" name="current-password" type="password">-->
<!--            <br/>-->
<!--            <label for="change-password">바꿀 비밀번호:</label>-->
<!--            <input id="change-password" name="change-password" type="password">-->
<!--            <br/>-->
<!--            <label for="change-password-check">비밀번호 확인:</label>-->
<!--            <input id="change-password-check" name="change-password-check" type="password">-->
<!--            <br/>-->
<!--            <input type="button" value="비밀번호 바꾸기" onclick="changePassword(); return false;">-->
<!--        </div>-->
    </div>
</div>
<?php
}
?>


<iframe name="my-iframe" src="login_process.php" frameborder="0" style="width:0; height:0; border:0; border:none"></iframe>
</body>

<script>
    function newWindow() {
        const url = "password_resset.html";
        window.open(url,"","width=500,height=250");
    }

    function newWindowChangePassword() {
        const url = "password_change.html";
        window.open(url, "", "width=500,height=250");
    }

    function changePassword() {
        let email = '<?=$email?>'
        let currentPassword = $("#current-password").val();
        let changePassword = $("#change-password").val();
        let changePasswordCheck = $("#change-password-check").val();

        Swal.fire({
            title: '비밀번호 변경',
            text: "비밀번호를 변경하겠습니까?",
           icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '변경',
            cancelButtonText: '취소'
        }).then((result) => {
            if (result.value) {
                $.post(
                    "mypage_change_password.php",
                    { email : email,
                        currentPassword : currentPassword,
                        changePassword : changePassword,
                        changePasswordCheck : changePasswordCheck },
                    function (data) {
                        if(data === "success"){
                            Swal.fire(
                                '비밀번호 변경 성공',
                                '비밀번호를 변경했습니다',
                                'success'
                            ).then((result) => {
                                if(result.value) {
                                    location.reload();
                                }
                            })
                        }
                        else {
                            Swal.fire(
                                '비밀번호 변경 실패',
                                '비밀번호를 변경하지 못했습니다',
                                'error'
                            )
                        }
                    }
                )
            }
        })
    }

    function deleteAccount() {
        let email = '<?=$email?>'

        Swal.fire({
            title: '회원탈퇴 하시겠습니까?',
            text: "게시글과 댓글은 자동삭제 되지 않습니다.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '탈퇴',
            cancelButtonText: '취소'
        }).then((result) => {
            if (result.value) {
                $.post(
                    "deleteAccount.php",
                    { email : email},
                    function (data) {
                        if(data === "success"){
                            Swal.fire(
                                '회원탈퇴 성공',
                                '계정을 삭제 하였습니다',
                                'success'
                            ).then((result) => {
                                if(result.value) {
                                    location.reload();
                                }
                            })
                        }
                        else {
                            Swal.fire(
                                '회원탈퇴 실패',
                                '계정을 삭제하지 못했습니다',
                                'error'
                            )
                        }
                    }
                )
            }
        })
    }

</script>

<script>
    document.getElementById('email').value = '<?=$email?>';
</script>

</html>
