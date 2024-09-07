<?php
include 'includes/db.php';
include 'includes/functions.php';
check_login($conn);

$edit_id = intval($_GET['edit_id'] ?? 0);

if ($edit_id > 0) {
    // Fetch the document content
    $sql = "SELECT file_path FROM documents WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $edit_id, $_SESSION['user_id']);
    $stmt->execute();
    $document = $stmt->get_result()->fetch_assoc();
    
    if ($document) {
        $file_path = $document['file_path'];
        $content = file_get_contents($file_path); // Assuming it's a text-based file like HTML
        $file_name = basename($file_path); // Get the file name
    } else {
        echo "Document not found.";
        exit;
    }
} else {
    echo "Invalid document ID.";
    exit;
}

include 'includes/header.php';
?>

<main>
    <div class="button-group">
        <button id="save-button" class="btn btn-primary">Save Document</button>
        <button id="cancel-button" class="btn btn-secondary">Cancel</button>
    </div>

    <h2>Edit Document</h2>
    <p class="file-info">Editing: <strong><?php echo htmlspecialchars($file_name); ?></strong></p>
    <div id="editor-container"></div>
</main>

<!-- Quill Scripts -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script>
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                ['link']
            ]
        }
    });

    quill.root.innerHTML = <?php echo json_encode($content); ?>;

    document.getElementById('save-button').addEventListener('click', function() {
        var html = quill.root.innerHTML;
        var edit_id = <?php echo $edit_id; ?>;
        
        fetch('save_document.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'content=' + encodeURIComponent(html) + '&edit_id=' + encodeURIComponent(edit_id)
        })
        .then(response => response.text())
        .then(data => {
            alert('Document saved successfully');
            window.location.href = 'document.php'; // Redirect to document.php
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    document.getElementById('cancel-button').addEventListener('click', function() {
        window.location.href = 'document.php'; // Redirect to document.php or any other page
    });
</script>

<?php include 'includes/footer.php'; ?>
