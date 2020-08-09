<?php
    //세션 시작
    //세션에는 로그인 유무, 사용자 이름, 사용자 이메일이 저장됨
    session_start();
    if($_SESSION['is_login']) {
        $is_login = $_SESSION['is_login'];
        $user_name = $_SESSION['user_name'];
        $email = $_SESSION['email'];
    }
    else {
        $is_login = false;
    }

    require_once("dbconfig.php");
    //게시글 번호 bno을 get으로 받은 경우에만 $bNo 변수 선언
    if(isset($_GET['bno'])) {
        $bNo = $_GET['bno'];
    }

    //조회수 1증가 시키기, 쿠키를 사용하여 조회수 증가 24시간당 1회로 제한
    if(!empty($bNo) && empty($_COOKIE['board_file_' . $bNo])) {
        $sql = 'update board_file set b_hit = b_hit + 1 where b_no = ' . $bNo;
        $result = $db->query($sql);
        setcookie('board_file_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
    }

    $sql = 'select * from board_file where b_no = ' . $bNo;
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    //좋아요 갯수 변수로 저장
    $like = $row['b_like'];

    //파일이 저장 되어 있는 다이렉토리(폴더 이름)를 쿼리로 리턴된 배열에서 조합
    //다이렉토리 : uploads/유저이름/유저이메일/글작성시간
    $dir = "uploads/" .
        $row['b_name'] .
        $row['b_email'] .
        date("YmdHis", strtotime($row[b_date]));

    //glob 함수로 확장자별로 구분 된 파일 다이렉토리 배열 생성
    //$images = {uploads/유저1/이메일1/시간1/사진1, uploads/유저1/이메일1/시간1/사진2, ...}
    //$stls = {uploads/유저1/이메일1/시간1/stl1, uploads/유저1/이메일1/시간1/stl2, ...}
    if (glob($dir . "/*.{jpg,png}", GLOB_BRACE) != false) {
        $images = glob($dir . "/*.{jpg,png}", GLOB_BRACE);
    }
    if (glob($dir . "/*.stl") != false) {
        $stls = glob($dir . "/*.stl");
    }

    //이미지가 몇개인지 확인해서 변수로 저장, 추후 html 코드 추가 할때 사용
    $imagesNumber = count($images);
    //stl 파일이 몇장인지 확인해서 변수로 저장, 추후 html 코드 추가 할때 사용
    $stlsNumber = count($stls);


    //좋아요 관련 체크
    //게시글 번호와 현재 로그인 한 사용자 이메일을 조건으로 select
    $sqlLikeCheck = "SELECT COUNT(*) FROM board_like WHERE post_id = '{$bNo}' AND user_email = '{$email}'";
    $resultLikeCheck = mysqli_query($db, $sqlLikeCheck);
    $rowLikeCheck = $resultLikeCheck->fetch_assoc();

    //현재 로그인한 사용자가 게시글을 좋아요 했는지 변수로 저장
    //해당 변수에 따라 좋아요 버튼을 활성화 비활성화 결정
    $didUserLike = 0;
    if($rowLikeCheck["COUNT(*)"] == 1 ) {
        $didUserLike = true;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta charset="utf-8" />
    <title>ViewPost</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <link rel="stylesheet" href="css/view.css">
    <link rel="stylesheet" href="css/loader.css">
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

<div class="container" style="margin-top: 58px">
    <div id="my-main-post">
        <h1 class="text-break"><?php echo $row['b_title']?></h1>
        <h5>by <?php echo $row['b_name']?></h5>
        <hr/>
        <h5>Posted on <?php echo $row['b_date']?></h5>
        <hr/>


        <h4>사진</h4>

        <div id="myCarousel" class="carousel slide" data-ride="carousel" >
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <?php
                for($i = 1; $i < $imagesNumber; $i++) {
                ?>
                    <li data-target="#myCarousel" data-slide-to="<?=$i?>"></li>
                <?php
                }
                ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" style="height: 400px">
                <div class="item active">
                    <img src="<?=$images[0]?>" style="height: 400px; width: auto; margin: auto">
                    <div class="carousel-caption d-none d-md-block">
                        <?php
                        if($imagesNumber < 1) {
                            echo "이미지가 없습니다";
                        }
                        ?>
                    </div>
                </div>
                <?php
                for($i = 1; $i < $imagesNumber; $i++) {
                ?>
                <div class="item">
                    <img src="<?=$images[$i]?>" style="height: 400px; width: auto; margin: auto">
                    <div class="carousel-caption">
                    </div>
                </div>
                <?php
                }
                ?>
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

        <h4>미리보기</h4>
        <button id="stl-button0" class="btn btn-primary btn-change" onclick="load0()">1번 파일</button>
        <?php
        for($i = 1; $i < $stlsNumber; $i++) {
            ?>
            <button id="stl-button<?=$i?>" class="btn btn-light btn-change" onclick="load<?=$i?>()"><?=$i+1?>번 파일</button>
        <?php
        }
        ?>


        <div id="stl_cont" style=" border: #6f42c1 solid 1px; width:100%;height:500px;margin:0 auto;">
            <?php
            if($stlsNumber < 1) {
                echo "stl 파일이 없습니다";
            }
            else {
                ?>
                <div id="loading-tag" class="loader" style="margin-top: 225px"></div>
                <?php
            }
            ?>
        </div>
        <hr/>
        <h4><?php echo nl2br($row['b_content'])?></h4>
        <hr/>
        <div class="my-comment-box">
            <form action="comment_update.php" method="post">
                <h4>댓글 쓰기</h4>
                <hr/>
                <input type="hidden" name="email" value="<?=$email?>">
                <input type="hidden" name="name" value="<?=$user_name?>">
                <input type="hidden" name="bno" value="<?=$bNo?>">
                <div class="form-group">
                    <textarea class="form-control" name="coContent" id="coContent" rows="5" maxlength="200" required style="resize: none;"></textarea>
                </div>
            </form>
            <button class="btn btn-primary" onclick="writeComment();">댓글쓰기</button>
        </div>
        <?php
        include 'comment.php';
        ?>
    </div>

    <div id="my-sidebar">
        <div id="my-search-bar">
            <div id="my-search-bar-title">
                <h5>게시글 검색하기</h5>
            </div>
            <hr/>
            <div class="form-group">
                <form action="/forum.php?" method="get">
                    <input type="text" name="search" placeholder="제목으로 검색">
                    <input type="hidden" name="search-type" value="title">
                    <button type="submit">검색</button>
                </form>
            </div>
        </div>
        <div id="my-button-box">
            <div id="my-button-box-title">
                <span>좋아요 : </span>
                <span id="like-number"><?=$like?></span>
                <button id="like-button" onclick="likePost(<?=$bNo?>)">🤍</button>
                <button id="unlike-button" onclick="unlikePost(<?=$bNo?>)">❤️</button>

            </div>
            <hr/>
            <a onclick="deletePost()" style="cursor: pointer">게시글 삭제</a>
            <br/>
            <a onclick="editPost()" style="cursor: pointer">게시글 수정</a>
            <br/>
            <a href="/forum.php">게시글 목록</a>
        </div>
        <div id="my-side-box">
            <div id="my-button-box-title">
                <h5>파일 다운로드</h5>
            </div>
            <hr/>
            <?php
            for($i = 0; $i < $stlsNumber; $i++) {
                ?>
                <a href="/stl_file_download.php?dir=<?=$dir?>&num=<?=$i?>"><?=$i + 1?>번 파일</a>
                <br/>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<script src="./stl_plugin/stl_viewer.min.js"></script>
<script>
    //좋아요 관련 스크립트
    $("#like-button").hide();
    $("#unlike-button").hide();

    if(<?=$didUserLike?>) {
        $("#unlike-button").show();
    }
    else {
        $("#like-button").show();
    }

    function likePost() {
        let bno = '<?=$bNo?>';
        let email = '<?=$email?>';
        let likeNumber = $("#like-number").text();

        if(email != "") {
            likeNumber++;
            $("#like-number").text(likeNumber);
            $("#unlike-button").show();
            $("#like-button").hide();

            $.post(
                "like_post.php",
                {
                    bno : bno,
                    email : email
                }
            )
        }
        else {
            Swal.fire(
                "좋아요 실패",
                "로그인이 필요합니다",
                "error"
            )
        }
    }

    function unlikePost() {
        let bno = '<?=$bNo?>';
        let email = '<?=$email?>';
        let likeNumber = $("#like-number").text();

        likeNumber--;
        $("#like-number").text(likeNumber);
        $("#like-button").show();
        $("#unlike-button").hide();

        $.post(
            "unlike_post.php",
            {
                bno : bno,
                email : email
            }
        )
    }
    
    //게시글 수정 스크립트
    function editPost() {
        //게시글 번호 변수
        let bno = '<?=$bNo?>';
        
        //is_login 변수로 로그인 유무 확인
        const isLogin = '<?=$is_login?>';
        if(!isLogin) {
            Swal.fire(
                '게시글 수정 실패',
                '로그인이 필요합니다',
                'error'
            )
        }
        //로그인 되어 있는 경우 check_post_data.php로
        //작성자 이메일과 현재 로그인 사용자 이메일 비교
        else {
            $.post(
                "check_post_data.php",
                {
                    bno : bno
                },
                function (data) {
                    if(data) {
                        window.location.href = 'edit.php?bno=<?=$bNo?>';
                    }
                    else {
                        Swal.fire(
                            "게시글 수정 실패",
                            "본인이 쓴 글이 아닙니다",
                            "error"
                        )
                    }
                }
            )
        }

    }
    
    //게시글 삭제 스크립트
    function deletePost() {
        let bno = '<?=$bNo?>';

        //세션으로 체그해서 저장한 변수 is_login으로 로그인 유무 확인
        const isLogin = '<?=$is_login?>';
        if(!isLogin) {
            Swal.fire(
                '게시글 삭제 실패',
                '로그인이 필요합니다',
                'error'
            )
        }
        //로그인 되어있는 경우 check_post_data.php로
        //작성자 이메일과 현재 로그인 사용자 이메일 비교
        else {
            $.post(
                "check_post_data.php",
                {
                    bno : bno
                },
                //check_post_data.php는 작성자 이메일과 현재 로그인 사용자 이메일이
                //동일한 경우에만 리턴 값이 있음
                function (data) {
                    //따라서 리턴값이 널이 아닌 경우 다음 단계로 넘어감
                    if(data) {
                        //새로운 모달 창으로 게시글 삭제할지 재확인
                        Swal.fire(
                            '게시글 삭제',
                            '게시글을 삭제하시겠습니까?',
                            'question'
                        ).then(function () {
                            //delete.php 통해서 게시글 삭제
                            //delete.php는 삭제 성공시에만 리턴 값이 있음
                            $.post(
                                "delete.php",
                                {
                                    bno : bno
                                },
                                function (data) {
                                    //삭제 성공 시
                                    if(data) {
                                        Swal.fire(
                                            "삭제성공"
                                        ).then(function () {
                                            location.href="forum.php"
                                        })
                                    }
                                    //삭제 실패 시
                                    else {
                                        Swal.fire(
                                            "삭제실패"
                                        )
                                    }
                                }
                            )
                        })
                    }
                    //본인이 쓴 게시글이 아닌 경우
                    else {
                        Swal.fire(
                            "게시글 삭제 실패",
                            "본인이 쓴 게시글이 아닙니다.",
                            "error"
                        )
                    }
                }
            )
        }
    }

    //댓글 작성 스크립트
    function writeComment() {
        //세션으로 체그해서 저장한 변수 is_login으로 로그인 유무 확인
        const isLogin = '<?=$is_login?>';
        if(!isLogin) {
            Swal.fire(
                '댓글 작성 실패',
                '로그인이 필요합니다',
                'error'
            )
        }
        else {
            let email = '<?=$email?>';
            let name = '<?=$user_name?>';
            let coContent = $("#coContent").val();
            let bno = '<?=$bNo?>'
            //내용을 작성 안한 경우
            if (coContent === "") {
                Swal.fire(
                    '댓글 작성 실패',
                    '댓글 내용을 작성하세요',
                    'error'
                )
            }
            //내용을 작성한 경우
            else {
                $.post(
                    "comment_update.php",
                    {
                        email : email,
                        name : name,
                        coContent : coContent,
                        bno : bno,
                    },
                    function (data) {
                        if(data){
                            Swal.fire(
                                '댓글 작성 성공',
                                '댓글을 작성 했습니다',
                                'success'
                            ).then(function () {
                                location.reload();
                            })
                        }
                        else {
                            Swal.fire(
                                '댓글 작성 실패',
                                '오류가 발생했습니다',
                                'error'
                            )
                        }
                    }
                )
            }

        }
    }

    const stl_viewer=new StlViewer(document.getElementById("stl_cont"),
        {
            all_loaded_callback : load_end,
            cameray : -40,
            models:
                [
                    {filename:"<?=$stls[0]?>"}
                ]
        }
    );

    function load_end() {
        $('#loading-tag').hide();
    }

    function load0() {
        $('#loading-tag').show();

        $('.btn-change').attr('class', 'btn btn-light btn-change');

        document.getElementById('stl-button0').className = "btn btn-primary btn-change"

        stl_viewer.clean();
        stl_viewer.add_model({filename: "<?=$stls[0]?>"});
    }
    function load1() {
        $('#loading-tag').show();

        $('.btn-change').attr('class', 'btn btn-light, btn-change');

        document.getElementById('stl-button1').className = "btn btn-primary btn-change"

        stl_viewer.clean();
        stl_viewer.add_model({filename: "<?=$stls[1]?>"});
    }
    function load2() {
        $('#loading-tag').show();

        $('.btn-change').attr('class', 'btn btn-light btn-change');

        document.getElementById('stl-button2').className = "btn btn-primary btn-change"

        stl_viewer.clean();
        stl_viewer.add_model({filename: "<?=$stls[2]?>"});
    }
    function load3() {
        $('#loading-tag').show();

        $('.btn-change').attr('class', 'btn btn-light btn-change');

        document.getElementById('stl-button3').className = "btn btn-primary btn-change"

        stl_viewer.clean();
        stl_viewer.add_model({filename: "<?=$stls[3]?>"});
    }
    function load4() {
        $('#loading-tag').show();

        $('.btn-change').attr('class', 'btn btn-light btn-change');

        document.getElementById('stl-button4').className = "btn btn-primary btn-change"

        stl_viewer.clean();
        stl_viewer.add_model({filename: "<?=$stls[4]?>"});
    }
</script>

</body>
</html>