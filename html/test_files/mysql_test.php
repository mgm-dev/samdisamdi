<?php
$conn = mysqli_connect("localhost", "mysql", "EnterPasswordHere", "db");

$sql1 = "select post_id from board_like where user_email = 'tommin231@naver.com'";
$result1 = mysqli_query($conn, $sql1);

$post_id_array = array();
while($row = mysqli_fetch_assoc($result1)) {
    $post_id_array[] = $row['post_id'];
}

$post_id_string = implode(', ', $post_id_array);

echo var_dump($post_id_array);
echo var_dump($post_id_string);


$sql2 = "select * from board_file where b_no in ($post_id_string)";
$result2 = mysqli_query($conn, $sql2);
$nums = mysqli_num_rows($result2);

echo $nums;