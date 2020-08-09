let pageNum = 1;

//post방식으로 크롤링할 페이지 번호 입력
//php 파일이 리턴하는 값은 html 형식으로 되어있음
//본 함수는 php 파일이 리턴한 값을 body에 추가시킴
function getNewsData(pageNum) {
    $.post(
        "news_crawler.php",
        { pageNum : pageNum },
        function (data) {
            if(data) {
                $("body").append(data);
            }
        }
    )
}

//페이지 로드시 초기 화면 표시하기 위해 getNewsData 실행
getNewsData(1);

//최하단으로 스크롤 할 시, getNewsData 함수 실행 
$(window).scroll(function() {
    if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
        console.log(++pageNum);
        getNewsData(pageNum);
    }
});