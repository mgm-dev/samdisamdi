function openAlert() {
    Swal.fire(
        '로그인 실패',
        '아이디와 비밀번호를 확인 해주세요',
        'error'
    )
}

function success() {
    location.reload();
}

function signUpSuccess() {
    Swal.fire(
        '회원가입 성공',
        '회원가입 하신 이메일로 인증 메일이 전송되었습니다',
        'success'
    ).then((result) => {
        if (result.value) {
            location.replace('/mypage.php');
        }
    })
}

window.addEventListener("message", function(event) {
    if(event.data === "openAlert") {
        openAlert();
    }
    if(event.data === "success") {
        success();
    }
    if(event.data === "signUpSuccess") {
        signUpSuccess();
    }
});