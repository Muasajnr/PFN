<?php
session_start(); // Start session for storing error messages

$error_message = ""; // Initialize error message variable

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

        // Prepare SQL statement to check if email already exists
        $check_stmt = $conn->prepare("SELECT id FROM account WHERE email = :email");
        $check_stmt->bindParam(':email', $email);
        $email = $_POST['email'];
        $check_stmt->execute();
        $existing_user = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing_user) {
            // Email already exists
            $error_message = "Email address is already taken. Please choose a different email.";
        } else {
            // Prepare SQL statement to insert data
            $stmt = $conn->prepare("INSERT INTO account (name, email, password) VALUES (:name, :email, :password)");

            // Bind parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password_hash); // Use password_hash() for storing passwords securely

            // Set parameters from form inputs
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Check if passwords match
            if ($password !== $confirm_password) {
                throw new Exception("Passwords do not match.");
            }

            // Hash the password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Execute the prepared statement
            $stmt->execute();

            // Display success message or redirect to another page
            $_SESSION['success_message'] = "Registration successful!";
            header("Location: index.php");
            exit();
        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    } catch(Exception $e) {
        $error_message = $e->getMessage();
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
    <title>Sign up | Paul's Furnitures</title>
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
                    <h6 class="mb-4 text-muted">Create new account</h6>
                    <form action="signup.php" method="post">
                        <div class="mb-3 text-start">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                        </div>
                        <div class="mb-3 text-start">
                            <div class="form-check">
                                <input class="form-check-input" name="confirm" type="checkbox" value="" id="check1" required>
                                <label class="form-check-label" for="check1">
                                    I agree to the <a href="#" tabindex="-1">terms and policy</a>.
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary shadow-2 mb-4">Register</button>
                    </form>
                    
                    <?php if (!empty($error_message)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>

                    <p class="mb-0 text-muted">Already have an account? <a href="login.php">Log in</a></p>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
