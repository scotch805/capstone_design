<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>홈페이지</title>
    <style>
        /* CSS로 디자인 요소 추가 */
        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
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
    <div class="container">
        <h1>방구석 약상자</h1>

        <div class="big-box">
            <a href="pill_chat.php"><div class="small-box">챗봇</div></a>
            <a href="index.php"><div class="small-box">약 인식</div></a>
            <a href="pill_info.php"><div class="small-box">약 정보</div></a>
            <a href="page3.php"><div class="small-box">다이어리</div></a>
        </div>
    </div>
</body>
</html>