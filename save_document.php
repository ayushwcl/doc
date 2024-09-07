<?php
include 'includes/db.php';
include 'includes/functions.php';
check_login($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'];
    $edit_id = intval($_POST['edit_id']);
    
    // Sanitize and validate input
    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

    // Fetch the file path
    $sql = "SELECT file_path FROM documents WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $edit_id, $_SESSION['user_id']);
    $stmt->execute();
    $document = $stmt->get_result()->fetch_assoc();
    
    if ($document) {
        $file_path = $document['file_path'];

        // Save the content
        if (file_put_contents($file_path, $content) !== false) {
            echo 'Document updated successfully';
        } else {
            echo 'Failed to update document';
        }
    } else {
        echo 'Document not found';
    }
} else {
    echo 'Invalid request method';
}
?>
