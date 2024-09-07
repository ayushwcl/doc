<?php
include 'includes/db.php';
include 'includes/functions.php';
check_login($conn);

// Get the document ID from the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $doc_id = $_GET['id'];
    
    // Fetch the document details from the database
    $sql = "SELECT file_path FROM documents WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $doc_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $doc = $result->fetch_assoc();
        $file_path = $doc['file_path'];
        
        // Check if the file exists
        if (file_exists($file_path)) {
            $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
            
            // Determine MIME type
            switch ($file_extension) {
                case 'pdf':
                    $mime_type = 'application/pdf';
                    break;
                case 'ppt':
                case 'pptx':
                    $mime_type = 'application/vnd.ms-powerpoint';
                    break;
                default:
                    $mime_type = 'application/octet-stream';
            }

            // Set headers
            header('Content-Type: ' . $mime_type);
            header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
            readfile($file_path);
            exit;
        } else {
            echo "File does not exist.";
        }
    } else {
        echo "Document not found or access denied.";
    }
} else {
    echo "Invalid document ID.";
}
?>
