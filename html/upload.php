<?php
echo "file upload program<br />";
echo "select the file<br />";
?>
<form method="post" action="upload_process.php" enctype="multipart/form-data">
    <input type="file" name="upload" multiple multiple="multiple"><hr>
    <input type="submit" value="send">
</form>
