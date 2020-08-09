<?php
$base_dir = '/var/www/html/uploads';
$base_dir2 = 'uploads/test2/';
$test_dir = 'test2';

chdir($base_dir);
mkdir($test_dir);
chdir($test_dir);

$username = posix_getpwuid(posix_geteuid())['name'];
echo $username;

echo getcwd(), '<br/>';
echo "confirm file information <br />";

$uploadfile = $_FILES['upload']['name'];

echo $base_dir . '/' . $test_dir . '/' . $uploadfile;

echo count($_FILES['upload']['name']);

if(move_uploaded_file($_FILES['upload']['tmp_name'],$uploadfile)){
    echo "파일이 업로드 되었습니다.<br />";
    echo "<img src = $base_dir2 . $uploadfile> <p>";
    echo "1. file name : {$_FILES['upload']['name']}<br />";
    echo "2. file type : {$_FILES['upload']['type']}<br />";
    echo "3. file size : {$_FILES['upload']['size']} byte <br />";
    echo "4. temporary file size : {$_FILES['upload']['size']}<br />";
} else {
    echo "파일 업로드 실패 !! 다시 시도해주세요.<br />";
}
?>

<img src= <?=$base_dir2 . $uploadfile?> alt="">


<div id="stl_cont" style="width:500px;height:500px;margin:0 auto;"></div>

<script src="./stl_plugin/stl_viewer.min.js"></script>
<script>
    var stl_viewer=new StlViewer
    (
        document.getElementById("stl_cont"),
        {
            cameray : -40,
            models:
                [
                    {filename:"./uploads/test2/<?=$uploadfile?>"}
                ]
        }
    );

</script>