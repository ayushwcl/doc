<?php
ob_start();
include 'includes/db.php';
include 'includes/functions.php';
check_login($conn);
?>
<?php include 'includes/header.php'; ?>
<main>
    <h2>Dashboard</h2>
    <p>Welcome to your dashboard.</p>
    <div class="button-container">
        <a href="upload.php" class="btn btn-primary">Upload a Document</a>
        <a href="document.php" class="btn btn-secondary">View/Edit Documents</a>
    </div>
</main>
<?php include 'includes/footer.php'; 
ob_end_flush();
?>
