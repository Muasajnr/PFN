<?php
session_start(); // Start session to store login attempts count and lockout time

// Initialize variables
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection settings
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "pfn"; 

    // Create connection using PDO
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve user information from database
        $stmt = $conn->prepare("SELECT id, name, email, password, login_attempts, last_attempt_time FROM account WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $email = $_POST['email'];
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (password_verify($_POST['password'], $user['password'])) {
                // Password is correct
                // Reset login attempts on successful login
                $login_attempts = 0;
                $last_attempt_time = null;

                // Update database with reset attempts and time
                $update_stmt = $conn->prepare("UPDATE account SET login_attempts = :login_attempts, last_attempt_time = :last_attempt_time WHERE id = :id");
                $update_stmt->bindParam(':login_attempts', $login_attempts);
                $update_stmt->bindParam(':last_attempt_time', $last_attempt_time, PDO::PARAM_INT); // Bind as integer
                $update_stmt->bindParam(':id', $user['id']);
                $update_stmt->execute();

                // Redirect to dashboard.php
                header("Location: dashboard.php");
                exit();
            } else {
                // Password is incorrect
                $login_attempts = $user['login_attempts'] + 1;
                $last_attempt_time = time(); // Current Unix timestamp

                // Update database with increased attempts and time
                $update_stmt = $conn->prepare("UPDATE account SET login_attempts = :login_attempts, last_attempt_time = :last_attempt_time WHERE id = :id");
                $update_stmt->bindParam(':login_attempts', $login_attempts);
                $update_stmt->bindParam(':last_attempt_time', $last_attempt_time, PDO::PARAM_INT); // Bind as integer
                $update_stmt->bindParam(':id', $user['id']);
                $update_stmt->execute();

                // Check if attempts exceed 3
                if ($login_attempts >= 3) {
                    // Calculate lockout time (10 minutes from last attempt)
                    $lockout_time = $user['last_attempt_time'] + 600 - time(); // Remaining lockout time in seconds

                    if ($lockout_time < 0) {
                        // Account is locked
                        $lockout_message = "Your account is locked due to too many unsuccessful login attempts. Please try again after " . gmdate("i:s", $lockout_time) . "."; // Format lockout time as minutes and seconds

                        // Display lockout message below login button
                        $error_message = '<div class="alert alert-danger" role="alert">' . $lockout_message . '</div>';
                    } else {
                        // Reset attempts if lockout time expired
                        $login_attempts = 0;
                        $last_attempt_time = null;

                        // Update database with reset attempts and time
                        $update_stmt = $conn->prepare("UPDATE account SET login_attempts = :login_attempts, last_attempt_time = :last_attempt_time WHERE id = :id");
                        $update_stmt->bindParam(':login_attempts', $login_attempts);
                        $update_stmt->bindParam(':last_attempt_time', $last_attempt_time, PDO::PARAM_INT); // Bind as integer
                        $update_stmt->bindParam(':id', $user['id']);
                        $update_stmt->execute();

                        // Display standard login error message
                        $error_message = '<div class="alert alert-danger" role="alert">Invalid email or password. Please try again.</div>';
                    }
                } else {
                    // Display standard login error message
                    $error_message = '<div class="alert alert-danger" role="alert">Invalid email or password. Please try again.</div>';
                }
            }
        } else {
            // User not found
            $error_message = '<div class="alert alert-danger" role="alert">Invalid email or password. Please try again.</div>';
        }

    } catch(PDOException $e) {
        // Handle PDO exceptions
        if (strpos($e->getMessage(), 'SQLSTATE[22007]') !== false) {
            // Invalid datetime format error
            // This could happen if the last_attempt_time is not properly handled
            // Redirect with an appropriate error message
            $error_message = '<div class="alert alert-danger" role="alert">An error occurred. Please try again later.</div>';
        } else {
            echo "Error: " . $e->getMessage();
        }
    }

    // Close connection
    $conn = null;
}
?>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | Paul's Furnitures</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/auth.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img class="brand" src="../../img/Asset 8.png" alt="logo" width="70px" height="70px">
                    </div>
                    <h6 class="mb-4 text-muted">Login to your account</h6>
                    <form action="" method="post">
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3 text-start">
                            <div class="form-check">
                                <input class="form-check-input" name="remember" type="checkbox" value="" id="check1">
                                <label class="form-check-label" for="check1">
                                    Remember me on this device
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-2 mb-4">Login</button>
                    </form>
                    <?php echo $error_message; ?>
                    <p class="mb-2 text-muted">Forgot password? <a href="forgot-password.php">Reset</a></p>
                    <p class="mb-0 text-muted">Don't have account yet? <a href="signup.php">Signup</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
