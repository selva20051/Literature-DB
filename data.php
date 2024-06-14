<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "system";
$dbname = "literature";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected filters from the form
$selected_month = isset($_GET['month']) ? $_GET['month'] : '';
$selected_table = isset($_GET['transaction_table']) ? $_GET['transaction_table'] : '';
$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : '';

// Build the SQL query with filters
$sql = "SELECT transaction_id, item_id, item_name, transaction_table, transaction_type, transaction_amount, transaction_time, month FROM transactions WHERE 1=1";

if ($selected_month) {
    $sql .= " AND month = '$selected_month'";
}

if ($selected_table) {
    $sql .= " AND transaction_table = '$selected_table'";
}

if ($item_id) {
    $sql .= " AND item_id = $item_id";
}

$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

<h2>Transaction Data</h2>

<form method="get" action="">
    <label for="month">Filter by Month:</label>
    <select name="month" id="month">
        <option value="">Select Month</option>
        <option value="January" <?php if ($selected_month == 'January') echo 'selected'; ?>>January</option>
        <option value="February" <?php if ($selected_month == 'February') echo 'selected'; ?>>February</option>
        <option value="March" <?php if ($selected_month == 'March') echo 'selected'; ?>>March</option>
        <option value="April" <?php if ($selected_month == 'April') echo 'selected'; ?>>April</option>
        <option value="May" <?php if ($selected_month == 'May') echo 'selected'; ?>>May</option>
        <option value="June" <?php if ($selected_month == 'June') echo 'selected'; ?>>June</option>
        <option value="July" <?php if ($selected_month == 'July') echo 'selected'; ?>>July</option>
        <option value="August" <?php if ($selected_month == 'August') echo 'selected'; ?>>August</option>
        <option value="September" <?php if ($selected_month == 'September') echo 'selected'; ?>>September</option>
        <option value="October" <?php if ($selected_month == 'October') echo 'selected'; ?>>October</option>
        <option value="November" <?php if ($selected_month == 'November') echo 'selected'; ?>>November</option>
        <option value="December" <?php if ($selected_month == 'December') echo 'selected'; ?>>December</option>
    </select>
    <label for="transaction_table">Filter by Table:</label>
    <select name="transaction_table" id="transaction_table">
        <option value="">Select Table</option>
        <option value="books" <?php if ($selected_table == 'books') echo 'selected'; ?>>Books</option>
        <option value="teaching_toolbox" <?php if ($selected_table == 'teaching_toolbox') echo 'selected'; ?>>Teaching Toolbox</option>
        <option value="brochures" <?php if ($selected_table == 'brochures') echo 'selected'; ?>>Brochures</option>
        <option value="public_magazines" <?php if ($selected_table == 'public_magazines') echo 'selected'; ?>>Public Magazines</option>
    </select>
    <label for="item_id">Filter by Item ID:</label>
    <input type="number" name="item_id" id="item_id" value="<?php echo htmlspecialchars($item_id); ?>">
    <input type="submit" value="Filter">
</form>

<table>
    <tr>
        <th>Transaction ID</th>
        <th>Item ID</th>
        <th>Item Name</th>
        <th>Transaction Table</th>
        <th>Transaction Type</th>
        <th>Transaction Amount</th>
        <th>Transaction Time</th>
        <th>Month</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["transaction_id"] . "</td>";
            echo "<td>" . $row["item_id"] . "</td>";
            echo "<td>" . $row["item_name"] . "</td>";
            echo "<td>" . $row["transaction_table"] . "</td>";
            echo "<td>" . $row["transaction_type"] . "</td>";
            echo "<td>" . $row["transaction_amount"] . "</td>";
            echo "<td>" . $row["transaction_time"] . "</td>";
            echo "<td>" . $row["month"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No results found</td></tr>";
    }
    $conn->close();
    ?>

</table>

</body>
</html>
