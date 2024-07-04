<?php
session_start();

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['ID'];
    $Name = $_POST['Name'];
    $Gender = $_POST['Gender'];
    $Age = $_POST['Age'];
    $Allergies = $_POST['Allergies'];
    $Conditions = $_POST['Conditions'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 입력 데이터 검증
    if (empty($Name) || empty($Gender) || empty($Age) || $Age <= 0) {
        header("Location: edit_profile.php?error=" . urlencode("이름, 성별, 나이는 필수 입력입니다!"));
        exit();
    }

    // 데이터베이스 연결
    $conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 사용자 정보 업데이트
    $stmt = $conn->prepare("UPDATE article SET Name = ?, Gender = ?, Age = ?, Allergies = ?, Conditions = ? WHERE ID = ?");
    $stmt->bind_param("ssisss", $Name, $Gender, $Age, $Allergies, $Conditions, $ID);
    $update_success = $stmt->execute();
    $stmt->close();

    // 비밀번호 변경 로직
    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        if ($new_password !== $confirm_password) {
            $conn->close();
            header("Location: edit_profile.php?error=" . urlencode("새 비밀번호가 일치하지 않습니다."));
            exit();
        }

        // 현재 비밀번호 확인
        $stmt = $conn->prepare("SELECT Password FROM article WHERE ID = ?");
        $stmt->bind_param("s", $ID);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($current_password, $user['Password'])) {
            // 비밀번호 업데이트
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE article SET Password = ? WHERE ID = ?");
            $stmt->bind_param("ss", $new_password_hash, $ID);
            $password_update_success = $stmt->execute();
            $stmt->close();
        } else {
            $conn->close();
            header("Location: edit_profile.php?error=" . urlencode("현재 비밀번호가 일치하지 않습니다."));
            exit();
        }
    }

    $conn->close();

    if ($update_success) {
        // 수정 완료 후 프로필 페이지로 리디렉션
        header("Location: profile.php?success=" . urlencode("프로필 정보가 성공적으로 업데이트되었습니다."));
        exit();
    } else {
        header("Location: edit_profile.php?error=" . urlencode("프로필 수정에 실패했습니다."));
        exit();
    }
}
?>