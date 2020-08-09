<?php
    require_once("dbconfig.php");
    //게시글 번호 bno을 get으로 받은 경우에만 $bNo 변수 선언
    if(isset($_GET['bno'])) {
        $bNo = $_GET['bno'];
    }

    //조회수 1증가 시키기, 쿠키를 사용하여 조회수 증가 24시간당 1회로 제한
    if(!empty($bNo) && empty($_COOKIE['board_free_' . $bNo])) {
        $sql = 'update board_free set b_hit = b_hit + 1 where b_no = ' . $bNo;
        $result = $db->query($sql);
        setcookie('board_free_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
    }

    if(isset($bNo)) {
        $sql = 'select b_title, b_content, b_id from board_free where b_no = ' . $bNo;
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
    }
    $sql = 'select b_title, b_content, b_date, b_hit, b_id from board_free where b_no = ' . $bNo;
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>ViewPost</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="../css/view.css">
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

<div class="container" style="margin-top: 58px">
    <div id="my-main-post">
        <h1 class="text-break"><?php echo $row['b_title']?></h1>
        <h5>by <?php echo $row['b_id']?></h5>
        <hr/>
        <h5>Posted on <?php echo $row['b_date']?></h5>
        <hr/>
        
        <h4>사진</h4>
        
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                <li data-target="#myCarousel" data-slide-to="4"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" style=" height: auto !important;">

                <div class="item active">
                    <img src="../images/printer1.jpg" alt="Los Angeles" style="width:100%;">
                    <div class="carousel-caption">
                    </div>
                </div>

                <div class="item">
                    <img src="../images/printer2.jpg" alt="Chicago" style="width:100%;">
                    <div class="carousel-caption">
                    </div>
                </div>

                <div class="item">
                    <img src="../images/printer3.jpg" alt="New York" style="width:100%;">
                    <div class="carousel-caption">
                    </div>
                </div>

                <div class="item">
                    <img src="../images/cat.jpg" alt="New York" style="width:100%;">
                    <div class="carousel-caption">
                    </div>
                </div>

                <div class="item">
                    <img src="../images/legs.jpg" alt="New York" style="width:100%;">
                    <div class="carousel-caption">
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <hr/>

        <h4>미리보기기</h4>

       <div id="stl_cont" style=" border: #6f42c1 solid 1px; width:100%;height:500px;margin:0 auto;"></div>

        <script src="../stl_plugin/stl_viewer.min.js"></script>
        <script>
            var stl_viewer=new StlViewer
            (
                document.getElementById("stl_cont"),
                {
                    cameray : -40,
                    models:
                        [
                            {filename:"./uploads/test/DarkCleric.stl"}
                        ]
                }
            );

        </script>



        <hr/>
        <h4><?php echo nl2br($row['b_content'])?></h4>
        <hr/>
    </div>

    <div id="my-sidebar">
        <div id="my-search-bar">
            <div id="my-search-bar-title">
                <h5>게시글 검색하기</h5>
            </div>
            <hr/>
            <div class="form-group">
                <form action="#">
                    <input type="text" placeholder="제목으로 검색">
                    <button type="submit">검색</button>
                </form>
            </div>
        </div>
        <div id="my-button-box">
            <div id="my-button-box-title">
                <h5>글 수정하기</h5>
            </div>
            <hr/>
            <a href="http://localhost/delete.php?bno=<?php echo $bNo?>">게시글 삭제</a>
            <br/>
            <a href="http://localhost/edit_verify.php?bno=<?php echo $bNo?>">게시글 수정</a>
            <br/>
            <a href="http://localhost/forum.php">게시글 목록</a>
        </div>
        <div id="my-side-box">
            <div id="my-button-box-title">
                <h5>추가 사이드바 기능</h5>
            </div>
            <hr/>
            이곳에 추가할 기능은 현재 기획 중입니다.
        </div>
    </div>
</div>



</body>
</html>