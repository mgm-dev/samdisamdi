<?php
//본 파일은 회원 가입 프로세스 파일임
//본 파일은 db에 새로운 유저 정보를 추가하고
//새롭게 추가된 유저의 이메일에 인증 이메일을 전송함

//계정 활성화에 사용될 해쉬 값 생성하는 함수
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$activation_hash = generateRandomString(32);

$email=$_POST['email'];
$name=addslashes($_POST['name']);
$password=$_POST['password'];
$password_check=$_POST['password_check'];
$hash = password_hash($password, PASSWORD_DEFAULT);

//회원가입 조건 서버사이드에서 한번더 체크 실시

//비밀번호와 비밀번호 확인이 똑같은지 확인
if ($password != $password_check) {
    echo "비밀번호와 비밀번호 확인이 서로 다름";
    exit();
}
//form에 빈칸 있는지 확인
if($email ==NULL || $name == NULL || $password == NULL || $password_check == NULL) {
    echo "빈칸을 다 채워주세요";
    exit();
}

//위 사항들을 다 거치고 확인이 된 경우 db에 인서트 작업
$db = mysqli_connect("localhost", "mysql", "EnterPasswordHere", "user_info");
$db->set_charset('utf8');
$sql = "INSERT INTO user(email, password, user_name, hash) VALUES('$email', '$hash', '$name', '$activation_hash')";
$result = mysqli_query($db, $sql);

//인서트 실패 시
if($result === false) {
    echo mysqli_error($db);
}
//인서트 성공 시
else {
    $primaryKey = mysqli_insert_id($db);
    setcookie('user_email', $email, time() + (10 * 365 * 24 * 60 * 60))
    ?>
    <script>
        parent.postMessage("signUpSuccess", "*")
    </script>
<?php
}

mysqli_close($db);

//계정 활성화 링크가 포함된 email 보내기

//smtp에 접속하여 메일을 전송하는 php 클래스
//오브젝트를 생성할 때 값을 지정하지 않으면
//발송자는 tommin231@naver.com
//smtp 서버는 smtp.naver.com
include "Sendmail.php";

$testObject = new Sendmail($config);

$to= $email;
$from="SamdiSamdi";
$subject="계정 활성화 링크.";
$body="https://www.samdisamdi.com/activate_account.php?hash={$activation_hash}&pk={$primaryKey}";

/* 메일 보내기 */
$testObject->send_mail($to, $from, $subject, $body);

?>