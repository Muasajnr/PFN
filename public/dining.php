<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Africa/Nairobi'); // Set Nairobi timezone

session_start();

// Function to get device identifier
function getDeviceIdentifier() {
    $device_id = isset($_COOKIE['device_id']) ? $_COOKIE['device_id'] : '';

    if (empty($device_id)) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $ip = get_client_ip();
        $device_id = md5($user_agent . $ip);
        setcookie('device_id', $device_id, time() + (86400 * 30), '/'); // 30 days expiration
        $_SESSION['device_id'] = $device_id;
    }

    return $device_id;
}

// Function to get client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// Function to get browser information
function getBrowser() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = "Unknown Browser";

    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );

    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
            break;
        }
    }

    return $browser;
}

// Function to log page visits
function logPageVisit($page, $device_id) {
    include 'db/db_connection.php';

    $time_visited = date('Y-m-d H:i:s');

    $sql = "INSERT INTO visitor (device_id, ip_address, browser, time_in, last_visited_page) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $device_id, $_SESSION['ip_address'], $_SESSION['browser'], $time_visited, $page);
    $stmt->execute();

    if ($stmt->errno) {
        echo "Error inserting visitor: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Function to log visitor logout with current time as time_out
function logVisitorLogout($device_id) {
    include 'db/db_connection.php';

    $time_out = date('Y-m-d H:i:s');

    $sql = "INSERT INTO visitor (device_id, ip_address, browser, time_in, last_visited_page, time_out)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $device_id, $_SESSION['ip_address'], $_SESSION['browser'], $_SESSION['time_in'], $_SERVER['REQUEST_URI'], $time_out);
    $stmt->execute();

    if ($stmt->errno) {
        echo "Error inserting visitor logout: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Check if the device is logging out or exiting the website
if (isset($_GET['logout']) && isset($_SESSION['device_id'])) {
    $device_id = $_SESSION['device_id'];
    logVisitorLogout($device_id);
    session_destroy();
    exit;
}

// Set session IP address and browser if not already set
if (!isset($_SESSION['ip_address'])) {
    $_SESSION['ip_address'] = get_client_ip();
}

if (!isset($_SESSION['browser'])) {
    $_SESSION['browser'] = getBrowser();
}

// Function to get the device identifier
$device_id = getDeviceIdentifier();

// Get the current timestamp
$time_in = date('Y-m-d H:i:s');
$_SESSION['time_in'] = $time_in;

// Log the current page visit
$current_page = $_SERVER['REQUEST_URI'];
logPageVisit($current_page, $device_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dinning| Paul's Furnitures Ngong Road</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .product-image {
            max-width: 100%;
            max-height: 200px;
            min-width: 100px;
            min-height: 150px;
            object-fit: contain;
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="index.php" class="navbar-brand d-flex align-items-center text-center">
                    <div class="icon p-1 me-2">
                        <img class="img-fluid" src="img/Asset 8.png" alt="Icon" style="width: 60px; height: 60px;">
                    </div>
                    <h1 class="m-0 text-danger">Paul's Furnitures</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="index.php" class="nav-item nav-link ">Home</a>
                        <a href="livingroom.php" class="nav-item nav-link">Living Room</a>
                        <a href="dining.php" class="nav-item nav-link active">Dinning</a>
                        <a href="bedroom.php" class="nav-item nav-link">Bedroom</a>
                        <a href="fabrics.php" class="nav-item nav-link">Fabrics</a>
                        <a href="others.php" class="nav-item nav-link">Others</a>
                        
                    </div>
                    <a href="wishlist.php" class="btn btn-primary px-3 d-none d-lg-flex"><i class="bi bi-suit-heart-fill"></i>&nbsp; Wishlist</a>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <!-- Property List Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <?php
                            include 'db/db_connection.php';

                            // Fetch all products
                            $sql = "SELECT * FROM product WHERE category = 'dinning'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $productId = $row['id'];
                                    $name = $row['name'];
                                    $price = $row['price'];
                                    $description = $row['description'];
                                    $length = $row['length'];
                                    $width = $row['width'];
                                    $depth = $row['depth'];
                                    $images = json_decode($row['images'], true);
                                    $main_image = isset($images[0]) ? 'admin/uploads/' . $images[0] : 'admin/uploads/placeholder.jpg'; // Get the first image or use a placeholder if no images are present

                                    // Generating HTML for each product
                                    echo '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">';
                                    echo '<a href="product_list.php?id=' . $productId . '">';
                                    echo '<div class="property-item rounded overflow-hidden" style="cursor: pointer;">';
                                    echo '<div class="position-relative overflow-hidden">';
                                    echo '<img class="img-fluid product-image" src="' . $main_image . '" alt="">';
                                    echo '</div>';
                                    echo '<div class="p-4 pb-0">';
                                    echo '<h5 class="text-primary mb-3">Ksh ' . $price . '</h5>';
                                    echo '<a class="d-block h5 mb-2" href="product_list.php?id=' . $productId . '">' . $name . '</a>';
                                    echo '</div>';
                                    echo '<div class="d-flex border-top">';
                                    echo '<small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>L' . $length . ' sqft</small>';
                                    echo '<small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>W' . $width . ' sqft</small>';
                                    echo '<small class="flex-fill text-center py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>D' . $depth . ' sqft</small>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</a>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No products found.</p>';
                            }

                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Property List End -->

        


       
        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Get In Touch</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Lenana Stage,Ngong Road</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>0715042230</p>
                        
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-whatsapp"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Quick Links</h5>
                        <a class="btn btn-link text-white-50" href="livingRoom.php">Living Room</a>
                        <a class="btn btn-link text-white-50" href="dinning.php">Dinning</a>
                        <a class="btn btn-link text-white-50" href="bedRoom.php">Bedroom</a>
                        <a class="btn btn-link text-white-50" href="fabrics.php">Fabrics</a>
                        <a class="btn btn-link text-white-50" href="others.php">Others</a>
                        <a class="btn btn-link text-white-50" href="wishlist.php">Wishlist</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Brand Gallery</h5>
                        <div class="row g-2 pt-2">
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-1.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-2.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-3.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-4.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-5.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-6.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Attention !!!</h5>
                        <p>This site will only allow you to explore the furnitures not placing orders. All the best .</p>
                        
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">2024</a> All Right Reserved. 
							
							Designed By <a class="border-bottom" href="https://muasadesigns.liveblog365.com/?i=1">MCM Tech Hub</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>