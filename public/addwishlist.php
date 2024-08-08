<?php
// Include database connection
include 'db/db_connection.php';

// Initialize variables for product details
$product_id = $name = $price = $description = $category = $length = $width = $depth = '';

// Function to get client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    elseif(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    elseif(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    elseif(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    elseif(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
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

// Function to get device name and brand based on user agent
function getDeviceInfo() {
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $device_name = 'Unknown Device';
    $device_brand = 'Unknown Brand';

    if (preg_match('/iPhone/i', $user_agent)) {
        $device_name = 'iPhone';
        $device_brand = 'Apple';
    } elseif (preg_match('/iPad/i', $user_agent)) {
        $device_name = 'iPad';
        $device_brand = 'Apple';
    } elseif (preg_match('/Android/i', $user_agent)) {
        $device_name = 'Android';
        if (preg_match('/Samsung/i', $user_agent)) {
            $device_brand = 'Samsung';
        } elseif (preg_match('/Huawei/i', $user_agent)) {
            $device_brand = 'Huawei';
        } elseif (preg_match('/Xiaomi/i', $user_agent)) {
            $device_brand = 'Xiaomi';
        }
    } elseif (preg_match('/Windows Phone/i', $user_agent)) {
        $device_name = 'Windows Phone';
        $device_brand = 'Microsoft';
    } elseif (preg_match('/Windows NT/i', $user_agent)) {
        $device_name = 'Windows';
        $device_brand = 'Microsoft';
    } elseif (preg_match('/Macintosh/i', $user_agent)) {
        $device_name = 'Macintosh';
        $device_brand = 'Apple';
    } elseif (preg_match('/Linux/i', $user_agent)) {
        $device_name = 'Linux';
    }

    return ['name' => $device_name, 'brand' => $device_brand];
}

// Function to get location information (country and town) based on IP address
function getLocationInfo() {
    $ip = $_SERVER['REMOTE_ADDR'];

    // Use IP-API to get location information
    $url = "http://ip-api.com/json/{$ip}";
    $response = @file_get_contents($url);

    if ($response !== false) {
        $data = json_decode($response, true);

        if (isset($data['status']) && $data['status'] === 'success') {
            $country = $data['country'] ?? 'Kenya';
            $town = $data['city'] ?? 'Nairobi';
        } else {
            $country = 'Kenya'; // Default country
            $town = 'Nairobi'; // Default town
        }
    } else {
        $country = 'Unknown Country';
        $town = 'Unknown Town';
    }

    return ['country' => $country, 'town' => $town];
}

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
    $category = $row['category'];
    $length = $row['length'];
    $width = $row['width'];
    $depth = $row['depth'];
    $images = json_decode($row['images'], true);
} else {
    echo "Product not found.";
    echo '<script>setTimeout(function(){ window.location.href = document.referrer; }, 400);</script>';
    exit;
}

$conn->close();

// Capture automatic fields
$device_info = getDeviceInfo();
$location_info = getLocationInfo();
$timestamp = date('Y-m-d H:i:s');

// Check if wishlist entry already exists for the current device
include 'db/db_connection.php';

$device_id = getDeviceIdentifier();

$sql_check = "SELECT * FROM wishlist WHERE product_id = '$product_id' AND deviceID = '$device_id'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows > 0) {
    // Wishlist already exists for this device
    echo "Wishlist already exists.";
    echo '<script>setTimeout(function(){ window.location.href = document.referrer; }, 400);</script>';
    exit;
} else {
    // Wishlist does not exist, proceed with insertion
    $conn->close();
    include 'db/db_connection.php';

    // Escape variables to prevent SQL injection
    $product_id = mysqli_real_escape_string($conn, $product_id);
    $name = mysqli_real_escape_string($conn, $name);
    $price = mysqli_real_escape_string($conn, $price);
    $description = mysqli_real_escape_string($conn, $description);
    $category = mysqli_real_escape_string($conn, $category);
    $length = mysqli_real_escape_string($conn, $length);
    $width = mysqli_real_escape_string($conn, $width);
    $depth = mysqli_real_escape_string($conn, $depth);
    $device_name = mysqli_real_escape_string($conn, $device_info['name']);
    $device_brand = mysqli_real_escape_string($conn, $device_info['brand']);
    $country = mysqli_real_escape_string($conn, $location_info['country']);
    $town = mysqli_real_escape_string($conn, $location_info['town']);
    $deviceID = mysqli_real_escape_string($conn, $device_id);

    // Insert into wishlist table
    $sql_insert = "INSERT INTO wishlist (product_id, name, price, description, category, images, length, width, depth, device_name, device_brand, deviceID, country, town, timestamp) 
        VALUES ('$product_id', '$name', '$price', '$description', '$category', '" . mysqli_real_escape_string($conn, json_encode($images)) . "', '$length', '$width', '$depth', '$device_name', '$device_brand', '$deviceID', '$country', '$town', '$timestamp')";

    if ($conn->query($sql_insert) === TRUE) {
        // Close the database connection
        $conn->close();

        // Redirect back to the previous page or show success message
        echo "Wishlist successfully added.";
        echo '<script>setTimeout(function(){ window.location.href = document.referrer; }, 400);</script>';
        exit;
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
        echo '<script>setTimeout(function(){ window.location.href = document.referrer; }, 400);</script>';
        $conn->close();
    }
}
?>
