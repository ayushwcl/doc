<?php
$servername = "localhost";
$username = "thirdstoat2";
$password = "Server@1";
$dbname = "document_collaboration";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn) {
    die("Connection failed: " . mysqli_error($conn));
}
?>
