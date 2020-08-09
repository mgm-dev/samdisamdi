<?php
include_once('dbconfig.php');

$sql = 'SELECT * FROM board_free ORDER BY b_no DESC';
$result = $db -> query($sql);
//총 게시글의 개수
$num = mysqli_num_rows($result);

$list = 2;
$block = 2;
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

echo "현재 페이지는".$page."<br/>";
echo "현재 블록은".$nowBlock."<br/>";

echo "현재 블록의 시작 페이지는".$s_page."<br/>";
echo "현재 블록의 끝 페이지는".$e_page."<br/>";

echo "총 페이지는".$pageNum."<br/>";
echo "총 블록은".$blockNum."<br/>";

for ($p=$s_page; $p<=$e_page; $p++) {
?>
    <a href="http://localhost/forum_pagenation.php?page=<?=$p?>"><?=$p?></a>
<?php
    }
?>
<div>
    <a href="http://localhost/forum_pagenation.php?page=<?=$s_page-1?>">이전</a>
    <a href="http://localhost/forum_pagenation.php?page=<?=$e_page+1?>">다음</a>
</div>

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
