
<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";  // No password for the root user
$dbname = "sqlproject";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$loginStatus = ""; // Initialize the login status variable


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];


    // Vulnerable to SQL injection (for educational purposes)
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    die($sql);


    $result = $conn->query($sql);


    if (!$result) {
        die("Query failed: " . $conn->error);
    }




    if ($result && $result->num_rows > 0) {
        $_SESSION['login_success'] = true;
        header("Location: dashboard.html"); // Redirect to the dashboard
        exit();
    } else {
        $loginStatus = "Login failed! Invalid credentials.";
    }
}


$conn->close();
?>


<!-- login.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Project</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to a common stylesheet -->
</head>
<body>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
        <?php if (!empty($loginStatus)): ?>
            <p><?php echo $loginStatus; ?></p>
        <?php endif; ?>
    </form>
</body>
</html>
