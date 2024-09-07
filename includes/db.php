<?php
$servername = "localhost";
$username = "thirdstoat2";
$password = "Server@1";
$dbname = "document_collaboration";

// Create connection
$conn =new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn) {
    die("Connection failed: " . mysqli_error($conn));
}
?>
