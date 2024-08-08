<?php
include 'db_connection.php';

// Check if product id is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch product details from database
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $images = json_decode($product['images'], true); // Decode images JSON into associative array
    } else {
        echo "Product not found.";
        exit;
    }

    // Handle form submission to update product
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $length = $_POST['length'];
        $width = $_POST['width'];
        $depth = $_POST['depth'];

        // Handle file uploads if new files are provided
        if (!empty(array_filter($_FILES['images']['name']))) {
            $targetDir = "uploads/";
            foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                $fileName = basename($_FILES['images']['name'][$key]);
                $targetFilePath = $targetDir . $fileName;
                if (move_uploaded_file($tmpName, $targetFilePath)) {
                    $images[] = $fileName;
                }
            }
        }

        // Handle image removal
        if (isset($_POST['remove_images'])) {
            foreach ($_POST['remove_images'] as $index) {
                if (isset($images[$index])) {
                    // Remove image file from server
                    $fileToRemove = "uploads/" . $images[$index];
                    if (file_exists($fileToRemove)) {
                        unlink($fileToRemove);
                    }
                    // Remove image from images array
                    unset($images[$index]);
                }
            }
        }

        // Convert images array back to JSON
        $imagesJson = json_encode(array_values($images)); // Re-index the array after removals

        // Update product in database
        $updateSql = "UPDATE product SET name = ?, price = ?, description = ?, category = ?, images = ?, length = ?, width = ?, depth = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ssssssssi", $name, $price, $description, $category, $imagesJson, $length, $width, $depth, $id);

        if ($updateStmt->execute()) {
            header("Location: products.php"); // Redirect to products.php after successful update
            exit();
        } else {
            echo "Error updating product: " . $updateStmt->error;
        }
    }
} else {
    echo "Product ID not provided.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Include necessary CSS and JS files -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $product['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="Living Room" <?php if ($product['category'] === 'Living Room') echo 'selected'; ?>>Living Room</option>
                    <option value="dinning" <?php if ($product['category'] === 'dinning') echo 'selected'; ?>>Dining</option>
                    <option value="bedroom" <?php if ($product['category'] === 'bedroom') echo 'selected'; ?>>Bedroom</option>
                    <option value="fabrics" <?php if ($product['category'] === 'fabrics') echo 'selected'; ?>>Fabrics</option>
                    <option value="others" <?php if ($product['category'] === 'others') echo 'selected'; ?>>Others</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="length" class="form-label">Length</label>
                <input type="text" class="form-control" id="length" name="length" value="<?php echo $product['length']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="width" class="form-label">Width</label>
                <input type="text" class="form-control" id="width" name="width" value="<?php echo $product['width']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="depth" class="form-label">Depth</label>
                <input type="text" class="form-control" id="depth" name="depth" value="<?php echo $product['depth']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Images</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple>
            </div>
            <div class="mb-3">
                <label class="form-label">Current Images</label><br>
                <?php if (!empty($images)): ?>
                    <div class="row">
                        <?php foreach ($images as $index => $image): ?>
                            <div class="col-md-2 mb-3">
                                <img src="uploads/<?php echo $image; ?>" class="img-thumbnail" width="100">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remove_images[]" value="<?php echo $index; ?>">
                                    <label class="form-check-label">Remove</label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No images uploaded.</p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
