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

// Example transaction data (replace with actual POST data handling)
$item_name = $_POST['item_name'];
$transaction_type = $_POST['transaction_type'];
$transaction_amount = $_POST['transaction_amount'];
$table_name = $_POST['table_name'];
$month = $_POST['month'];

// Verify that all required POST data is present
if (!isset($item_name, $transaction_type, $transaction_amount, $table_name, $month)) {
    die("Missing required POST data.");
}

// Prepare and execute query to get item_id from the appropriate table
$stmt = $conn->prepare("SELECT item_id FROM $table_name WHERE item_name = ?");
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("s", $item_name);
$stmt_executed = $stmt->execute();

if (!$stmt_executed) {
    die("Error executing query: " . $stmt->error);
}

// Bind result variables
$stmt->bind_result($item_id);

// Fetch item_id
if ($stmt->fetch()) {
    // Close statement
    $stmt->close();

    // Determine sign for transaction amount based on transaction type
    $transaction_sign = ($transaction_type == 'IN') ? 1 : -1;
    $adjusted_amount = $transaction_sign * $transaction_amount;

    // Insert transaction record
    $insert_stmt = $conn->prepare("INSERT INTO transactions (item_id, item_name, transaction_table, transaction_type, transaction_amount, `month`)
                                  VALUES (?, ?, ?, ?, ?, ?)");
    if (!$insert_stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $insert_stmt->bind_param("isssis", $item_id, $item_name, $table_name, $transaction_type, $adjusted_amount, $month);
    $insert_executed = $insert_stmt->execute();

    if ($insert_executed) {
        echo "Transaction recorded successfully.<br>";

        // Update currently_in_hand based on transactions for the specific table
        $update_sql = "UPDATE $table_name AS t
                       SET t.currently_in_hand = (
                           SELECT COALESCE(SUM(tr.transaction_amount), 0)
                           FROM transactions tr
                           WHERE tr.item_id = t.item_id AND tr.transaction_table = ? AND tr.`month` = ?
                       )";
        $update_stmt = $conn->prepare($update_sql);
        if (!$update_stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters for update statement
        $update_stmt->bind_param("ss", $table_name, $month);
        $update_executed = $update_stmt->execute();

        if ($update_executed) {
            echo "currently_in_hand updated successfully for $table_name in $month.<br>";
        } else {
            echo "Error updating currently_in_hand: " . $conn->error . "<br>";
        }

        $update_stmt->close();
    } else {
        echo "Error recording transaction: " . $insert_stmt->error . "<br>";
    }

    $insert_stmt->close();
} else {
    echo "Item with item_name = $item_name not found in the $table_name table.<br>";
}

// Close connection
$conn->close();
?>