<?php
session_start();
require 'includes/db.php';

$document_id = $_GET['document_id'];

$stmt = $conn->prepare("SELECT content FROM document_collaboration WHERE document_id = ?");
$stmt->bind_param("i", $document_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['content' => $row['content']]);
} else {
    echo json_encode(['content' => '']);
}
?>
