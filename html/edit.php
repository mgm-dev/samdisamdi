<?php

require_once("dbconfig.php");

session_start();

if($_SESSION['is_login']) {
    $is_login = $_SESSION['is_login'];
    $user_name = $_SESSION['user_name'];
    $email = $_SESSION['email'];
}

$bNO = $_GET['bno'];

//수정할 게시글 작성자 이메일과 현재 로그인 한 사람 이메일 비교
$sqlEmailCheck = "SELECT * FROM board_file WHERE b_no = '$bNO'";
$result = mysqli_query($db, $sqlEmailCheck);
$row = mysqli_fetch_array($result);

mysqli_close($db);

$writerEmail = $row['b_email'];
$title = $row['b_title'];
$content = $row['b_content'];

if($email != $writerEmail) {
    echo "<script> alert('수정권한이 없습니다!'); </script>";
    echo "<script> history.back(); </script>";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Write</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/write.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

<?php
if(!$_SESSION['is_login']) {
?>
<link rel="stylesheet" href="css/login.css">
<div class="center" style="margin-top : 80px">
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

<div class="container" style="margin-bottom: 0">
    <h1> 게시판 글 수정하기</h1>
    <form id="my-form" action="edit_update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" id="bno" name="bno" value="<?=$bNO?>">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" name="bEmail" id="bEmail"  value="<?=$email?>" hidden>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <input type="text" class="form-control" name="bName" id="bName" value="<?=$user_name?>" hidden>
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
            <a href="/forum.php" class="btn-light btn">목록</a>
            <button id="submit-button" type="submit" class="btn btn-primary">글 수정하기</button>
        </div>
        <hr/>
        <div style="color: red"><h6>파일 재 업로드 시, 기존 파일은 삭제 됩니다</h6></div>
        <hr>
        <div class="form-group">
            <lable>stl 파일 : </lable>
            <input id="stl-input" class="fileinput" type="file" accept=".stl" name="stl-upload[]" multiple="multiple">
        </div>
        <div class="form-group">
            <lable>이미지 파일 : </lable>
            <input id="img-input" class="fileinput" type="file" accept=".png, .jpg" name="img-upload[]" multiple="multiple">
        </div>
        <div id="file-over-waring" style="color: red">
            <h6>이미지 파일이나 stl 파일은 각각 5개를 넘을 수 없습니다. 다시 선택 해주세요</h6>
        </div>
    </form>
</div>

<?php
}
?>


<iframe name="my-iframe" src="login_process.php" frameborder="0" style="width:0; height:0; border:0; border:none"></iframe>
<script src="./js/modal.js"></script>
<script>
    $('#bContent').val('<?=$content?>');
    $('#bTitle').val('<?=$title?>');

    function newWindow() {
        const url = "password_resset.html";
        window.open(url,"","width=500,height=250");
    }

    const stlInput = $('#stl-input');
    const imgInput = $('#img-input');

    $('#file-over-waring').hide();
    $('.fileinput').change(function(){
        if(document.getElementById('img-input').files.length>5
            || document.getElementById('stl-input').files.length>5) {
            Swal.fire("오류", "파일은 5개 까지 업로드 가능합니다", "error")
            $('#submit-button').attr("disabled", true);
            $('#file-over-waring').show();
        }
        else {
            $('#submit-button').attr("disabled", false);
            $('#file-over-waring').hide();
        }
    });
</script>
</body>
</html>