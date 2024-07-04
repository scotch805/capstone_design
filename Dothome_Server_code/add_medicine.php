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

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    if (array_key_exists($name, $medicine_symptoms)) {
        $symptoms = $medicine_symptoms[$name];

        $conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO medicines (name, symptoms, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $symptoms, $user_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("Location: add_medicine.php");
        exit();
    } else {
        $error_message = "입력한 약품이 목록에 없습니다.";
    }
}

// 데이터베이스에서 현재 추가된 약품 목록 가져오기
$conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, symptoms FROM medicines WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$medicines = [];

while ($row = $result->fetch_assoc()) {
    $medicines[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>약품 추가</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background:#FCFDFE;
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
        }
        html, body {
            margin:0;
            height:100%;
            overflow:hidden;
        }
        .info_box{
            width: 90%;
            margin: 0 auto;
            text-align: center;
            height: 130px;
        }
        .info_box .login {height:22%;text-align: right;cursor:pointer;}
        .info_box .title{
            margin-top:30px;
            margin-left: 0%;
            cursor:pointer;
        }
        .title_name {
            margin:0px;
            font-weight: 300;
            font-size: 45px;
        }
        .container {
            border-top:1px solid #ccc;
            display: flex;
            margin:0 auto;
            width:95%;
            height:calc(100% - 130px);
            position:relative;
        }
        .content {
            flex:1;
            overflow-y: auto;
        }
        .sidebar {
            width: 300px;
            height: 100%;
            border-left: 1px solid #ccc;
            position: relative;
            right:0px;
            display: flex;
            flex-direction: column;
            background-color:white;
        }
        .sidebar h2 {
            position: sticky;
            top: 0;
            background-color: white;
            padding-top: 10px;
            padding-bottom: 10px;
            z-index: 1;
        }
        .sidebar-content {
            overflow-y: auto;
            flex: 1;
            padding-top: 20px;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 20px;
        }
        .result-item {
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
            padding-bottom: 10px;
            font-size: 16px;
            position: relative;
        }
        h1 {
            font-weight:500;
            font-size:40px;
        }
        h2 {
            font-weight:500;
            font-size:40px;
        }
        .subtitle {
            position:relative;
            display:flex;
            font-weight:100;
            font-size:20px;
            top:-20px;
        }
        .imgform {
            position:relative;
            display:flex;
            font-weight:100;
            font-size:20px;
            top:-30px;
        }
        .result-item pre {
            display: none;
            font-size: 16px;
        }
        .result-item:hover pre {
            display: block;
        }
        img {
            max-width: 100%;
            height: auto;
            max-height: 400px;
        }
        .pill-info {
            font-size: 16px;
            margin-top: 10px;
        }
        button {
            border-radius:20px;
            border:none;
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 400;
            font-size:15px;
            height:30px;
            width:100px;
            background-color:#D9D9D9;
            cursor:pointer;
        }
        button[type="submit"] {
            border-radius:20px;
            border:none;
            font-family: "Noto Sans KR", sans-serif;
            font-optical-sizing: auto;
            font-style: normal;
            font-weight: 400;
            font-size:15px;
            height:30px;
            background: linear-gradient(210deg, #ADF47C, #379947);
            color:black;
            border:none;
            border-radius:20px;
            cursor:pointer;
        }
        .button-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        /* 약품 검색 결과 리스트 스타일 */
        .autocomplete-suggestions {
            border: 1px solid #ddd;
            background: #fff;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            z-index: 9999;
        }
        .autocomplete-suggestion {
            padding: 10px;
            cursor: pointer;
        }
        .autocomplete-selected {
            background: #f0f0f0;
        }
    </style>
    <script>
        $(document).ready(function() {
            const medicineSymptoms = <?php echo json_encode($medicine_symptoms); ?>;

            $('#name').on('input', function() {
                const query = $(this).val().toLowerCase();
                const suggestions = Object.keys(medicineSymptoms).filter(name => name.toLowerCase().includes(query));
                const suggestionBox = $('#autocomplete-suggestions');
                suggestionBox.empty();
                if (suggestions.length > 0 && query !== '') {
                    suggestions.forEach(suggestion => {
                        suggestionBox.append('<div class="autocomplete-suggestion">' + suggestion + '</div>');
                    });
                    suggestionBox.show();
                } else {
                    suggestionBox.hide();
                }
            });

            $(document).on('click', '.autocomplete-suggestion', function() {
                $('#name').val($(this).text());
                $('#autocomplete-suggestions').hide();
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('#name, #autocomplete-suggestions').length) {
                    $('#autocomplete-suggestions').hide();
                }
            });
        });

        function deleteMedicine(id) {
            $.post("delete_medicine.php", { medicine_id: id }, function(data) {
                if (data === "success") {
                    $("#medicine-" + id).remove();
                } else {
                    alert("약품 삭제에 실패했습니다.");
                }
            });
        }
    </script>
</head>
<body>
    <div class="info_box">
        <div class="user-info">
            <div class="login" onclick=window.open("/","_self")>
                <span class="material-symbols-outlined">account_circle</span>
            </div>
        </div>
        <div class="title" onclick=window.open("../main.php","_self")>
            <p class="title_name">방구석 약상자</p>
        </div>
    </div>
    <div class="container">
        <div class="content">
            <h2>약품 추가</h2>
            <?php if ($error_message): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <form method="POST" action="add_medicine.php" class="imgform">
                <label for="name">약품 이름:</label>
                <input type="text" id="name" name="name" required>
                <div id="autocomplete-suggestions" class="autocomplete-suggestions"></div>
                <button type="submit">추가</button>
            </form>

            <h3>현재 추가된 약품</h3>
            <ul>
                <?php foreach ($medicines as $medicine): ?>
                    <li id="medicine-<?php echo $medicine['id']; ?>">
                        <?php echo htmlspecialchars($medicine['name']) . " (" . htmlspecialchars($medicine['symptoms']) . ")"; ?>
                        <button onclick="deleteMedicine(<?php echo $medicine['id']; ?>)">x</button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
