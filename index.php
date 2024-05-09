<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>로그인</title>
    <style>
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

    <h2>로그인</h2>
    <form action="login.php" method="post">
        아이디: <input type="text" name="ID" required><br>
        비밀번호: <input type="password" name="Password" required><br>
        <input type="submit" value="로그인">
    </form>
    <p>계정이 없으신가요? <a href="register.php">회원가입</a></p>
</body>
</html>