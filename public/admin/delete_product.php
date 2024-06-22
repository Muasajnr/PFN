<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete product from database
    $sql = "DELETE FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: products.php"); // Redirect to products.php after successful deletion
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "No product ID provided!";
    exit;
}

$stmt->close();
$conn->close();
?>
