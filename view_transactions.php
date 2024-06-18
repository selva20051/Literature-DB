<?php
include 'db_connection.php';

// Initialize filter variables
$item_id_filter = isset($_GET['item_id']) ? $_GET['item_id'] : '';
$transaction_month_filter = isset($_GET['transaction_month']) ? $_GET['transaction_month'] : '';
$literature_type_filter = isset($_GET['literature_type']) ? $_GET['literature_type'] : '';

// Query to select all transactions with filters
$sql = "SELECT transaction_id, item_id, item_name, transaction_type, transaction_amount, literature_type, transaction_month, transaction_time 
        FROM Transactions 
        WHERE (item_id LIKE '%$item_id_filter%' AND transaction_month LIKE '%$transaction_month_filter%' AND literature_type LIKE '%$literature_type_filter%')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
        }
        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
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
        th {
            background-color: #f2f2f2;
        }
        .filter-container {
            margin-bottom: 20px;
        }
        .filter-container label, .filter-container input, .filter-container select {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="insert.php">Insert</a>
    <a href="index.html">Inventory Transaction</a>
    <a href="view_transactions.php">Transactions</a>
    <a href="view_items.php">Stock</a>
</div>

<h2>Transaction Records</h2>

<div class="filter-container">
    <form action="view_transactions.php" method="GET">
        <label for="item_id">Item ID:</label>
        <input type="text" id="item_id" name="item_id" value="<?php echo $item_id_filter; ?>">

        <label for="transaction_month">Transaction Month:</label>
        <select id="transaction_month" name="transaction_month">
            <option value="">All</option>
            <option value="January" <?php if ($transaction_month_filter == 'January') echo 'selected'; ?>>January</option>
            <option value="February" <?php if ($transaction_month_filter == 'February') echo 'selected'; ?>>February</option>
            <option value="March" <?php if ($transaction_month_filter == 'March') echo 'selected'; ?>>March</option>
            <option value="April" <?php if ($transaction_month_filter == 'April') echo 'selected'; ?>>April</option>
            <option value="May" <?php if ($transaction_month_filter == 'May') echo 'selected'; ?>>May</option>
            <option value="June" <?php if ($transaction_month_filter == 'June') echo 'selected'; ?>>June</option>
            <option value="July" <?php if ($transaction_month_filter == 'July') echo 'selected'; ?>>July</option>
            <option value="August" <?php if ($transaction_month_filter == 'August') echo 'selected'; ?>>August</option>
            <option value="September" <?php if ($transaction_month_filter == 'September') echo 'selected'; ?>>September</option>
            <option value="October" <?php if ($transaction_month_filter == 'October') echo 'selected'; ?>>October</option>
            <option value="November" <?php if ($transaction_month_filter == 'November') echo 'selected'; ?>>November</option>
            <option value="December" <?php if ($transaction_month_filter == 'December') echo 'selected'; ?>>December</option>
        </select>

        <label for="literature_type">Literature Type:</label>
        <select id="literature_type" name="literature_type">
            <option value="">All</option>
            <option value="books" <?php if ($literature_type_filter == 'books') echo 'selected'; ?>>Books</option>
            <option value="toolbox" <?php if ($literature_type_filter == 'toolbox') echo 'selected'; ?>>Teaching Toolbox</option>
            <option value="brochures" <?php if ($literature_type_filter == 'brochures') echo 'selected'; ?>>Brochures</option>
            <option value="magazines" <?php if ($literature_type_filter == 'magazines') echo 'selected'; ?>>Public Magazines</option>
        </select>

        <input type="submit" value="Filter">
    </form>
</div>

<table>
    <tr>
        <th>Transaction ID</th>
        <th>Item ID</th>
        <th>Item Name</th>
        <th>Literature Type</th>
        <th>IN/OUT</th>
        <th>Amount</th>
        <th>Month</th>
        <th>Time</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data for each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["transaction_id"] . "</td>";
            echo "<td>" . $row["item_id"] . "</td>";
            echo "<td>" . $row["item_name"] . "</td>";
            echo "<td>" . $row["literature_type"] . "</td>";
            echo "<td>" . $row["transaction_type"] . "</td>";
            echo "<td>" . $row["transaction_amount"] . "</td>";
            echo "<td>" . $row["transaction_month"] . "</td>";
            echo "<td>" . $row["transaction_time"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No transactions found</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
