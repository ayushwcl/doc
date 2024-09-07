<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $document_id = $_POST['document_id'];
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];

    // Save the content to the database
    $stmt = $conn->prepare("INSERT INTO document_collaboration (document_id, user_id, content) VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE content = VALUES(content), updated_at = CURRENT_TIMESTAMP");
    $stmt->bind_param("iis", $document_id, $user_id, $content);
    $stmt->execute();
}
?>
