<?php
include 'db_connection.php';

// Query to count total wishlist
$sqlWishlistCount = "SELECT COUNT(*) AS wishlist_count FROM wishlist";
$resultWishlistCount = $conn->query($sqlWishlistCount);
$rowWishlistCount = $resultWishlistCount->fetch_assoc();
$WishlistCount = $rowWishlistCount['wishlist_count'];
// Query to count total products
$sqlProductCount = "SELECT COUNT(*) AS product_count FROM product";
$resultProductCount = $conn->query($sqlProductCount);
$rowProductCount = $resultProductCount->fetch_assoc();
$productCount = $rowProductCount['product_count'];

// Query to sum up prices in wishlist
$sqlWishlistTotal = "SELECT SUM(price) AS total_price FROM wishlist";
$resultWishlistTotal = $conn->query($sqlWishlistTotal);
$rowWishlistTotal = $resultWishlistTotal->fetch_assoc();
$wishlistTotal = $rowWishlistTotal['total_price'];

// Query to count total visitors

 $sqlVisitorCount = "SELECT COUNT(*) AS visitor_count FROM visitor";
 $resultVisitorCount = $conn->query($sqlVisitorCount);
 $rowVisitorCount = $resultVisitorCount->fetch_assoc();
 $visitorCount = $rowVisitorCount['visitor_count'];

 $sqlVisitorCount = "SELECT COUNT(*) AS visitor_count FROM visitor";
 $resultVisitorCount = $conn->query($sqlVisitorCount);
 $rowVisitorCount = $resultVisitorCount->fetch_assoc();
 $visitorCount = $rowVisitorCount['visitor_count'];


// Close connection
$conn->close();
?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard | Paul's Funitures</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="assets/vendor/flagiconcss/css/flag-icon.min.css" rel="stylesheet">
    <link href="../../img/Asset 8.png" rel="icon">
</head>

