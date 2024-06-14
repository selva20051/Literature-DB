<?php
// Database connection parameters
$servername = "localhost"; // Replace with your MySQL server address
$username = "root"; // Replace with your MySQL username
$password = "system"; // Replace with your MySQL password
$dbname = "literature"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$item_id = $_POST['item_id'];
$item_name = $_POST['item_name'];
$currently_in_hand = $_POST['currently_in_hand'];
$table_name = $_POST['table_name'];

// Prepare SQL statement
$sql = "INSERT INTO $table_name (item_id, item_name, currently_in_hand) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $item_id, $item_name, $currently_in_hand);

// Execute SQL statement
if ($stmt->execute()) {
    echo "New record inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();
?>
