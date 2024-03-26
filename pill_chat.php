<!DOCTYPE html>
<html lang="ko">

<head>
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
</head>

<body>
    <div class="container">
        <div class="card mt-5">
            <form onsubmit="return false;">
                <div class="card-header" style="padding-top:12px;">
                    <h1 style="color:#1263c2"><b>집구석 약사</b></span> </h1>

                    <div class="form-floating">

                    </div>
                    

                </div>
                <div class="card-body">
                    <div class="media" id="form">
                        <div class="bot-inbox inbox border rounded p-2 mb-2" style="color:#1263c2"><b>PILL ADVISOR</b>
                            <div class="msg-header">
                                <p class="mb-0">어디가 아프신가요?</p>
                            </div>
                        </div>
                    </div>
                    <div class="media" id="typing" style="display:none;">
                        <div class="bot-inbox inbox border rounded p-2 mb-2" style="color:#1263c2"><b>입력중입니다...</b>
                        </div>
                    </div>

                    <div class="form-floating mt-3">
                        <textarea class="form-control" id="prompt" name="prompt" style="height: 100px"></textarea>
                        <label for="prompt">아픈 곳과 증상을 입력하세요.</label>
                    </div>

                    <!--
            <div class="form-floating mt-3">
                <input type="text" class="form-control" id="input1" name="input1" placeholder="인풋1을 입력하세요.">
                <label for="input1">인풋1</label>
            </div>
            <div class="form-floating mt-3">
                <input type="text" class="form-control" id="input2" name="input2" placeholder="인풋2를 입력하세요.">
                <label for="input2">인풋2</label>
            </div>
            <div class="form-floating mt-3">
                <input type="text" class="form-control" id="input3" name="input3" placeholder="인풋3을 입력하세요.">
                <label for="input3">인풋3</label>
            </div>
            !-->
                    <div class="form-floating mt-3">
                        <input type="hidden" id="old_prompt" name="old_prompt" value="">
                        <input type="hidden" id="old_result" name="old_result" value="">
                        <button type="submit" id="send-btn" class="btn btn-primary mb-2 mt-2"
                            style="width:100%">입력하기</button>
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

                /*
                $input1 = document.getElementById('input1').value;
                $input2 = document.getElementById('input2').value;
                $input3 = document.getElementById('input3').value;
                $prompt = "인풋1:" + $input1 + "\n" + "인풋2:" + $input2 + "\n" + "인풋3:" + $input3;
                */

                $prompt = document.getElementById('prompt').value; //인풋 열면 이거를 지운다
                $old_prompt = $("#old_prompt").val();
                $old_result = $("#old_result").val();

                $("#prompt").val("");

                target.disabled = true;
                setTimeout(function () { target2.style.display = 'block'; }, 1000);

                $msg = '<div class="user-inbox inbox border rounded p-2 mb-2"><b>Owner</b><div class="msg-header"><p class="mb-0">' + $prompt + '</p></div></div>';
                $("#form").append($msg);

                $.ajax({
                    url: 'ai.php', //이거를 AI_FIND.PHP로 나중에 수정으로 하면 데이터베이스에 연결이 된다
                    type: 'POST',
                    data: 'text=' + $prompt + '/////' + $old_prompt + '/////' + $old_result,
                    success: function (result) {

                        const target = document.getElementById('send-btn');
                        target.disabled = false;
                        const target2 = document.getElementById('typing');
                        target2.style.display = 'none';


                        $("#old_prompt").val($prompt);
                        $("#old_result").val(result);

                        $replay = '<div class="bot-inbox inbox border rounded p-2 mb-2" style="color:#1263c2"><b>방구석 약사</b><div class="msg-header"><p class="mb-0">' + result + '</p></div></div>';
                        $("#form").append($replay);
                        target2.style.display = 'none';

                    }
                });
            });
        });
    </script>
</body>

</html>
