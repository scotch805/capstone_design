<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['ID'];
    $Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
    $Name = $_POST['Name'];
    $Gender = $_POST['Gender'];
    $Age = $_POST['Age'];

    // 데이터베이스 연결
    $conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 중복 아이디 체크
    $check_stmt = $conn->prepare("SELECT ID FROM article WHERE ID = ?");
    $check_stmt->bind_param("s", $ID);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // 이미 존재하는 아이디인 경우
        $error = "이미 사용 중인 아이디입니다.";
        $check_stmt->close();
        $conn->close();
        header("Location: register.php?error=$error");
        exit();
    } else {
        // 존재하지 않는 경우 회원가입 진행
        $stmt = $conn->prepare("INSERT INTO article (password, name, gender, age) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $Password, $Name, $Gender, $Age);
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: index.php"); // 회원가입 성공 후 로그인 페이지로 이동
            exit();
        } else {
            $error = "회원가입에 실패했습니다.";
            $stmt->close();
            $conn->close();
            header("Location: register.php?error=$error");
            exit();
        }
    }
}
?>
