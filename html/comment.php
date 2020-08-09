<?php
//본 파일은 게시글 조회 페이지를 출력하는 파일 view.php에 include 되어 사용됨
//본 파일은 댓글과 대댓글을 출력함

/**댓글 대댓글 구별 로직
 *
 * 깊이1 -> 댓글
 * 깊이2 -> 대댓글
 *
 * 댓글
 *
 * 댓글과 대댓글에는 고유번호와 순서번호가 있음
 * 이에 해당 하는 column 명은 co_no와 co_order임
 *
 * 고유번호는 해당 댓글의 깊이와 관계 없이 작성 순 대로 auto increment 되는 key 값임
 * 순서번호는 다음과 같이 결정됨
 *
 * 댓글 -> 순서번호 = 고유번호
 * 대댓글 ->  순서번호 = 대댓글이 달린 댓글의 고유번호
 *
 * 즉 1번 댓글에 대댓글이 달리면
 * 대댓글의 고유번호는 2가 되고 순서번호는 1이 됨
 *
 * 댓글 고유 번호 == 댓글 순서 인 경우 댓글
 * 댓글 고유 번호 != 댓글 순서 인 경우 대댓글
 **/

//댓글만 선택해오는 쿼리문
//댓글 고유 번호와 댓글 순서가 같은 댓글만 선택
$sql = "SELECT *FROM comment_free WHERE b_no= '$bNo' AND co_no = co_order";
//$db는 view.php에서 dbconfig.php를 통해 설정 되어있음
$result = $db->query($sql);

?>
<!--todo:JS 분리 시키면서 필요한지 확인 후 필요 없는 경우 삭제 -->
<span id="data" data-isLogin="<?=$is_login?>" data-email="<?=$email?>"></span>

<?php
//아래에서 부터 이중 while문으로 댓글과 대댓글을 출력할 것임
//외부 while문은 댓글을 출력하고 내부 while문은 대댓글을 출력함

//외부 while문
//db에 저장되어있는 댓글(깊이1) 총 개수 만큼 while문이 돌아감
while($row = $result->fetch_assoc()) {
?>

        <div id="co_<?=$row['co_no']?>" class="my-comment-box"> <!--댓글 컨테이너-->
            <h4 style="font-weight: bold;"><?=$row['co_name']?></h4> <!--댓글 작성자-->
            <h4><?=nl2br($row['co_content'])?></h4> <!--댓글 내용-->
            <hr/>
            <a onclick="showReply(<?=$row['co_no']?>)">답글</a> <!--답글 작성 하기 버튼-->
            <a onclick="showEdit(<?=$row['co_no']?>, '<?=$row['co_content']?>')">수정</a> <!--수정 하기 버튼-->
            <a onclick="deleteComment(<?=$row['co_no']?>)">삭제</a> <!--삭제 하기 버튼 버튼-->
        </div>
        <div id="co_<?=$row['co_no']?>_edit_box" class="my-comment-box edit-box"> <!--댓글 수정하기 컨테이너-->
            <form id="co_<?=$row['co_no']?>_edit" class="edit-comment" action="" method="">
                <!--댓글 수정하기는 editComment라는 js 함수로 이루어짐-->
                <!--editcomment 함수는 ajax로 update_comment.php 파일 사용-->
                <h4>댓글 수정</h4>
                <hr/>
                <input type="hidden" name="comment-number" value="<?=$row['co_no']?>"> <!--댓글 고유번호-->
                <input type="hidden" name="email" value="<?=$email?>"> <!--현재 로그인 한 유저 이메일-->
                <input type="hidden" name="name" value="<?=$user_name?>"> <!--현재 로그인 한 유저 이름-->
                <input type="hidden" name="bno" value="<?=$bNo?>"> <!--댓글이 달리는 게시글 번호-->
                <div class="form-group">
                    <textarea class="form-control" name="coContent" id="coContent<?=$row['co_no']?>" rows="5" maxlength="200" required style="resize: none;"></textarea>
                </div>
            </form>
            <button class="btn btn-primary" onclick="editComment(<?=$row['co_no']?>)">수정하기</button>
            <button class="btn btn-light" onclick="cancelEdit(<?=$row['co_no']?>)">취소하기</button>
        </div>
        <div id="co_<?=$row['co_no']?>_reply_box" class="my-comment-box reply-box" style="padding-left: 75px"> <!--답글 쓰기 컨테이너-->
            <form id="co_<?=$row['co_no']?>_edit" class="edit-comment" action="" method="">
                <!--댓글 수정하기는 writeReply라는 js 함수로 이루어짐-->
                <!--writeReply 함수는 ajax로 reply_update.php 파일 사용-->
                <h4>답글 작성</h4>
                <hr/>
                <input type="hidden" name="comment-number" value="<?=$row['co_no']?>">
                <input type="hidden" name="email" value="<?=$email?>">
                <input type="hidden" name="name" value="<?=$user_name?>">
                <input type="hidden" name="bno" value="<?=$bNo?>">
                <div class="form-group">
                    <textarea class="form-control" name="reContent" id="reContent<?=$row['co_no']?>" rows="5" maxlength="200" required style="resize: none;"></textarea>
                </div>
            </form>
            <button class="btn btn-primary" onclick="writeReply(<?=$row['co_no']?>)">답글쓰기</button>
            <button class="btn btn-light" onclick="hideReply(<?=$row['co_no']?>)">취소하기</button>
        </div>
<?php
//대댓글만 select 해오는 쿼리문
//고유번호와 순서번호가 다른 대댓글만 선택
$sql2 = "SELECT * FROM comment_free WHERE co_no != co_order and co_order=" . $row['co_no'];
$result2 = $db->query($sql2);

//내부 while문
//댓글에 달린 대댓글의 개수 만큼 반복
while($row2 = $result2->fetch_assoc()) {
?>
            <div id="co_<?=$row2['co_no']?>" class="my-comment-box" style="padding-left: 75px">
                <h4 style="font-weight: bold;"><?=$row2['co_name']?></h4>
                <h4><?=nl2br($row2['co_content'])?></h4>
                <div class="commentBtn">
                    <a onclick="showEdit(<?=$row2['co_no']?>)">수정</a>
                    <a onclick="deleteComment(<?=$row2['co_no']?>)">삭제</a>
                </div>
            </div>
            <div id="co_<?=$row2['co_no']?>_edit_box" class="my-comment-box edit-box" style="padding-left: 75px">
                <form id="co_<?=$row2['co_no']?>_edit" class="edit-comment" action="" method="">
                    <h4>답글 수정</h4>
                    <hr/>
                    <input type="hidden" name="type" value="edit">
                    <input type="hidden" name="comment-number" value="<?=$row2['co_no']?>">
                    <input type="hidden" name="email" value="<?=$email?>">
                    <input type="hidden" name="name" value="<?=$user_name?>">
                    <input type="hidden" name="bno" value="<?=$bNo?>">
                    <div class="form-group">
                        <textarea class="form-control" name="coContent" id="coContent<?=$row2['co_no']?>" rows="5" maxlength="200" required style="resize: none;"></textarea>
                    </div>
                </form>
                <button class="btn btn-primary" onclick="editComment(<?=$row2['co_no']?>, '<?=$row2['co_content']?>')">수정하기</button>
                <button class="btn btn-light" onclick="cancelEdit(<?=$row2['co_no']?>)">취소하기</button>
            </div>
            <?php
        }
    }
