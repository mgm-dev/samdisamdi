<?php
    require_once ("dbconfig.php");

    //post 방식으로 db에 저장될 값 받아오고 db에 새로운 row 추가
    $bName = addslashes($_POST[bName]);
    $bEmail = $_POST[bEmail];
    $bTitle = addslashes($_POST[bTitle]);
    $bContent = addslashes($_POST[bContent]);
    $date = date('Y-m-d H:i:s');


    $sql = "INSERT INTO board_file (b_no, b_title, b_content, b_date, b_hit, b_name, b_email) 
        VALUES (null, '$bTitle', '$bContent', '$date', 0, '$bName', '$bEmail')";
    $result = $db->query($sql);


    //post 방식으로 받아온 값들을 합쳐서 파일을 저장할 폴더명을 만들고
    //uploads 폴더에 새로운 파일 만들어서 해당 폴더로 이동
    $base_dir = '/var/www/html/uploads';
    $new_dir = $bName . $bEmail . date("YmdHis", strtotime($date));

    chdir($base_dir);
    mkdir($new_dir);
    chdir($new_dir);

//    move_uploaded_file($_FILES['stl-upload']['tmp_name'],"stl0" . "." .
//        pathinfo($_FILES['stl-upload']['name'], PATHINFO_EXTENSION));

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
        $msg = "글 등록 성공";
        $bNo = $db->insert_id;
        //글 등록 성공시 해당 글로 이동함
        $replaceURL = './view.php?bno=' . $bNo;
    } else {
        $msg = "글 등록 실패";
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