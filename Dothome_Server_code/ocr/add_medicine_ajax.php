<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

$medicine_symptoms = [
    "노보민 시럽" => "멀미",
    "위평원" => "소화불량",
    "장편환" => "설사",
    "이부로엔" => "염증완화, 통증완화",
    "엑쎈코" => "근육통, 염증완화",
    "맥쎈" => "감기, 발열",
    "염산메클리진정" => "알레르기",
    "지르텍" => "알레르기",
    "로라딘" => "알레르기",
    "알마겔" => "속쓰림",
    "훼스탈 플러스" => "소화불량",
    "소보민시럽" => "기침, 가래",
    "펜잘큐" => "두통, 생리통",
    "마데카솔" => "찰과상, 외상(상처)",
    "알벤다졸" => "기생충 감염",
    "이지엔6프로" => "두통, 생리통",
    "미리코프파워" => "기침, 가래",
    "게보린정" => "두통, 생리통",
    "노루모" => "근육통, 통증완화",
    "케어번크림" => "화상",
    "파세몰비타" => "감기, 발열",
    "노텍" => "소화불량",
    "아즈렌" => "화상",
    "바이스탑" => "설사",
    "화이투벤큐노즈" => "콧물, 기침",
    "타이레놀" => "두통, 발열, 생리통",
    "포타겔" => "속쓰림",
    "로프민" => "설사"
];

// Levenshtein 거리 계산 함수
function getClosestMedicine($input, $medicines, $threshold = 0.8) {
    $closest = null;
    $shortest = -1;
    
    foreach ($medicines as $medicine => $symptom) {
        $lev = levenshtein($input, $medicine);
        $distance = 1 - ($lev / max(strlen($input), strlen($medicine)));

        if ($distance >= $threshold && ($distance > $shortest || $shortest < 0)) {
            $closest = $medicine;
            $shortest = $distance;
        }
    }
    
    return ($shortest >= $threshold) ? $closest : null;
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['name'])) {
    $name = $data['name'];
    $closest_medicine = getClosestMedicine($name, $medicine_symptoms);

    if ($closest_medicine !== null) {
        $symptoms = $medicine_symptoms[$closest_medicine];

        $conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

        if ($conn->connect_error) {
            echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO medicines (name, symptoms, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $closest_medicine, $symptoms, $user_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert medicine']);
        }
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => '입력한 약품이 목록에 없습니다.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No medicine name provided']);
}
?>