<body>
    <div class="wrapper">
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
                    <div class="row">
                        <div class="col-md-12 page-header">
                            <div class="page-pretitle">Overview</div>
                            <h2 class="page-title">Dashboard</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="teal fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <a href="wishlist.php">
                                                    <p class="detail-subtitle">All Wishlists</p>
                                                    <span class="number"><?php echo $WishlistCount; ?></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-calendar"></i> For this Week
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="olive fas fa-money-bill-alt"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <a href="wishlist.php">

                                                    <p class="detail-subtitle">Wishlist total(ksh)</p>
                                                    <span class="number"><?php echo number_format($wishlistTotal, 2); ?> </span>

                                                    

                                                    </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-calendar"></i> For this Month
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="violet fas fa-eye"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="detail">
                                                <a href="visitors.php">
                                                    <p class="detail-subtitle">All Visitors</p>
                                                    <span class="number"><?php echo $visitorCount; ?></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-stopwatch"></i> For this Month
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="icon-big text-center">
                                                <i class="orange fas fa-shopping-cart"></i>
                                            </div>
                                        </div>
                                        
                                            <div class="col-sm-8">
                                                <div class="detail">
                                                    <a href="products.php">
                                                        <p class="detail-subtitle">All Products</p>
                                                        <span class="number"><?php echo $productCount; ?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        
                                        
                                    </div>
                                    <div class="footer">
                                        <hr />
                                        <div class="stats">
                                            <i class="fas fa-envelope-open-text"></i> For this week
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="content">
                                            <div class="head">
                                                <h5 class="mb-0">Traffic Overview</h5>
                                                <p class="text-muted">Current year website visitor data</p>
                                            </div>
                                            <div class="canvas-wrapper">
                                                <canvas class="chart" id="trafficflow"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="content">
                                            <div class="head">
                                                <h5 class="mb-0">Wishlist Overview</h5>
                                                <p class="text-muted">Current year wishlist data</p>
                                            </div>
                                            <div class="canvas-wrapper">
                                                <canvas class="chart" id="sales"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="content">
                <div class="head">
                    <h5 class="mb-0">Top Visitors by Country</h5>
                    <p class="text-muted">Current year website visitor data</p>
                </div>
                <div class="canvas-wrapper">
                    <table class="table table-striped">
                        <thead class="success">
                            <tr>
                                <th>Country</th>
                                <th class="text-end">Unique Visitors</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            date_default_timezone_set('Africa/Nairobi');

                            // Function to simulate daily increments for Kenya
                            function getKenyaVisits() {
                                $time = date('H'); // Current hour in 24-hour format

                                // Determine the increment based on the current time
                                if ($time >= 5 && $time < 10) {
                                    // Morning phase (05:00 - 10:00)
                                    return rand(1000, 5000);
                                } elseif ($time >= 10 && $time < 15) {
                                    // Midday phase (10:00 - 15:00)
                                    return rand(2000, 7000);
                                } elseif ($time >= 15 && $time < 20) {
                                    // Afternoon phase (15:00 - 20:00)
                                    return rand(3000, 9000);
                                } else {
                                    // Outside the specified phases, return a default increment
                                    return rand(1000, 3000);
                                }
                            }

                            // Function to generate initial random visits for all countries (all start with 0)
                            function getInitialVisits() {
                                return 0; // All countries start with 0 visits initially
                            }

                            // Array of countries with their flags and base visits
                            $countries = [
                                ["<i class='flag-icon flag-icon-ke'></i> Kenya",  getInitialVisits()],
                                ["<i class='flag-icon flag-icon-ug'></i> Uganda", getInitialVisits()],
                                ["<i class='flag-icon flag-icon-tz'></i> Tanzania", getInitialVisits()],
                                ["<i class='flag-icon flag-icon-rw'></i> Rwanda", getInitialVisits()],
                                ["<i class='flag-icon flag-icon-us'></i> United States", getInitialVisits()],
                                ["<i class='flag-icon flag-icon-ng'></i> Nigeria", getInitialVisits()],
                            ];

                            // Sort countries array so Kenya is always at the top
                            usort($countries, function($a, $b) {
                                if ($a[0] === "<i class='flag-icon flag-icon-ke'></i> Kenya") {
                                    return -1;
                                } elseif ($b[0] === "<i class='flag-icon flag-icon-ke'></i> Kenya") {
                                    return 1;
                                } else {
                                    return $b[1] - $a[1];
                                }
                            });

                            // Assign Kenya's actual visit count using the getKenyaVisits function
                            $countries[0][1] = getKenyaVisits();

                            // Generate the table rows
                            foreach ($countries as $country) {
                                echo "<tr>
                                        <td>{$country[0]}</td>
                                        <td class='text-end'>" . number_format($country[1]) . "</td>
                                      </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="content">
                <div class="head">
                    <h5 class="mb-0">Most Visited Pages</h5>
                    <p class="text-muted">Current year website visitor data</p>
                </div>
                <div class="canvas-wrapper">
                    <table class="table table-striped">
                        <thead class="success">
                            <tr>
                                <th>Page Name</th>
                                <th class="text-end">Visitors</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Database connection
                            include 'db_connection.php';

                            // Query to get the most visited pages
                            $sql = "SELECT last_visited_page, COUNT(*) as visits 
                                    FROM visitor 
                                    GROUP BY last_visited_page 
                                    ORDER BY visits DESC 
                                    LIMIT 10";
                            $result = $conn->query($sql);

                            // Check if the query was successful
                            if ($result->num_rows > 0) {
                                // Loop through the results and generate table rows
                                while ($row = $result->fetch_assoc()) {
                                    $page = htmlspecialchars($row['last_visited_page']);
                                    $visits = number_format($row['visits']);
                                    echo "<tr>
                                            <td>{$page} <a href=\"{$page}\"><i class=\"fas fa-link blue\"></i></a></td>
                                            <td class=\"text-end\">{$visits}</td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan=\"2\">No data available</td></tr>";
                            }
                            // Query to calculate the sum of the price column
                            $sql = "SELECT SUM(price) AS total_price FROM product";
                            $result = $conn->query($sql);

                            // Check if the query was successful
                            if ($result->num_rows > 0) {
                                // Fetch the sum of price
                                $row = $result->fetch_assoc();
                                $totalPrice = $row['total_price'];
                            } else {
                                $totalPrice = 0; // Default to 0 if no rows are returned
                            }

                            
                            $conn->close();

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="dfd text-center">
                                            <i class="blue large-icon mb-2 fas fa-thumbs-up"></i>
                                            <h4 class="mb-0">+21,900</h4>
                                            <p class="text-muted">PRODUCTS LIKES</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="dfd text-center">
                                            <i class="orange large-icon mb-2 fas fa-reply-all"></i>
                                            <h4 class="mb-0">+22,566</h4>
                                            <p class="text-muted">PRODUCT SHARING</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="dfd text-center">
                                            <i class="grey large-icon mb-2 fas fa-envelope"></i>
                                            <h4 class="mb-0">+15,566</h4>
                                            <p class="text-muted">E-MAIL SUBSCRIBERS</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <div class="dfd text-center">
                                            <i class="olive large-icon mb-2 fas fa-dollar-sign"></i>
                                            <h4 class="mb-0"><?php echo number_format($totalPrice, 2); ?></h4>
                                            <p class="text-muted">TOTAL PRODUCT AMOUNT</p>
                                        </div>
                                    </div>
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
    <script src="assets/vendor/chartsjs/Chart.min.js"></script>
    <script src="assets/js/dashboard-charts.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
