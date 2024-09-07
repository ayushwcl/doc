<?php
include 'includes/db.php';
include 'includes/functions.php';
check_login($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['documents'])) {
    $files = $_FILES['documents'];
    $upload_dir = 'uploads/';
    
    $success_message = '';
    $error_message = '';

    for ($i = 0; $i < count($files['name']); $i++) {
        if ($files['error'][$i] == 0) {
            $file_name = basename($files['name'][$i]);
            $file_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($files['tmp_name'][$i], $file_path)) {
                $title = htmlspecialchars($file_name); // Use filename as title
                $sql = "INSERT INTO documents (title, file_path, user_id) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssi', $title, $file_path, $_SESSION['user_id']);
                
                if ($stmt->execute()) {
                    $success_message = "Document(s) uploaded successfully.";
                } else {
                    $error_message = "Error: " . $conn->error;
                }
            } else {
                $error_message = "Failed to upload file: " . htmlspecialchars($file_name);
                break; // Stop processing further files on error
            }
        } else {
            $error_message = "Error uploading file: " . htmlspecialchars($file_name);
            break; // Stop processing further files on error
        }
    }
    
    if (empty($error_message)) {
        header("Location: document.php");
        exit();
    }
}
?>
<?php include 'includes/header.php'; ?>
<main>
    <h2>Upload Documents</h2>
    <?php if (!empty($success_message)) { ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php } ?>
    <?php if (!empty($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } ?>
    <form method="post" enctype="multipart/form-data" class="upload-form">
        <label for="documents">Documents:</label>
        <input type="file" name="documents[]" id="documents" multiple required>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</main>
<?php include 'includes/footer.php'; ?>
