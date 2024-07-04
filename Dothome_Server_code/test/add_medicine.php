<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$medicine_symptoms = [
    "후시딘 연고" => "찰과상, 외상(상처)",
    "노보민 시럽" => "멀미",
    "위평원" => "소화불량",
    "속시나제" => "소화불량",
    "장편환" => "설사",
    "이부로엔" => "염증완화, 통증완화",
    "엑쎈코" => "근육통, 염증완화",
    "화이투벤 큐 코프" => "기침, 가래",
    "맥쎈" => "감기, 발열",
    "염산메클리진정" => "알레르기",
    "지르텍" => "알레르기",
    "로라딘" => "알레르기",
    "알마겔" => "속쓰림",
    "훼스탈 플러스" => "소화불량",
    "베아제" => "소화불량",
    "소보민시럽" => "기침, 가래",
    "펜잘큐" => "두통, 생리통",
    "콜대원" => "기침, 가래, 감기",
    "마데카솔" => "찰과상, 외상(상처)",
    "알벤다졸" => "기생충 감염",
    "이지엔6프로" => "두통, 생리통",
    "미리코프파워" => "기침, 가래",
    "게보린정" => "두통, 생리통",
    "노루모" => "근육통, 통증완화",
    "콜대원" => "기침, 가래, 감기",
    "케어번크림" => "화상",
    "파세몰비타" => "감기, 발열",
    "노텍" => "소화불량",
    "아즈렌" => "화상",
    "세노바퀵" => "설사",
    "겔포스" => "속쓰림",
    "바이스탑" => "설사",
    "화이투벤큐노즈" => "콧물, 기침",
    "그날엔 코프 플러스" => "감기, 기침",
    "타이레놀" => "두통, 발열, 생리통",
    "포타겔" => "속쓰림",
    "로프민" => "설사"
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    if (array_key_exists($name, $medicine_symptoms)) {
        $symptoms = $medicine_symptoms[$name];
    } else {
        $symptoms = "알 수 없음";
    }

    $conn = new mysqli("localhost", "sw0test", "q1w2e3r4!", "sw0test");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO medicines (name, symptoms, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $symptoms, $user_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>약품 추가</title>
</head>
<body>
    <form method="POST" action="add_medicine.php">
        <label for="name">약품 이름:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">추가</button>
    </form>
</body>
</html>
