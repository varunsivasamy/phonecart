<?php
// Database configuration
$host = "localhost";
$dbname = "techbuzz";
$username = "root";
$password = "";

// Create DB connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get login input
$email = trim($_POST['email']);
$pass  = trim($_POST['password']);

// Query user by email
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($pass, $user['password'])) {
        // ✅ Redirect to nn.html
        header("Location: nn.html");
        exit();
    } else {
        echo "<h3>❌ Incorrect password.</h3>";
    }
} else {
    echo "<h3>❌ User not found.</h3>";
}

// Close connection
$stmt->close();
$conn->close();
?>

