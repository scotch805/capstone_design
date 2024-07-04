<!DOCTYPE html>
<html>
<head>
    <title>회원가입</title>
</head>
<body>
    <h2>회원가입</h2>
    <form action="register_process.php" method="post">
        아이디: <input type="text" name="ID" required><br>
        비밀번호: <input type="password" name="Password" required><br>
        이름: <input type="text" name="Name" required><br>
        성별: <input type="text" name="Gender" required><br>
        나이: <input type="number" name="Age" required><br>
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
