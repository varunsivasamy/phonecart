<?php
// Database configuration
$host = "localhost";     // Change this if needed
$dbname = "techbuzz";    // Your database name
$username = "root";      // Your MySQL username
$password = "";          // Your MySQL password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize POST data
$name     = trim($_POST['name']);
$email    = trim($_POST['email']);
$pass     = trim($_POST['password']);
$phone    = trim($_POST['phone']);

// Basic validation
if (empty($name) || empty($email) || empty($pass) || empty($phone)) {
    die("All fields are required.");
}

// Hash the password for security
$hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

// Prepare SQL query to insert data
$stmt = $conn->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashedPassword, $phone);

// Execute the query
if ($stmt->execute()) {
    echo "<h2>Registration successful! 🎉</h2>";
    echo "<p><a href='login.html'>Click here to login</a></p>";
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>