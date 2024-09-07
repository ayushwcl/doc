<?php
include 'includes/db.php';
include 'includes/functions.php';
check_login($conn);

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    if ($delete_id > 0) {
        // Fetch the document file path to delete
        $sql = "SELECT file_path FROM documents WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $delete_id, $_SESSION['user_id']);
        $stmt->execute();
        $document = $stmt->get_result()->fetch_assoc();

        if ($document) {
            $file_path = $document['file_path'];
            if (unlink($file_path)) {
                // Delete record from database
                $sql = "DELETE FROM documents WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $delete_id);
                if ($stmt->execute()) {
                    header("Location: document.php");
                    exit();
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Failed to delete file.";
            }
        } else {
            echo "Document not found.";
        }
    }
} else {
    echo "Invalid request.";
}
?>
