<?php
    require_once("dbconfig.php");

    $sql = 'SELECT * FROM board_free ORDER BY b_no DESC';
    $result = $db -> query($sql);
    //총 게시글의 개수
    $num = mysqli_num_rows($result);

    $list = 10;
    $block = 3;
    $page =  ($_GET['page'])?$_GET['page']:1;

    //총 페이지 수 구하기 : 게시글 수 / 1개 페이지 당 표시할 게시글 수
    $pageNum = ceil($num/$list);
    //페이지 번호가 아웃오브바운드 인 경우 조정
    if($page <= 1) {
        $page = 1;
    }
    if($page >= $pageNum) {
        $page = $pageNum;
    }
    //총 블록 수 구하기 : 페이지 수 / 1개 페이지 당 표시할 블록
    $blockNum = ceil($pageNum/$block);
    $nowBlock = ceil($page/$block);

    $s_page = ($nowBlock * $block) -($block - 1);
    if($s_page <= 1) {
        $s_page = 1;
    }
    $e_page = $nowBlock * $block;
    if($pageNum <= $e_page) {
        $e_page = $pageNum;
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forums</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/forum.css">
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
<div style="margin-top: 58px"></div>
<div class="container">
    <h1 style="font-weight:bold; font-size: 25px; margin-top: 10px; margin-bottom: 10px"> 게시판</h1>

    <table class="table table-hover">
        <thead class="text-white bg-primary">
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>작성자</th>
            <th>날짜</th>
            <th>조회수</th>
        </tr>
        </thead>
        <tbody>
            <?php
                $s_point = ($page-1) * $list;
                $sql="select * from board_free order by b_no desc limit $s_point, $list";
                $result = $db -> query($sql);

                while($row = mysqli_fetch_array($result)) {
                //오늘 날짜를 기준으로 날짜를 표시 할지 시간을 표시할 지 선택
                $datetime = explode(' ', $row['b_date']);
                $date = $datetime[0];
                $time = $datetime[1];
                if($date == Date('Y-m-d'))
                    $row['b_date'] = $time;
                else
                    $row['b_date'] = $date;
            ?>
            <tr>
                <td><?php echo $row[b_no]?></td>
                <td id="my-hyperlink" class="text-break">
                    <span class="d-inline-block text-truncate align-middle" style="max-width: 30vw">
                        <style type="text/css">
                            #my-hyperlink a:link {text-decoration: none; color: black}
                            #my-hyperlink a:visited {color: lightgray}
                            #my-hyperlink a:hover {color: blue}
                        </style>
                        <a href="http://localhost/view.php?bno=<?php echo$row[b_no]?>">
                            <?php echo $row[b_title]?>
                        </a>
                    </span>
                </td>
                <td><?php echo $row[b_id]?></td>
                <td><?php echo $row[b_date]?></td>
                <td><?php echo $row[b_hit]?></td>
            </tr>
            <?php
                }
            ?>

        </tbody>
    </table>

    <hr/>

    <nav aria-label="Page navigation">
        <div class="d-flex justify-content-end">
            <a href="http://localhost/write.php" type="button" class="btn btn-light">글쓰기</a>
        </div>
        <div class="d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="http://localhost/forum.php?page=<?=$s_page-1?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?php
                for ($p=$s_page; $p<=$e_page; $p++) {
                    ?>
                    <li class="page-item <?php if($p == $page) {echo "active";}?>">
                        <a class="page-link" href="http://localhost/forum.php?page=<?=$p?>"><?=$p?></a>
                    </li>
                    <?php
                }
                ?>
                <li class="page-item">
                    <a class="page-link" href="http://localhost/forum.php?page=<?=$e_page+1?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

</div>
</body>
</html>
