<?php
// Include database connection
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $length = $_POST['length'];
    $width = $_POST['width'];
    $depth = $_POST['depth'];

    // Handle file uploads
    $images = [];
    $targetDir = "uploads/";
    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        $fileName = basename($_FILES['images']['name'][$key]);
        $targetFilePath = $targetDir . $fileName;
        if (move_uploaded_file($tmpName, $targetFilePath)) {
            $images[] = $fileName;
        }
    }

    // Convert images array to JSON
    $imagesJson = json_encode($images);

    // Insert data into database
    $sql = "INSERT INTO product (name, price, description, category, images,length,width,depth) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $name, $price, $description, $category, $imagesJson, $length,$width,$depth);

    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Product | Paul's Furnitures</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="../../img/Asset 8.png" rel="icon">
</head>

<body>
    <div class="wrapper">
        <!-- sidebar navigation component -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="../../img/Asset 8.png" alt="PFN logo" class="app-logo" width="50px" height="50px">
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="dashboard.php
                    "><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="wishlist.php
                    "><i class="fas fa-heart"></i> Wishlist</a>
                </li>
                <li>
                    <a href="products.php
                    "><i class="fas fa-table"></i> Products</a>
                </li>
                <li>
                    <a href="visitors.php
                    "><i class="fas fa-chart-bar"></i> Visitors</a>
                </li>
                <li>
                    <a href="addproduct.php
                    " style="color:red;"><i class="fa fa-plus"></i> ADD PRODUCT</a>
                </li>
                
                
            </ul>
        </nav>
        <!-- end of sidebar component -->
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav1" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-link"></i> <span>Quick Links</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu" aria-labelledby="nav1">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-list"></i> Access Logs</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-user-shield"></i> Roles</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span>Admin</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="index.php
                                        " class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>New Product</h3>
                    </div>
                    <div class="row">
                    <div class="col-lg-12">
    <div class="card">
        <div class="card-header">Add Product</div>
        <div class="card-body">
            <h5 class="card-title">Fill all fields and save to add a product</h5>
            <form class="needs-validation" novalidate accept-charset="utf-8" enctype="multipart/form-data" action="addproduct.php" method="post">
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Product Name" required>
                        <small class="form-text text-muted">Enter product name.</small>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Product Name.</div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" name="price" placeholder="Price" required>
                        <small class="form-text text-muted">Product Price.</small>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter product price.</div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" name="description" placeholder="Product Description" required style="height: 100px;">
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter product description.</div>
                </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-4">
                        <label for="length" class="form-label">Length</label>
                        <input type="number" class="form-control" name="length" placeholder="Enter Product Length" required >
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Enter Product Length.</div>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="width" class="form-label">Width</label>
                        <input type="number" class="form-control" name="width" placeholder="Enter Product Width" required >
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter product width.</div>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="depth" class="form-label">Depth</label>
                        <input type="number" class="form-control" name="depth" placeholder="Enter Product Depth" required >
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter product Depth.</div>
                    </div>
                <div class="row g-2">
                    <div class="mb-3 col-md-6">
                        <label for="Images" class="form-label">Images</label>
                        <input type="file" class="form-control" name="images[]" placeholder="Attach Images" required multiple>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please attach product images.</div>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="" selected>Choose...</option>
                            <option value="livingroom">Living Room</option>
                            <option value="dinning">Dining</option>
                            <option value="bedroom">Bedroom</option>
                            <option value="fabrics">Fabrics</option>
                            <option value="others">Others</option>
                        </select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select a Category.</div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="check1" required>
                        <label class="form-check-label" for="check1">Check me out</label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
            </form>
        </div>
    </div>
</div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/form-validator.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>