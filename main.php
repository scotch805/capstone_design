<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>홈페이지</title>
    <style>
        /* CSS로 디자인 요소 추가 */
        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
        .info_box{
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
        .info_box .title{
            margin-left: 0%;
            display: inline-block;
        }
        .info_box .login {
            display: inline-block;
            position: relative;
            left: 40%;
        }
        .title_name{
            font-size: 28px;
            font-weight: bold;
        }
        .big-box {
            background-color: lightgray;
            padding: 20px;
            margin-top: 50px;
        }
        .small-box {
            display: inline-block;
            width: 100px;
            height: 100px;
            background-color: lightblue;
            margin: 0 10px;
            cursor: pointer; /* 클릭 가능한 커서로 변경 */
        }
    </style>
</head>
<body>
<div class="info_box">
        <div class="title" onclick=window.open("main.php","_self")>
            <p class="title_name">방구석 약상자</p>
        </div>

        <div class="login" onclick=window.open("/","_self")>
            <span class="material-symbols-outlined">account_circle</span>
        </div>
    </div>

    <div class="container">
    

        <div class="big-box">
            <a href="pill_chat.php"><div class="small-box">챗봇</div></a>
            <a href="index.php"><div class="small-box">약 인식</div></a>
            <a href="pill_info.php"><div class="small-box">약 정보</div></a>
            <a href="calendar.php"><div class="small-box">다이어리</div></a>
        </div>
    </div>
</body>
</html>