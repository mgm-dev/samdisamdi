<?php
include_once('simple_html_dom.php');
/**
 * 크롤링할 사이트 : www.3dguru.co.kr
 * 라이센스 : 저작자표시-비영리-변경금지 2.0 대한민국
*/
$page_num = $_POST['pageNum'];

$html = file_get_html('http://www.3dguru.co.kr/bbs_shop/list.htm?page=' . $page_num . '&me_popup=&board_code=newsroom&cate_sub_idx=0');

$dates = $html->find('.date');
$contents = $html->find('.contents');
$url = $html->find('.dis_mo');
$image_container = $html->find('dt');

//<dt> 태그안에 있는 앵커 중 첫번째 값은 필요 없음으로 배열에서 삭제
array_shift($image_container);

for($i =0; $i < 8; $i++) {
    //json으로 인코딩할 배열
    //8개의 기사에 대한 정보를 $article_info[]에 저장함
    //$article_info[n]에는, 제목, 내용, 날짜, 하이퍼링크, 썸네일 링크를 저장함
    $article_info[$i] = array(
        "title" => $url[$i]->children(0)->children(0)->innertext,
        "content" => $contents[$i]->innertext,
        "date" => $dates[$i]->innertext,
        "link" => "http://www.3dguru.co.kr" . $url[$i]->children(0)->href,
        "image" => "http://www.3dguru.co.kr" . $image_container[$i]->children(1)->children(0)->src
        );
}

//$article_info를 json으로 인코딩
//한글 깨지지 않게 utf-8 설정
for($i = 0; $i < 8; $i++) {
    $article_json[$i] = json_encode($article_info[$i], JSON_UNESCAPED_UNICODE);
}

//데이터 출력
for($i=0; $i<8; $i++){
    echo $article_json[$i] . '!!@@##divider##@@!!';
}
?>

<div class="outer-box">
    <div class="inner-box">
        <div class="img-box"><img src="" alt="img0"></div>
        <div class="content-box">
            <div>date</div>
            <hr/>
            <div>title</div>
            <div>content</div>
        </div>
    </div>
    <div class="inner-box">
        <div class="img-box"><img src="" alt="img1"></div>
        <div class="content-box">
            <div>date</div>
            <hr/>
            <div>title</div>
            <div>content</div>
        </div>
    </div>
    <div class="inner-box">
        <div class="img-box"></div>
        <div class="content-box">
            <div>date</div>
            <hr/>
            <div>title</div>
            <div>content</div>
        </div>
    </div>
    <div class="inner-box">
        <div class="img-box"></div>
        <div class="content-box">
            <div>date</div>
            <hr/>
            <div>title</div>
            <div>content</div>
        </div>
    </div>
    <div class="inner-box">
        <div class="img-box"></div>
        <div class="content-box">
            <div>date</div>
            <hr/>
            <div>title</div>
            <div>content</div>
        </div>
    </div>
    <div class="inner-box">
        <div class="img-box"></div>
        <div class="content-box">
            <div>date</div>
            <hr/>
            <div>title</div>
            <div>content</div>
        </div>
    </div>
    <div class="inner-box">
        <div class="img-box"></div>
        <div class="content-box">
            <div>date</div>
            <hr/>
            <div>title</div>
            <div>content</div>
        </div>
    </div>
    <div class="inner-box">
        <div class="img-box"></div>
        <div class="content-box">
            <div>date</div>
            <hr/>
            <div>title</div>
            <div>content</div>
        </div>
    </div>
</div>
