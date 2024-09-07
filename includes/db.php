$servername = "mydocsvraz.mysql.database.azure.com";
$username = "thirdstoat2";
$password = "Server@1";
$dbname = "document_collaboration";
$port = 3306; // Default MySQL port

$conn = mysqli_init();

mysqli_real_connect($conn, $servername, $username, $password, $dbname, $port, NULL, MYSQLI_CLIENT_SSL);

if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

