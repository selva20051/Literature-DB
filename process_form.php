<?php
include 'db_connection.php';

// Get form data
$item_no = $_POST['item_no'];
$item_name = $_POST['item_name'];
$transaction_type = $_POST['table_name'];
$transaction_amount = $_POST['transaction_amount'];
$literature_type = $_POST['literature_type'];
$transaction_month = $_POST['month'];

// Check if item exists in Items table
$sql = "SELECT item_id, current_stock FROM Items WHERE item_no = '$item_no' AND item_name = '$item_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $item_id = $row['item_id'];
    $current_stock = $row['current_stock'];

    // Update current stock
    if ($transaction_type == 'IN') {
        $new_stock = $current_stock + $transaction_amount;
    } else {
        $new_stock = $current_stock - $transaction_amount;
    }

    $sql_update_stock = "UPDATE Items SET current_stock = $new_stock WHERE item_id = $item_id";
    $conn->query($sql_update_stock);

    // Insert transaction record
    $sql_insert_transaction = "INSERT INTO Transactions (item_id, item_name, transaction_type, transaction_amount, literature_type, transaction_month)
                               VALUES ($item_id, '$item_name', '$transaction_type', $transaction_amount, '$literature_type', '$transaction_month')";
    if ($conn->query($sql_insert_transaction) === TRUE) {
        header("Location: index.html");
    } else {
        echo "Error: " . $sql_insert_transaction . "<br>" . $conn->error;
    }
} else {
    echo "Item not found in the database.";
}

$conn->close();
?>
