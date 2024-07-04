<?php
session_start();


// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 데이터베이스 연결
$conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// 사용자 정보 가져오기
$stmt = $conn->prepare("SELECT ID, Name, Gender, Age, Allergies, Conditions FROM article WHERE ID = ?");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>프로필 수정</title>
    <style>
        
        body { background:#FCFDFE; 
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal; }
        h2 {
            text-align: center;
            font-weight: 100;
            font-size: 40px;
            cursor:default;}
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
        input[type="submit"]:hover { background-color: #45a049; }
        
        .back{
            position:relative;
            text-align:center;
            top: 20px;
            left:-160px;
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
    <div class="back"><a href="profile.php">< 뒤로가기</a></div>
    <h2>프로필 수정</h2>
    <form action="update_profile.php" method="post">
        아이디 <input type="text" name="ID" value="<?php echo htmlspecialchars($user['ID']); ?>" readonly><br>
        이름 <input type="text" name="Name" value="<?php echo htmlspecialchars($user['Name']); ?>" required><br>
        성별 <input type="text" name="Gender" value="<?php echo htmlspecialchars($user['Gender']); ?>" required><br>
        나이 <input type="number" name="Age" value="<?php echo htmlspecialchars($user['Age']); ?>" required><br>
        알레르기 <input type="text" name="Allergies" value="<?php echo htmlspecialchars($user['Allergies']); ?>"><br>
        보유질환 <input type="text" name="Conditions" value="<?php echo htmlspecialchars($user['Conditions']); ?>"><br>
        현재 비밀번호 <input type="password" name="current_password"><br>
        새 비밀번호 <input type="password" name="new_password"><br>
        새 비밀번호 확인 <input type="password" name="confirm_password"><br>
        <input type="submit" value="수정">
    </form>
    <?php
    if(isset($_GET['error'])) {
        $error = $_GET['error'];
        echo "<p style='color: red;'>$error</p>";
    }
    if(isset($_GET['success'])) {
        $success = $_GET['success'];
        echo "<p style='color: green;'>$success</p>";
    }
    ?>
</body>
</html>