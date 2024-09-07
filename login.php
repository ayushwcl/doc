<?php
include 'includes/db.php';
include 'includes/functions.php';

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize_input($_POST['username']);
    $password = sanitize_input($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
print_r($result);exit;
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login_flag'] = '1'; // Set login flag
        $_SESSION['last_activity'] = time(); // Set last activity time

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Invalid credentials";
    }
}
?>
<?php include 'includes/header.php'; ?>
<main>
    <section class="login-container">
        <h2>Login</h2>
        <?php if (isset($error_message)) { ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php } ?>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
        </form>
    </section>
</main>
<?php include 'includes/footer.php'; ?>
