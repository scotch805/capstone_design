<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicine_id = $_POST['medicine_id'];

    $conn = new mysqli("localhost", "pilladvisor", "q1w2e3r4!", "pilladvisor");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("DELETE FROM medicines WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $medicine_id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo "success";
    exit();
}
?>
