
<?php
// Include database connection
include 'db_connection.php';

// Fetch products from the database
$sql = "SELECT id, name, images, description, price, category,length,width,depth, created_at FROM product";
$result = $conn->query($sql);

$count = 1;
?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Products | Paul's Furnitures</title>
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
                    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <a href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a>
                </li>
                <li>
                    <a href="products.php"><i class="fas fa-table"></i> Products</a>
                </li>
                <li>
                    <a href="visitors.php"><i class="fas fa-chart-bar"></i> Visitors</a>
                </li>
                <li>
                    <a href="addproduct.php" style="color:red;"><i class="fa fa-plus"></i> ADD PRODUCT</a>
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
                                        <li><a href="index.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
                        <h3>All Poducts
                            <a href="addproduct.php" class="btn btn-sm btn-outline-primary float-end"><i class="fas fa-plus"> </i>  Add</a>
                        </h3>
                    </div>
                    <div class="box box-primary">
        <div class="box-body">
            <!-- <div class="search-bar">
                <input type="text" class="form-control" id="searchInput" placeholder="Search...">
            </div> -->
            <div class="table-responsive">
            <table width="100%" class="table table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Images</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Length</th>
                        <th>Width</th>
                        <th>Depth</th>
                        <th>Upload Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Decode images JSON
                            $images = json_decode($row['images']);
                            // Display product data
                            echo "<tr>";
                            echo "<td>" . $count . "</td>"; // Display count
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>";
                            foreach ($images as $image) {
                                echo "<img src='uploads/" . $image . "' alt='" . $row['name'] . "' width='50' height='50' style='margin-right: 5px;'>";
                            }
                            echo "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>" . $row['length'] . "</td>";
                            echo "<td>" . $row['width'] . "</td>";
                            echo "<td>" . $row['depth'] . "</td>";
                            echo "<td>" . $row['created_at'] . "</td>";
                            echo "<td class='text-end'>
                                    <a href='edit_product.php?id=" . $row['id'] . "' class='btn btn-outline-info btn-rounded'><i class='fas fa-pen'></i></a>
                                    <a href='delete_product.php?id=" . $row['id'] . "' class='btn btn-outline-danger btn-rounded'><i class='fas fa-trash'></i></a>
                                  </td>";
                            echo "</tr>";
                            $count++; // Increment count
                        }
                    } else {
                        echo "<tr><td colspan='8'>No products found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript to handle the search functionality
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#dataTables-example tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
</body>

</html>
<?php
// Close connection
$conn->close();
?>