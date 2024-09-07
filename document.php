<?php
include 'includes/db.php';
include 'includes/functions.php';
check_login($conn);

// Handle document deletion
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
                    header("Location: document.php"); // Redirect after deletion
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
}

// Retrieve documents for listing
$sql = "SELECT id, title, file_path FROM documents WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

include 'includes/header.php';

// Function to check if a file type requires a download button
function requires_download_button($file_path) {
    $downloadable_types = ['pdf', 'pptx', 'docx', 'xlsx']; // List of file types that should use download button
    $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    return in_array($file_extension, $downloadable_types);
}
?>
<main>
    <h2>Uploaded Documents</h2>
    <?php if ($result->num_rows > 0): ?>
        <div class="document-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="document-card">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <div class="document-actions">
                        <a href="view_document.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" target="_blank">View</a>
                        <?php if (requires_download_button($row['file_path'])): ?>
                            <a href="download.php?file=<?php echo urlencode($row['file_path']); ?>" class="btn btn-secondary">Download</a>
                        <?php else: ?>
                            <a href="edit_document.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-secondary">Edit</a>
                        <?php endif; ?>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this document?');">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No documents found.</p>
    <?php endif; ?>
</main>
<?php include 'includes/footer.php'; ?>
