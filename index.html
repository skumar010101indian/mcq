<?php
session_start();

// Define admin credentials
$admin_username = "mapswithnaveen";
$admin_password = "Naveen@maps";

// Check if the admin is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Admin is logged in, display the admin dashboard
    $admin_name = $_SESSION['username'];
} else {
    // Process the login form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate credentials
        if ($username === $admin_username && $password === $admin_password) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $admin_username;
            $admin_name = $admin_username; // Set admin name for display
        } else {
            $error_message = "Invalid ID or Password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="index_style.css"> <!-- Optional: link to your CSS -->
</head>
<body>
    <div class="navbar">
        <?php if (isset($admin_name)): ?>
            <span style="color: green;">Welcome, <?php echo htmlspecialchars($admin_name); ?>!</span>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <span><center>Admin Login</center></span>
        <?php endif; ?>
    </div>

    <div class="container">
        <div class="login-container">
            <?php if (!isset($admin_name)): ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="username">ID:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <input type="submit" value="Login">
                </form>
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
            <?php else: ?>
                <h2>Admin Dashboard</h2>
                <button onclick="location.href='create_pdf.php'">PDF CREATE</button>
                <button onclick="location.href='admin192837465.php'">CREATE QUESTIONS</button>
                <button onclick="location.href='test.php'">TRIAL FOR TEST</button>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
