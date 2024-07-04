<!DOCTYPE html>
<html>
<head>
    <title>로그인</title>
</head>
<body>
    <h2>로그인</h2>
    <form action="login.php" method="post">
        아이디: <input type="text" name="ID" required><br>
        비밀번호: <input type="password" name="Password" required><br>
        <input type="submit" value="로그인">
    </form>
    <p>계정이 없으신가요? <a href="register.php">회원가입</a></p>
</body>
</html>