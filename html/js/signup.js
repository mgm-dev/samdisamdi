//유효한 이메일인지 검사
function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

$(function(){
    //경구 문구를 초기에는 보여주지 않게 숨기기
    $("#alert-used").hide();
    $("#alert-taken").hide();
    $("#alert-success").hide();
    $("#alert-danger").hide();
    $("#alert-not-email").hide();
    //form의 submit 비활성화
    $("#submit").attr("disabled", "disabled");

    //form submit 활성화 충족 요건 확인을 위한 변수들
    //아래 3개의 변수가 모두 true가 되야지 keyup event에서 submit 활성화
    let emailCheck = false;
    let nameCheck = false;
    let blankCheck = false;
    let passwordCheck = false;

    $("#email").keyup(function () {
        let email = $("#email").val();

        //유효한 이메일이 아니고 이메일란에 공란이 아닌경우에
        if(isEmail(email)) {
            $("#alert-not-email").hide();

            //post 방식으로 email_chek.php에 페이지에 입력된  email을 넘김
            $.post(
                "email_check.php",
                { email : email },
                function (data) {
                    if(data){ //
                        $("#alert-used").show();
                        emailCheck = false;
                    }
                    else {
                        $("#alert-used").hide();
                        emailCheck = true;
                    }
                }
            )
        }
        else {
            $("#alert-not-email").show();
            $("#alert-used").hide();
            emailCheck = false;
        }

        if(email == "") {
            $("#alert-not-email").hide();
            $("#alert-used").hide();
            emailCheck = false;
        }
    })

    $("#name").keyup(function () {
        let name = $("#name").val();

        //post 방식으로 name_chek.php에 페이지에 입력된  name을 넘김
        $.post(
            "name_check.php",
            { name : name },
            function (data) {
                if(data){ //
                    $("#alert-taken").show();
                    nameCheck = false;
                }
                else {
                    $("#alert-taken").hide();
                    nameCheck = true;
                }
            }
        )
    })

    $("input").keyup(function(){
        var email = $("#email").val();
        var name = $("#name").val();
        var pwd1 = $("#password").val();
        var pwd2 = $("#password_check").val();

        if(pwd1 != "" || pwd2 != "") {
            if(pwd1 == pwd2) {
                $("#alert-success").show();
                $("#alert-danger").hide();
                // $("#submit").removeAttr("disabled");
                passwordCheck = true;
            }
            else {
                $("#alert-success").hide();
                $("#alert-danger").show();
                // $("#submit").attr("disabled", "disabled");
                passwordCheck = false;
            }
        }

        if(email == "" || name == "" || pwd1 =="" || pwd2 =="") {
            // $("#submit").attr("disabled", "disabled");
            blankCheck = false;
        }
        else {
            // $("#submit").removeAttribute("disabled");
            blankCheck = true;
        }

        if(pwd1 == "" || pwd2 == "") {
            $("#alert-success").hide();
            $("#alert-danger").hide();
        }

        if(!emailCheck || !blankCheck || !passwordCheck || !nameCheck) {
            $("#submit").attr("disabled", "disabled");
        }
        else {
            $("#submit").removeAttr("disabled");
        }
    });
});