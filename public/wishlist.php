<?php
session_start();
include 'db/db_connection.php';

// Function to get client IP address
function get_client_ip() {
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Function to generate a unique device identifier
function getDeviceIdentifier() {
    // Try to retrieve a previously set identifier from cookie or session
    $device_id = isset($_COOKIE['device_id']) ? $_COOKIE['device_id'] : '';

    if (empty($device_id)) {
        // Generate a new unique identifier based on user agent and IP address
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $ip = get_client_ip();

        // Create a device identifier based on user agent and IP
        $device_id = md5($user_agent . $ip);

        // Set the identifier as a cookie (adjust expiration as needed)
        setcookie('device_id', $device_id, time() + (86400 * 30), '/'); // 30 days expiration

        // Optionally, store in session for server-side tracking (if needed)
        $_SESSION['device_id'] = $device_id;
    }

    return $device_id;
}

// Get the current device ID
$currentDeviceID = getDeviceIdentifier();

// Fetch wishlist data only for the current device
$sql = "SELECT * FROM wishlist WHERE deviceID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentDeviceID);
$stmt->execute();
$result = $stmt->get_result();
$wishlist_data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wishlist_data[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Wishlist | Paul's Furnitures Ngong Road</title>
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
    <!-- Favicon -->
    <link href="admin/img/Asset 8.png" rel="icon">

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


    <style>
        .search-container {
            margin: 20px 0;
        }

        .wishlist-table {
            width: 100%;
            border-collapse: collapse;
        }

        .wishlist-table th, .wishlist-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .wishlist-table th {
            cursor: pointer;
        }

        .wishlist-table th.sort-asc:after {
            content: " ▲";
        }

        .wishlist-table th.sort-desc:after {
            content: " ▼";
        }

        @media (max-width: 768px) {
            .wishlist-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
        .navbar-collapse {
                position: relative;
            }

            #wishlist-mobile {
                display: block !important;
                position: absolute;
                bottom: 10px;
                width: 100%;
                text-align: center;
            }
        }

        @media (min-width: 769px) {
            #wishlist-mobile {
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
                        <a href="livingroom.php" class="nav-item nav-link">Living Room</a>
                        <a href="dining.php" class="nav-item nav-link">Dinning</a>
                        <a href="bedroom.php" class="nav-item nav-link">Bedroom</a>
                        <a href="fabrics.php" class="nav-item nav-link">Fabrics</a>
                        <a href="others.php" class="nav-item nav-link">Others</a>
                        
                    </div>
                    <a href="wishlist.php" id=" wishlist-mobile" class="btn btn-primary px-3 d-none d-lg-flex"><i class="bi bi-suit-heart-fill"></i>&nbsp; Wishlist</a>
                   
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <!-- Wishlist Table Start -->
        <div class="container my-5">
            <div class="search-container">
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for products.." class="form-control">
            </div>
            <table class="wishlist-table" id="wishlistTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">Product ID</th>
                        <th onclick="sortTable(1)">Name</th>
                        <th onclick="sortTable(2)">Images</th>
                        <th onclick="sortTable(3)">Price</th>
                        <th onclick="sortTable(4)">Description</th>
                        <th onclick="sortTable(5)">Category</th>
                        <th onclick="sortTable(6)">Length</th>
                        <th onclick="sortTable(7)">Width</th>
                        <th onclick="sortTable(8)">Depth</th>
                        <th onclick="sortTable(9)">Timestamp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                   <?php
                    $count=0;
                    ?>
                    <?php foreach ($wishlist_data as $item): ?>
                    <tr>
                    <?php  $count++;
                        ?>
                        <td><?php echo $count; ?></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>
                                                   <?php 
$images = json_decode($item['images'], true);
if ($images) {
    foreach ($images as $image) {
        echo "<img style='max-height: 50px; width: auto;' src='admin/uploads/" . htmlspecialchars($image) . "' alt='ProductImage' />";
    }
}
?>

                                                </td>
                        <td><?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['description']); ?></td>
                        <td><?php echo htmlspecialchars($item['category']); ?></td>
                        <td><?php echo htmlspecialchars($item['length']); ?></td>
                        <td><?php echo htmlspecialchars($item['width']); ?></td>
                        <td><?php echo htmlspecialchars($item['depth']); ?></td>
                        <td><?php echo htmlspecialchars($item['timestamp']); ?></td>
                        <td><a href='deletewishlist.php?id=<?php echo $item['id']; ?>' class='btn btn-outline-danger btn-rounded'><i class='fas fa-trash'></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Wishlist Table End -->
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        function filterTable() {
            const searchInput = document.getElementById('searchInput');
            const filter = searchInput.value.toLowerCase();
            const table = document.getElementById('wishlistTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let visible = false;
                const cols = rows[i].getElementsByTagName('td');
                for (let j = 0; j < cols.length; j++) {
                    if (cols[j] && cols[j].textContent.toLowerCase().indexOf(filter) > -1) {
                        visible = true;
                        break;
                    }
                }
                rows[i].style.display = visible ? '' : 'none';
            }
        }

        function sortTable(n) {
            const table = document.getElementById('wishlistTable');
            const rows = Array.from(table.rows).slice(1);
            const isAscending = table.rows[0].cells[n].classList.toggle('sort-asc', !table.rows[0].cells[n].classList.contains('sort-asc'));

            rows.sort((rowA, rowB) => {
                const cellA = rowA.cells[n].innerText;
                const cellB = rowB.cells[n].innerText;

                if (isAscending) {
                    return cellA.localeCompare(cellB, undefined, { numeric: true });
                } else {
                    return cellB.localeCompare(cellA, undefined, { numeric: true });
                }
            });

            rows.forEach(row => table.appendChild(row));

            Array.from(table.rows[0].cells).forEach(cell => {
                cell.classList.remove('sort-asc', 'sort-desc');
            });
            table.rows[0].cells[n].classList.toggle('sort-desc', !isAscending);
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