<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <title>회원가입</title>
    <style>
        h2 {
            text-align: center;
            font-weight: 100;
            font-size: 40px;
            cursor:default;}
        body { background:#FCFDFE; 
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal; }
        form { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        input[type="text"], input[type="number"], input[type="password"] 
        { width: 100%; padding: 8px; margin: 6px 0; border:1px solid #F2F2F2; border-radius: 5px; box-sizing: border-box;
        font-weight:100;}
        input[type="submit"] { width: 100%; padding: 10px; background-color: #4CAF50; 
            background: linear-gradient(210deg, #ADF47C, #379947);
            color:white;
            border:none;
            border-radius:20px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
            cursor:pointer; }
            
        .back{
            position:relative;
            text-align:center;
            top: 20px;
            left:-170px;
            font-weight:600;
            font-size: 20px;
        }
        .back > a {
            color:#000000;
            text-decoration: none; 
        }
    </style>
</head>
<body>
    <div class="back"><a href="index.php">< 뒤로가기</a></div>
    <h2>회원가입</h2>
    <form action="register_process.php" method="post">
        아이디 <input type="text" name="ID" required><br>
        비밀번호 <input type="password" name="Password" required><br>
        이름 <input type="text" name="Name" required><br>
        성별 <input type="text" name="Gender" required><br>
        나이 <input type="number" name="Age" required><br>
        알레르기 <input type="text" name="Allergies"><br>
        보유질환 <input type="text" name="Conditions"><br>
        <input type="submit" value="가입">
    </form>
    <?php
    if(isset($_GET['error'])) {
        $error = $_GET['error'];
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
</body>
</html>
