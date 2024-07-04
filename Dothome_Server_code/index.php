<!DOCTYPE html>
<html>
<head>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>로그인</title>
    <style>
        body { background:#FCFDFE; font-family: "Noto Sans KR", sans-serif;font-optical-sizing: auto;font-style: normal;}
        h2 {text-align: center;font-weight: 100;font-size: 40px; cursor:default;}
        .info_box{width: 90%;margin: 0 auto; text-align: center;height:150px;}
        .info_box .title{margin-top:50px;margin-left: 0%;cursor:pointer;}
        .info_box .login { position: relative; text-align: right;cursor:pointer;}
        .title_name{margin:10px; font-weight: 300;font-size: 45px;}
        .login-container{ margin: 0 auto;height:350px;
        }
        .loginform{margin: 20px;position:relative;display:flex;
            justify-content:space-between;flex-direction:column;}
        .login_input  {
            position:relative;margin:0 auto;
            width:300px;height:80px; display: flex;
            justify-content:space-between;flex-direction:column;
            align-items:center;
        }
        .login_input > input {
            width:250px;height:30px;
            border-radius:10px;border: 2px solid #F2F2F2;
            padding-top:2px;padding-right:2px;padding-bottom:2px;
            text-indent:40px;
            font-weight: 400;font-size: 15px;
        }
        .login_input > input::placeholder {font-weight: 100;font-size: 15px;}
        .logintxt {
            position:absolute;
            display: flex;
            align-items:center;
            justify-content:space-between;flex-direction:column;
            width:20px;height:64px;font-weight: 400;font-size: 15px;
            top:0%;left: 50%;margin-top:6px;margin-left:-120px;
        }
        .login_image{
            display:flex; justify-content:center; cursor:pointer;margin:15px;;
        }
        .signup-box{
            margin-top:10px;display:flex;justify-content:center;align-items:center;font-weight: 100;font-size: 20px;}
        .signuptext{ margin :10px;}
        .signup > a { font-weight: 400;font-size: 20px;color:#595959;}
        .user-info   {
            height:30px;
        }
        .errormsg{
            top:50px;
            text-align:center;
            background:#FCFDFE;
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
    </style>
</head>
<body>
<div class="info_box">
    
    <div class="user-info">
        <div class="login" onclick=window.open("/","_self")>
            <span class="material-symbols-outlined">account_circle</span>
        </div>
    </div>
        <div class="title" onclick=window.open("main.php","_self")>
            <p class="title_name">방구석 약상자</p>
        </div>
</div>
    <h2>로그인</h2>
    <div class="login-container">
        <div class="loginform">
                <form action="login.php" method="post">
                <div class="login_input">
                    <input type="text"  placeholder="아이디" id="user-id" name="ID" required>
                    <input type="password" placeholder="비밀번호" name="Password" id="user-pw" required>
                </div>
                <div class="logintxt"><div>ID</div><div>PW</div></div>

    <?php
    session_start();
        if (isset($_SESSION['error'])) {    
        $error = $_SESSION['error'];
        echo "<p class='errormsg' style='color: red;'>$error</p>";
        unset($_SESSION['error']); // 오류 메시지 세션 변수 삭제
    }
    
        ?>

                    <div class="login_image">
                        <input type="image" src="img/loginb.png" alt="Submit Form" style="width:150px;height:40px;" />
                    </div>
                </form>
                
        </div>
        <div class = "signup-box">
            <div class="signuptext"><p>계정이 없으신가요?</p></div>
            <div class="signup"><a href="register.php">회원가입</a>  </div>
        </div>
    </div>
</body>
</html>