<?php
// Database connection parameters
$host = getenv('DB_HOST'); // The environment variable set to 'db'
$dbname = getenv('DB_NAME'); // The environment variable set to 'bookmarks'
$user = getenv('DB_USER'); // The environment variable set to 'root'
$pass = getenv('DB_PASSWORD'); // The environment variable set to 'rootpassword'

try {
    // Create a PDO instance and establish the connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // If the connection is successful, this message will be shown
    echo "Connected successfully to the database '$dbname'.";
} catch (PDOException $e) {
    // If the connection fails, display the error
    echo "Connection failed: " . $e->getMessage();
}
?>