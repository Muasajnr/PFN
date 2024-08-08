<?php
include 'db/db_connection.php';

// Get the product ID from the query string
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the product details based on the product ID
$sql = "SELECT * FROM product WHERE id = $product_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $price = $row['price'];
    $description = $row['description'];
    $length = $row['length'];
    $width = $row['width'];
    $depth = $row['depth'];
    $images = json_decode($row['images'], true);
    $main_image = isset($images[0]) ? 'admin/uploads/' . $images[0] : 'admin/uploads/placeholder.jpg';
} else {
    echo "Product not found.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Product Details | Paul's Furnitures Ngong Road</title>
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

    <link href="../../img/Asset 8.png" rel="icon">

    <!-- Custom CSS -->
    <style>
        .carousel-item img {
            max-height: 500px;
            object-fit: contain;
            width: 100%;
        }

        .product-info {
            padding: 20px;
        }

        .like-wishlist {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .like-wishlist button {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 50px;
            padding: 10px 20px;
            font-size: 1.2em;
        }

        .thumbnail {
            cursor: pointer;
            margin: 3px;
        }

        .thumbnail img {
            max-height: 100px;
            object-fit: cover;
            width: 100%;
        }

        .main-image {
            max-height: 350px;
            width: 100%;
            object-fit: contain;
            margin-left: 2px;
        }

        .thumbnails {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1px;
            width: 150px;
            max-height: 50px;
            min-height: 50px;
        }
        
        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        @media (max-width: 991.98px) {
            .thumbnails {
                margin-bottom:20px;
                display:flex;
                flex-direction:row;
                width:50%;
            }
            .thumbnail img {
                max-height: 100px;
                object-fit: cover;
                width:100%;
            }
        }
        .navbar-collapse {
                position: relative;
            }

            .wishlist-mobile {
                display: block !important;
                position: absolute;
                bottom: 10px;
                width: 100%;
                text-align: center;
            }
        }

        @media (min-width: 769px) {
            .wishlist-mobile {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
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
                        <a href="livingroom.php" class="nav-item nav-link ">Living Room</a>
                        <a href="dining.php" class="nav-item nav-link">Dining</a>
                        <a href="bedroom.php" class="nav-item nav-link">Bedroom</a>
                        <a href="fabrics.php" class="nav-item nav-link">Fabrics</a>
                        <a href="others.php" class="nav-item nav-link">Others</a>
                        <a class="btn btn-link text-white-50" href="wishlist.php">Wishlist</a>
                        
                    </div>
                    <a href="wishlist.php" class="btn btn-primary px-3 d-none d-lg-flex"><i class="bi bi-suit-heart-fill"></i>&nbsp; Wishlist</a>
                    
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <!-- Product Details Start -->
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-2 thumbnails">
                    <!-- Thumbnails -->
                    <?php
                    foreach ($images as $index => $image) {
                        echo '<div class="thumbnail">';
                        echo '<img src="admin/uploads/' . $image . '" class="img-fluid" alt="' . $name . '">';
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="col-lg-5">
                    <!-- Main Image -->
                    <img id="mainImage" src="<?php echo $main_image; ?>" class="main-image mb-4" alt="<?php echo $name; ?>">
                </div>
                <div class="col-lg-5 product-info">
                    <h1><?php echo $name; ?></h1>
                    <h2 class="text-primary">KSH <?php echo $price; ?></h2>
                    <p><?php echo $description; ?></p>
                    <p><strong>Dimensions:</strong> <?php echo $length . 'L x ' . $width . 'W x ' . $depth; ?>D Sqft</p>

                    <div class="like-wishlist">
                        <button id="likeButton" data-id="<?php echo $product_id; ?>"><i class="fas fa-thumbs-up"></i> Like</button>
                        <button id="wishlistButton" data-id="<?php echo $product_id; ?>" onclick="addToWishlist(<?php echo $product_id; ?>)"><i class="fas fa-heart"></i> Add to Wishlist</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Details End -->
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.querySelectorAll('.thumbnail img').forEach(img => {
            img.addEventListener('click', function() {
                document.getElementById('mainImage').src = this.src;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Function to set the background color based on state
            function setButtonState(button, state) {
                if (state) {
                    button.style.backgroundColor = 'orangered';
                } else {
                    button.style.backgroundColor = '';
                }
            }

            // Get buttons
            const buttons = document.querySelectorAll('.like-wishlist button');

            buttons.forEach(button => {
                const id = button.dataset.id;
                const type = button.id; // Use id to distinguish between like and wishlist buttons

                // Initialize button states from local storage
                const buttonState = localStorage.getItem(`${type}_state_${id}`) === 'true';

                // Set initial states
                setButtonState(button, buttonState);

                // Add event listener to button
                button.addEventListener('click', function() {
                    const newState = !(localStorage.getItem(`${type}_state_${id}`) === 'true');
                    localStorage.setItem(`${type}_state_${id}`, newState);
                    setButtonState(button, newState);
                });
            });
        });

        function addToWishlist(productId) {
            window.location.href = `addwishlist.php?id=${productId}`;
        }
    </script>
</body>
<!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</html>
