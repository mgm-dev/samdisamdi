<?php
    require_once ("dbconfig.php");

    //post 방식으로 db에 저장될 값 받아오고 db에 해당 row 수정
    $bTitle = addslashes($_POST['bTitle']);
    $bContent = addslashes($_POST['bContent']);
    $bNo = $_POST['bno'];

    //게시글 제목, 내용 업데이트
    $sql = "UPDATE board_file SET b_title ='$bTitle', b_content ='$bContent' WHERE b_no ='$bNo'";
    $result = mysqli_query($db, $sql);

    //stl 이미지 파일 삭제를 위해서
    //$sqlSelect 쿼리로 결과 부터 디렉토리 얻어옴
    $sqlSelect = "select * from board_file where b_no = '$bNo'";
    $resultSelect = mysqli_query($db, $sqlSelect);
    $rowSelect = mysqli_fetch_array($resultSelect);

    mysqli_close($db);

    //파일이 저장 되어 있는 다이렉토리(폴더 이름)를 쿼리로 리턴된 배열에서 조합
    //다이렉토리 : uploads/유저이름/유저이메일/글작성시간
    $dir = "uploads/" .
        $rowSelect['b_name'] .
        $rowSelect['b_email'] .
        date("YmdHis", strtotime($rowSelect['b_date']));

    //glob 함수로 확장자별로 구분 된 파일 다이렉토리 배열 생성
    //$images = {uploads/유저1/이메일1/시간1/사진1, uploads/유저1/이메일1/시간1/사진2, ...}
    //$stls = {uploads/유저1/이메일1/시간1/stl1, uploads/유저1/이메일1/시간1/stl2, ...}
    if (glob($dir . "/*.{jpg,png}", GLOB_BRACE) != false) {
        $images = glob($dir . "/*.{jpg,png}", GLOB_BRACE);
    }
    if (glob($dir . "/*.stl") != false) {
        $stls = glob($dir . "/*.stl");
    }


    //사용자가 새로운 stl 파일을 업로드 했는지 체크
    $newStlNumber = count(array_filter($_FILES['stl-upload']['name']));

    //새로운 이미지 파일을 업로드 한 경우 기존 파일 삭제
    if($newStlNumber > 0) {
        foreach($stls as $value) {
            unlink($value);
        }
    }

    //사용자가 새로운 이미지 파일을 업로드 했는지 체크
    $newImageNumber = count(array_filter($_FILES['img-upload']['name']));

    //새로운 이미지 파일을 업로드 한 경우 기존 파일 삭제
    if($newImageNumber > 0) {
        foreach($images as $value) {
            unlink($value);
        }
    }

    //파일 재업로드를 위해서 디렉토리 이동
    chdir($dir);

    //stl 파일 다중 업로드, count로 배열 숫자 구하고 for문으로 처리
    $total = count($_FILES['stl-upload']['tmp_name']);
    for($i = 0; $i < $total; $i++) {
        move_uploaded_file($_FILES['stl-upload']['tmp_name'][$i], "stl" . $i . "." .
            pathinfo($_FILES['stl-upload']['name'][$i], PATHINFO_EXTENSION));
    }

    //이미지 파일 다중 업로드, count로 배열 숫자 구하고 for문으로 처리
    $total = count($_FILES['img-upload']['tmp_name']);
    for($i = 0; $i < $total; $i++) {
        move_uploaded_file($_FILES['img-upload']['tmp_name'][$i], "img" . $i . "." .
            pathinfo($_FILES['img-upload']['name'][$i], PATHINFO_EXTENSION));
    }

    if($result) { // query가 정상실행 되었다면,
        $msg = "글 수정 성공";
        //글 등록 성공시 해당 글로 이동함
        $replaceURL = './view.php?bno=' . $bNo;
    } else {
        $msg = "글 수정 실패";
    ?>
        <script>
            alert("<?php echo $msg?>");
            history.back();
        </script>
    <?php
        }
    ?>
<script>
    alert("<?php echo $msg?>");
    location.replace("<?php echo $replaceURL?>");
</script>