?>

<script>
    //댓글 수정하는 폼 페이지 모두 숨기기
    $(".edit-box").hide();
    $(".reply-box").hide();

    //span에서 현재 세션 이메일 데이터 읽어오기
    let email = $("#data").data("email");


    //댓글 수정하기 관련 함수
    // showEdit, cancelEdit, editComment

    //수정 박스 보여주기 함수
    //합수의 입력값 number는 댓글의 고유번호, content는 댓글의 내용
    function showEdit(number, content) {
        //로그인 유무를 체크하고 로그인이 되어있지 않으면
        //swal 사용하여 modal 표시
        if(email.length === 0) {
            Swal.fire(
                "로그인 필요",
                "댓글을 수정하려면 로그인이 필요합니다",
                "error"
            )
        }
        //로그인이 되어있는 경우
        else {
            //현재 로그인 된 사용자가 쓴 댓글이 맞는지 확인
            //check_comment_data.php
            $.post(
                "check_comment_data.php",
                {coNo : number, email : email},
                function (data) {
                    //현재 로그인 된 사용자가 쓴 댓글이 맞는 경우
                    if(data === "success"){
                        //댓글이 삭제되어있는지 확인
                        $.post(
                            "check_comment_deleted.php",
                            {coNo : number, email : email},
                            function (data) {
                                //삭제 된 경우
                                if(data) {
                                    Swal.fire(
                                        "수정 불가",
                                        "삭제된 댓글은 수정 할 수 없습니다",
                                        "error"
                                    )
                                }
                                //삭제가 되지 않는 경우
                                else {
                                    alert(content);
                                    $("#coContent" + number).val(content);
                                    $("#co_" + number).hide();
                                    $("#co_" + number + "_edit_box").show();
                                }
                            }
                        )

                    }
                    //현재 로그인 된 사용자가 쓴 댓글이 아닌 경우
                    else {
                        Swal.fire(
                            "수정 불가",
                            "본인이 쓰지 않은 댓글을 수정할 수 없습니다",
                            "error"
                        )
                    }
                }
            )
        }
    }
    //수정 박스 숨기기 함수
    //입력값은 댓글의 고유번호
    function cancelEdit(number) {
        $("#co_" + number).show();
        $("#co_" + number + "_edit_box").hide();
    }

    //댓글 수정 함수
    //위에 있던 showEdit 함수는 수정하기 컨테이너를 표시하는 반면
    //editComment 함수는 db에 connect 하여 실제로 값을 수정하는 함수임
    //입력값은 댓글의 고유번호
    function editComment(number) {
        let content = $("#coContent" + number).val();
        //textarea가 비어있는지 확인
        //비어있는 경우
        if (content.length === 0) {
            Swal.fire(
                "내용을 작성해주세요"
            )
        }
        //비어있지 않은 경우
        else {
            //댓글 내용 수정
            $.post(
                "update_comment.php",
                {coNo : number, content : content},
                function (data) {
                    if(data) {
                        Swal.fire(
                            "수정 성공"
                        ).then(function () {
                            location.reload();
                        });
                    }
                    else {
                        Swal.fire(
                            "수정 실패"
                        )
                    }
                }
            )
        }

    }

    //댓글 삭제 함수
    //입력값은 댓글의 고유번호
    function deleteComment(number) {
        //로그인 유무 확인
        if(email.length === 0) {
            Swal.fire(
                "로그인 필요",
                "댓글을 삭제하려면 로그인이 필요합니다",
                "error"
            )
        }
        else {
            //현재 로그인한 사용자가 쓴 댓글인지 확인
            $.post(
                "check_comment_data.php",
                {coNo : number, email : email},
                function (data) {
                    //현재 로그인한 사용자가 쓴 댓글이 맞는 경우
                    if(data === "success"){
                        Swal.fire(
                            "댓글 삭제",
                            "댓글을 삭제하시겠습니까?",
                            "question"
                        ).then(function () {
                            //db와 연결하여 댓글 삭제하는 함수
                            //delete_comment.php를 통해
                            //댓글의 내용을 "작성자가 삭제한 댓글입니다"로 수정하고
                            //댓글 삭제 유무를 저장하는 boolean값을 true로 바꿔줌
                           $.post(
                                "delete_comment.php",
                                {coNo : number},
                                function (data) {
                                    if(data) {
                                        Swal.fire(
                                            "댓글 삭제 성공",
                                            "댓글을 삭제했습니다",
                                            "success"
                                        ).then(function () {
                                            location.reload();
                                        })
                                    }
                                    else {
                                        Swal.fire(
                                            "댓글 삭제 실패",
                                            "이미 삭제된 댓글입니다",
                                            "error"
                                        ).then(function () {
                                            location.reload();
                                        })
                                    }
                                }
                            )
                        })
                    }
                    //현재 로그인한 사용자가 쓴 댓글이 아닌 경우
                    else {
                        Swal.fire(
                            "댓글 삭제 실패",
                            "본인이 쓴 댓글만 삭제 가능합니다",
                            "error"
                        )
                    }
                }
            )
        }
    }

    //답글(대댓글) 관련 함수
    //답글(대댓글) 박스 보여주기 함수
    function showReply(number) {
        //로그인 유무 확인
        if(email.length === 0) {
            Swal.fire(
                "로그인 필요",
                "답글을 달려면 로그인이 필요합니다",
                "error"
            )
        }
        //로그인 된 경우, 답글 쓰기 박스 표시
        else {
            $("#co_" + number + "_reply_box").show();
        }
    }
    //답글(대댓글) 박스 숨기기 함수
    function hideReply(number) {
        $("#co_" + number + "_reply_box").hide();
    }
    //답글(대댓글) 쓰기 함수
    //입력값은 답글(대댓글)이 달릴 댓글의 고유번호
    function writeReply(number) {
        let content = $("#reContent" + number).val();
        
        //답글(대댓글) 쓰기 textarea가 비었는지 확인
        if(content.length == 0) {
            Swal.fire(
                "내용을 작성하세요"
            )
        }
        //비어있지 않은 경우
        else {
            //$email = 현재 로그인된 사용자 이메일
            //$user_name = 현재 로그인된 사용자 이름
            //$bNo = 현재 게시글 번호
            //게시글 번호, 현재 로그인된 사용자 이메일, 현재 로그인된 사용자 이름은 
            //view.php파일에서 선언되어 있음
            let email = '<?=$email?>';
            let name = '<?=$user_name?>';
            let reContent = $("#reContent" + number).val();
            let bno = '<?=$bNo?>';
            let cno = number;
            $.post(
                "reply_update.php",
                {
                    email : email,
                    name : name,
                    reContent : reContent,
                    bno : bno,
                    cno : cno
                },
                function (data) {
                    if(data) {
                        Swal.fire(
                            "답글 작성 성공",
                            "답글을 작성했습니다",
                            "success"
                        ).then(function () {
                            location.reload();
                        });
                    }
                }
            )
        }
    }


</script>

