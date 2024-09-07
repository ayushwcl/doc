<?php
$servername = "mydocsvraz.mysql.database.azure.com";
$username = "thirdstoat2";
$password = "Server@1";
$dbname = "document_collaboration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
