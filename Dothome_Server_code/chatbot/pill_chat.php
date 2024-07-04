<!DOCTYPE html>
<html lang="ko">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="favicon.ico" />
    <title>PILL ADVISOR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.1/css/bootstrap.min.css"
        integrity="sha512-B3clz06N8Jv1N/4ER3q4ee4+AVa8rrv/5Q5M5tz+R5S9t8XvJyA2+7nFt2QdC8dPwZlnwyF+I1tKb/nik18Ovg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <style>
        body {
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            background:#FCFDFE;
            font-style: normal;
        }
        .info_box{
            width: 90%;
            margin: 0 auto;
            text-align: center;
            height:150px;
        }
        .info_box .title{
            margin-top:50px;
            margin-left: 0%;
            cursor:pointer;
        }
        .info_box .login {
            position: relative;
            text-align: right;
            cursor:pointer;
        }
        .title_name{
            margin:10px;
            font-weight: 300;
            font-size: 45px;
        }
        .chatbtn {
            text-align:right;
        }
        .mt-5 {
            font-weight: 400;
            font-style: normal;
        }
        .mb-2 {
            font-weight: 600;
            font-size: 20px;
        }
        .mb-0 {
            font-weight: 400;
            font-size: 15px;
        }
        .card{
            border:1px solid #D9D9D9;
        }
        .mt-2{
            font-weight: 400;
            font-size: 15px;
        }
        .btn{
            background: linear-gradient(210deg, #ADF47C, #379947);
            border:none;
            border-radius:20px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
        }
        .btn:hover{
            background-color:#ADF47C;
            transition: 1s;
        }
        .btn:focus{
            background-color:#379947;
            transition: 1s;
        }
        .form-control {
            resize:none;
        }
        .card-header{
            background:#FCFDFE;
        }
        .user-inbox{
            text-align:right;
        }
        .inbox{
            border:none;
        }
    </style>
</head>

<body>
    <div class="info_box">
        <div class="login" onclick=window.open("/","_self")>
            <span class="material-symbols-outlined">account_circle</span>
        </div>
        <div class="title" onclick=window.open("../main.php","_self")>
            <p class="title_name">방구석 약상자</p>
        </div>
    </div>

    <div class="container">
        <div class="card mt-5">
            <form onsubmit="return false;">
                <div class="card-header" style="padding-top:12px;">
                    <h1 style="color:#003300"><b>집구석 약사</b></span> </h1>

                    <div class="form-floating">
                    </div>
                </div>
                <div class="card-body">
                    <div class="media" id="form">
                        <div class="bot-inbox inbox border rounded p-2 mb-2" style="color:#003300"><b>PILL ADVISOR</b>
                            <div class="msg-header">
                                <p class="mb-0">어디가 아프신가요?</p>
                            </div>
                        </div>
                    </div>
                    <div class="media" id="typing" style="display:none;">
                        <!-- <div class="bot-inbox inbox border rounded p-2 mb-2" style="color:#000000"><b>입력중입니다...</b>
                        </div> -->
                    </div>

                    <div class="form-floating mt-3">
                        <textarea class="form-control" id="prompt" name="prompt" style="height: 100px"></textarea>
                        <label for="prompt">아픈 곳과 증상을 입력하세요.</label>
                    </div>

                    <div class="form-floating mt-3">
                        <input type="hidden" id="old_prompt" name="old_prompt" value="">
                        <input type="hidden" id="old_result" name="old_result" value="">
                        <div class="chatbtn">
                            <button type="submit" id="send-btn" class="btn btn-primary mb-2 mt-2" style="width:20%">입력하기</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#send-btn").on("click", function () {
                const target = document.getElementById('send-btn');
                const target2 = document.getElementById('typing');

                $prompt = document.getElementById('prompt').value;
                $old_prompt = $("#old_prompt").val();
                $old_result = $("#old_result").val();

                $("#prompt").val("");

                target.disabled = true;
                setTimeout(function () { target2.style.display = 'block'; }, 1000);

                $msg = '<div class="user-inbox inbox border rounded p-2 mb-2"><b>Owner</b><div class="msg-header"><p class="mb-0">' + $prompt + '</p></div></div>';
                $("#form").append($msg);

                $.ajax({
                    url: 'ai.php',
                    type: 'POST',
                    data: { text: $prompt },
                    success: function (result) {
                        const target = document.getElementById('send-btn');
                        target.disabled = false;
                        const target2 = document.getElementById('typing');
                        target2.style.display = 'none';

                        $("#old_prompt").val($prompt);
                        $("#old_result").val(result);

                        $replay = '<div class="bot-inbox inbox border rounded p-2 mb-2" style=":color:#00ff00"><b>방구석 약사</b><div class="msg-header"><p class="mb-0">' + result + '</p></div></div>';
                        $("#form").append($replay);
                        target2.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>
