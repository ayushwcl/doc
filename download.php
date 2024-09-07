<?php
include 'includes/db.php';
include 'includes/functions.php';
check_login($conn);

// Function to force download of a file
function force_download($file_path) {
    if (file_exists($file_path)) {
        // Get the file info
        $file_name = basename($file_path);
        $file_size = filesize($file_path);
        $file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        // Define headers for download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $file_size);

        // Clear output buffer
        flush();

        // Read the file and send it to the user
        readfile($file_path);
        exit();
    } else {
        echo "File not found.";
    }
}

// Handle the file download request
if (isset($_GET['file'])) {
    $file_path = $_GET['file'];

    // Sanitize and validate file path
    $file_path = realpath($file_path);
    
    if ($file_path && file_exists($file_path) && strpos($file_path, 'uploads/') === 0) {
        force_download($file_path);
    } else {
        echo "Invalid file path.";
    }
} else {
    echo "No file specified.";
}
?>
