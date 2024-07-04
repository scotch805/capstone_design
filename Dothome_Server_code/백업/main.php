<?php
// 세션 시작
session_start();


// 만약 세션에 사용자 ID가 없으면 로그인 페이지로 리다이렉트
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 사용자 ID 가져오기
$user_id = $_SESSION['user_id'];

// 만약 로그아웃 버튼이 클릭되었으면 세션 종료하여 로그아웃 처리
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>홈페이지</title>
    <style>
        /* CSS로 디자인 요소 추가 */
        
        body {
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            background:#FCFDFE;
        }
        
        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
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
            font-weight: 300;
        }
        .big-box {
            display:flex;
            justify-content:center;
            background-color: none;
            padding: 20px;
            margin-top: 100px;
        }
        .small-box {
            display: flex;

            width: 100px;
            height: 140px;
            margin: 0 40px;
            cursor: pointer; /* 클릭 가능한 커서로 변경 */
            
            background-repeat:no-repeat;
            background-position: top;
            background-size : contain;
            justify-content:center;
            align-items:flex-end;

            font-weight: 400;
            font-size: 20px;
        }
        .big-box > a {
            text-decoration:none;
            color:#595959;
        }
        .user-info   {
            height:30px;
            display: flex;
            align-items: center;
            justify-content:flex-end;
            margin:5px;
            font-weight: 400;
            color:#595959;
            font-size: 15px;
            
        }
        .welcome_message{
            text-align:right;
            margin-right: 10px;
        }
        .user-info .profile-button {
            margin:5px;
            font-weight: 400;
            color:#595959;
            font-size: 15px;

            border:none;
            background:none;
            cursor:pointer;
        }
        .user-info input[type="submit"] {
            
            margin:5px;
            font-weight:400;
            color:#595959;
            font-size: 15px;

            border:none;
            background:none;
            text-decoration:underLine;
            cursor:pointer;
        }
        .subtitle{
            font-weight: 100;
            color:#7F7F7F;
            font-size:17px;
        }
        .main_bar{
            display: inline-block;
            width:500px;
            height:7px;
            background-color:#ADF47C;
        }
        .chatbot {
            background-image:url(img/chat_ico.png);
        }
        .diary{
            background-image:url(img/diary_ico.png);
        }
        .pillinfo {
            background-image:url(img/info_ico.png);
        }
        .ocr {
            background-image:url(img/ocr_ico.png);
        }
    </style>
</head>
<body>
    <div class="info_box">
        <div class="user-info">
            <?php if(isset($_SESSION['user_id'])): ?>
                <p class="welcome_message">환영합니다, <?php echo "<b> $user_id </b>" ?>님</p>
                    <button class="profile-button" onclick="window.open('profile.php', '_self')">마이페이지</button>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="submit" name="logout" value="로그아웃">
                    </form>
                    <div class="login" onclick="window.open('/', '_self')">
                        <span class="material-symbols-outlined">account_circle</span>
                    </div>
            <?php endif; ?>
        </div>
        <div class="title" onclick=window.open("main.php","_self")>
            <p class="title_name">방구석 약상자</p>
        </div>
        <p class="subtitle">빠르고 간편한 상비약 관리</p>
        <div class="main_bar"></div>
    </div>

    <div class="container">
        <div class="big-box">
            <a href="chatbot/pill_chat.php"><div class="small-box chatbot" id="pill_chat">챗봇</div></a>
            <a href="ocr/pill_ocr.php"><div class="small-box ocr" id="pill_ocr">약 인식</div></a>
            <a href="pill_info.php"><div class="small-box pillinfo" id="pill_info">약 정보</div></a>
            <a href="calendar/calendar.php"><div class="small-box diary" id="calendar">다이어리</div></a>
        </div>
    </div>
</body>
</html>