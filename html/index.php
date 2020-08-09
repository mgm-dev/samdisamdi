<?php
require_once "dbconfig.php";

session_start();

$sql = "select * from board_file order by b_no desc limit 5";
$result = mysqli_query($db, $sql);
$sql2 = "select * from board_file order by b_like desc limit 5";
$result2 = mysqli_query($db, $sql2);
mysqli_close($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NB4PN35');</script>
    <!-- End Google Tag Manager -->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-166857850-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-166857850-1');
    </script>

    <meta charset="UTF-8">
    <meta name="title" content="삼디삼디-3D 프린팅 파일 공유 커뮤니티 samdisamdi">
    <meta name="keywords" content="삼디삼디, 3D3D, samdisamdi, 3프린팅, 3D모델, 3D프린터">
    <meta name="description" content="삼디삼디는 3D프린팅 가능한 stl파일을 공유하고, 3D프린팅 관련 취미 정보를 공유하는 커뮤니티 웹사이트입니다.">
    <title>삼디삼디-3D 프린팅 파일 공유 커뮤니티 samdisamdi</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/forum.css">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/test.css">
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googlehtml 새창 띄우기tagmanager.com/ns.html?id=GTM-NB4PN35"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<section id="introduction">
    <div class="container">
        <section id="intro-text">
            <img src="images/intro-text.png" alt="삼디삼디 메인페이지 텍스트 이미지">
        </section>
        <section id="intro-image">
            <img src="images/intro-image.png" alt="삼디삼디 메인페이지 인포그래픽 이미지">
        </section>
    </div>
</section>


<div class="container">
    <table class="table table-hover" style="float: left; width: 45%">
        <thead class="text-black bg-white">
        <tr>
            <th>번호</th>
            <th>최신글</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $index = 1;
        while($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $index++?></td>
                <td id="my-hyperlink" class="text-break">
                    <div id="my-link-div" onclick="location.href='/view.php?bno=<?php echo$row[b_no]?>'">
                        <span class="d-inline-block text-truncate align-middle" style="max-width: 20vw">
                            <a href="/view.php?bno=<?php echo$row[b_no]?>">
                                <?php echo $row[b_title]?>
                            </a>
                        </span>
                    </div>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>

    <table class="table table-hover" style="float: right; width: 45%">
        <thead class="text-black bg-white">
        <tr>
            <th>번호</th>
            <th>인기글</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $index = 1;
        while($row2 = mysqli_fetch_array($result2)) {
            ?>
            <tr>
                <td><?php echo $index++?></td>
                <td id="my-hyperlink" class="text-break">
                    <div id="my-link-div" onclick="location.href='/view.php?bno=<?php echo$row2[b_no]?>'">
                        <span class="d-inline-block text-truncate align-middle" style="max-width: 20vw">
                            <a href="/view.php?bno=<?php echo$row2[b_no]?>">
                                <?php echo $row2[b_title]?>
                            </a>
                        </span>
                    </div>
                </td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<div style="margin-top: 100px"></div>


<!-- Team -->
<section id="team" class="pb-5">
    <div class="container" style="overflow: hidden">
        <h5 class="section-title h1">About</h5>
        <div class="row">
            <!-- Team member -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class="img-fluid" src="images/board.png" alt="card image"></p>
                                    <h4 class="card-title">게시판</h4>
                                    <p class="card-text">STL 파일, 사진 공유 게시판</p>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">게시판</h4>
                                    <p class="card-text">STL 파일은 3D 프린팅에 사용 되는 파일 확장자명입니다. 삼디삼디의 게시판은 STL 파일 미리보기 기능을 지원합니다.</p>
                                    <a href="/forum.php">게시판 바로가기</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Team member -->
            <!-- Team member -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="images/chat.png" alt="card image"></p>
                                    <h4 class="card-title">채팅</h4>
                                    <p class="card-text">비로그인 오픈 채팅</p>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">채팅</h4>
                                    <p class="card-text">삼디삼디에서 3D 프린팅에 관심이 있는 사람들과 익명 채팅을 즐겨보세요.</p>
                                    <a onclick="newWindow()" class="text-hover-underline"><span>채팅방 바로가기</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Team member -->
            <!-- Team member -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="images/news.png" alt="card image"></p>
                                    <h4 class="card-title">뉴스</h4>
                                    <p class="card-text">3D 프린팅 관련 뉴스</p>
                                </div>
                            </div>
                        </div>
                        <div class="backside">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="card-title">뉴스</h4>
                                    <p class="card-text">3D 프린팅 관련 뉴스와 칼럼을 삼디삼디에서 편하게 확인 하세요.</p>
                                    <a href="/infiniteScroll.html">뉴스 바로가기</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./Team member -->
        </div>
    </div>
</section>
<!-- Team -->

<div id="test-id" class="container">
    <section id="contact-box-left">
        <h5 class="h1">Contact</h5>
        <hr/>
        <h5>email : tommin231@naver.com</h5>
        <hr>
        <form name="complain-form" action="send_complain_email.php" method="post">
            <div class="form-group">
                <input type="email" class="form-control" id="email" name="email"  placeholder="이메일" required>
            </div>
            <div class="form-group">
                <input type="name" class="form-control" id="name" name="name" placeholder="이름" required>
            </div>
            <div class="form-group">
                <textarea class="form-control" id="content" name="content" rows="10" placeholder="문의사항을 남겨주세요" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" onclick="sendComplain">보내기</button>
        </form>
    </section>
</div>

<footer id="main-footer">
    <p>Copyright &copy; 2020 SamdiSamdi, TeamNova 6 MGM</p>
</footer>


<header id="my-main-header">
    <div class="my-container">
        <h1>삼디삼디</h1>
        <ul>
            <li><a href="/index.php" target="_self">Home</a></li>
            <li><a href="/mypage.php" target="_self">MyPage</a></li>
            <li><a href="/forum.php" target="_self">Forums</a></li>
            <li><a href="/infiniteScroll.html">News</a></li>
        </ul>
    </div>
</header>
</body>

<script>
    function newWindow() {
        const url = "https://www.samdisamdi.com:6848";
        window.open(url,"","width=500,height=280");
    }
</script>
</html>

