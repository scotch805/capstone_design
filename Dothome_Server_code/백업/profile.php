<?php
session_start();

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
     header("Location: index.php");
     exit();
}

$user_id = $_SESSION['user_id'];

// 데이터베이스 연결
$conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


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
        

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    
    <meta charset="UTF-8">
    <title>프로필</title>
    <style>
        body { background:#FCFDFE; 
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;}
        .profile-container { width: 700px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px;
            box-shadow: 0.5px 1px 3px rgba(0,0,0,0.06)}
        .profile-info { margin-bottom: 20px; }
        .profile-info div { margin-bottom: 10px; }
        .btn-container{
            text-align:right;
        }
        .button { display: inline-block; text-align:center; margin: 0 10px; background-color: #4CAF50; border-radius: 10px;
        background:none;}
        a {
            color:#000000;
            text-decoration: none; 
            font-weight: 500;
            font-size: 20px;
        }
        .welcome_message {
            position:relative;
            left:-240px;
            text-align:center;
            font-weight:300;
            font-size: 25px;
        }
        .info_box{
            width: 90%;
            margin: 0 auto;
            text-align: center;
            height:150px;
        }
        .info_box .title{
            margin-top:80px;
            margin-left: 0%;
            cursor:pointer;
        }
        .title_name{
            margin:10px;
            font-weight: 300;
            font-size: 45px;
        }
        .subtitle{
            font-weight: 200;
            color:#7F7F7F;
            font-size:17px;
        }
        
    </style>
</head>
<body>
<div class="info_box">
        <div class="title" onclick=window.open("main.php","_self")>
            <p class="title_name">방구석 약상자</p>
        </div>
        <p class="subtitle">마이페이지</p>
</div>
        <?php if(isset($_SESSION['user_id'])): ?>
                <p class="welcome_message">환영합니다. <?php echo "<b> $user_id </b>" ?>님</p><?php endif; ?>
    <div class="profile-container">
        <div class="btn-container">
        <a href="edit_profile.php" class="button">수정</a></div>
        <h2>프로필</h2>
        <div class="profile-info">
            <div>아이디 | <?php echo htmlspecialchars($user['ID']); ?></div>
            <div>이름 | <?php echo htmlspecialchars($user['Name']); ?></div>
            <div>성별 | <?php echo htmlspecialchars($user['Gender']); ?></div>
            <div>나이 | <?php echo htmlspecialchars($user['Age']); ?></div>
            <div>알레르기 | <?php echo htmlspecialchars($user['Allergies']); ?></div>
            <div>보유질환 | <?php echo htmlspecialchars($user['Conditions']); ?></div>
        </div>
    </div>
</body>
</html>