<?php
$servername = "mydocsvraz.mysql.database.azure.com"; // or your server name
$username = "thirdstoat2@4.255.20.19"; // your database username
$password = "Server@1"; // your database password
$dbname = "document_collaboration"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
