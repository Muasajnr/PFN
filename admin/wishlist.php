<?php
include 'db_connection.php';

// Fetch wishlist data
$sql = "SELECT * FROM wishlist";
$result = $conn->query($sql);
$wishlist_data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wishlist_data[] = $row;
    }
}

$conn->close();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Wishlist | Paul's Furnitures</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <link href="../../img/Asset 8.png" rel="icon">
    <style>
        .search-bar {
            margin-bottom: 20px;
        }
        .wishlist-table th {
            cursor: pointer;
        }
        .wishlist-table img {
            max-width: 100px;
        }
        @media (max-width: 768px) {
            .wishlist-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="../../img/Asset 8.png" alt="PFN logo" class="app-logo" width="50px" height="50px">
            </div>
            <ul class="list-unstyled components text-secondary">
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="wishlist.php"><i class="fas fa-heart"></i> Wishlist</a></li>
                <li><a href="products.php"><i class="fas fa-table"></i> Products</a></li>
                <li><a href="visitors.php"><i class="fas fa-chart-bar"></i> Visitors</a></li>
                <li><a href="addproduct.php" style="color:red;"><i class="fa fa-plus"></i> ADD PRODUCT</a></li>
            </ul>
        </nav>
        <div id="body" class="active">
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
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>All Wishlists</h3>
                        
                    </div>
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="search-bar">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search..." onkeyup="filterTable()">
                            </div>
                            <div class="table-responsive">
                                <table width="100%" class="table table-hover wishlist-table" id="wishlistTable">
                                    <thead>
                                        <tr>
                                            <th onclick="sortTable(0)">#</th>
                                            <th onclick="sortTable(1)">Name</th>
                                            <th onclick="sortTable(2)">Images</th>
                                            <th onclick="sortTable(3)">Price</th>
                                            <th onclick="sortTable(4)">Description</th>
                                            <th onclick="sortTable(5)">Category</th>
                                            <th onclick="sortTable(6)">Length</th>
                                            <th onclick="sortTable(7)">Width</th>
                                            <th onclick="sortTable(8)">Depth</th>
                                            <th onclick="sortTable(9)">Device Name</th>
                                            <th onclick="sortTable(10)">Device Brand</th>
                                            <th onclick="sortTable(11)">Device ID</th>
                                            <th onclick="sortTable(12)">Country</th>
                                            <th onclick="sortTable(13)">Town</th>
                                            <th onclick="sortTable(14)">Timestamp</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $count = 1; foreach ($wishlist_data as $item): ?>
                                            <tr>
                                                <td><?php echo $count++; ?></td>
                                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                                <td>
                                                    <?php 
                                                        $images = json_decode($item['images'], true);
                                                        if ($images) {
                                                            foreach ($images as $image) {
                                                                echo "<img max-height='20px' src='uploads/" . htmlspecialchars($image) . "' alt='Product Image' />";
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
                                                <td><?php echo htmlspecialchars($item['device_name']); ?></td>
                                                <td><?php echo htmlspecialchars($item['device_brand']); ?></td>
                                                <td><?php echo htmlspecialchars($item['deviceID']); ?></td>
                                                <td><?php echo htmlspecialchars($item['country']); ?></td>
                                                <td><?php echo htmlspecialchars($item['town']); ?></td>
                                                <td><?php echo htmlspecialchars($item['timestamp']); ?></td>
                                                <td><a href="delete_wishlist_item.php?id=<?php echo htmlspecialchars($item['id']); ?>" class="btn btn-outline-danger btn-rounded"><i class="fas fa-trash"></i></a></td>
                                            </tr>
                                        <?php endforeach; ?>
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

</html>
