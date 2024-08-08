<?php
// Database configuration
$servername = "sql207.byetcluster.com";
$username = "ezyro_36782018";
$password = "0346e325224e";
$dbname = "ezyro_36782018_pfn";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
