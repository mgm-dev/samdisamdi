<?php
//본 php파일은 infiniteScroll.html에 포함되어 있는
//infiniteScroll.js에서 ajax로 호출됨
//본 php파일은 뉴스 게시판을 크롤링 한 후
//html형식의 데이터를 리턴함

include_once ('simple_html_dom.php');
/**
 * 크롤링할 사이트 : www.3dguru.co.kr
 * 라이센스 : 저작자표시-비영리-변경금지 2.0 대한민국
 */

//post 방식으로 페이지 넘버를 받아서, 크롤링할 페이지 링크를 결정함
$page_num = $_POST['pageNum'];

//크롤링할 페이지 링크, 뉴스 기사 게시판
//크롤링할 페이지는 get 방식으로 페이징이 되어있음
$html = file_get_html('http://www.3dguru.co.kr/bbs_shop/list.htm?page=' . $page_num . '&me_popup=&board_code=newsroom&cate_sub_idx=0');

$dates = $html->find('.date');
$contents = $html->find('.contents');
$url = $html->find('.dis_mo');
$image_container = $html->find('dt');

//<dt> 태그안에 있는 앵커 중 첫번째 값은 필요 없음으로 배열에서 삭제
array_shift($image_container);


$article =[];
for($i = 0; $i < 8; $i++) {
    $article[$i]->title = $url[$i]->children(0)->children(0)->innertext;
    $article[$i]->content = $contents[$i]->innertext;
    $article[$i]->date = $dates[$i]->innertext;
    $article[$i]->link = "http://www.3dguru.co.kr" . $url[$i]->children(0)->href;
    $article[$i]->image = "http://www.3dguru.co.kr" . $image_container[$i]->children(1)->children(0)->src;
}

?>
<div class="outer-box">
<?php for($i = 0; $i < 8; $i++) {
?>
    <div class="inner-box" style="width: ">
        <div class="img-box"><img class="img-thumbnail" src="<?=$article[$i]->image?>"></div>
        <div class="content-box">
            <div>날짜 : <?=$article[$i]->date?> &nbsp &nbsp &nbsp 출처 : 3Dguru.co.kr</div>
            <hr/>
            <a href="<?=$article[$i]->link?>" target="_blank">
                <span class="title-text"><?=$article[$i]->title?></span>
            </a>
        </div>
    </div>
<?php }
?>
</div>