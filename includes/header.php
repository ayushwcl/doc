<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Collaboration</title>
    <!-- Link to CSS file -->
    <link rel="stylesheet" href="includes/css/style.css">
</head>
<body>
    <header>
        <h1>Document Collaboration</h1>
        <nav>
            <ul>
                <?php
                // Ensure session is started in main script
                // session_start(); // Remove this line if session is started elsewhere

                // Function to get user's name from database
                function get_user_name($conn, $user_id) {
                    $sql = "SELECT username FROM users WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($row = $result->fetch_assoc()) {
                        return htmlspecialchars($row['username']);
                    }
                    return 'User';
                }

                // Determine the link for the Home button based on login status
                $home_link = isset($_SESSION['user_id']) ? 'document.php' : 'index.php';
                ?>

                <!-- Home link with dynamic href -->
                <li><a href="<?php echo $home_link; ?>">Home</a></li>

                <?php
                $current_page = basename($_SERVER['PHP_SELF']);
                $pages_with_dashboard = ['dashboard.php', 'document.php', 'upload.php', 'edit_document.php'];

                if (isset($_SESSION['user_id'])) {
                    // If user is logged in, show Dashboard and user name with logout button
                    if (in_array($current_page, $pages_with_dashboard)) {
                        echo "<li><a href='dashboard.php'>Dashboard</a></li>";
                    }
                    echo "<li><a href='about.php'>About</a></li>";
                    $user_name = get_user_name($conn, $_SESSION['user_id']);
                    echo "<li class='user-name'>Welcome, $user_name</li>";
                    echo "<li><a href='logout.php' class='btn btn-danger'>Logout</a></li>";
                } else {
                    // If user is not logged in, show login and signup links
                    echo "<li><a href='about.php'>About</a></li>";
                    echo "<li><a href='login.php'>Login</a></li>";
                    echo "<li><a href='signup.php'>Signup</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
