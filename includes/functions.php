<?php
function check_login($conn) {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function sanitize_input($data) {
    return htmlspecialchars(strip_tags($data));
}
?>
