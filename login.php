<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['ID'];
    $password = $_POST['Password'];

    // 데이터베이스 연결
    $conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

    // 쿼리 실행
    $stmt = $conn->prepare("SELECT ID, Password FROM article WHERE ID = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            // 로그인 성공
            $_SESSION['user_id'] = $row['ID'];
            header("Location: main.php"); // 로그인 후 이동할 페이지
            exit();
        } else {
            // 비밀번호가 일치하지 않음
            echo "비밀번호가 일치하지 않습니다.";
        }
    } else {
        // 아이디가 등록되지 않음
        echo "해당 아이디로 등록된 계정이 없습니다.";
    }

    // 자원 정리
    $stmt->close();
    $conn->close();
}
?>