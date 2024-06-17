<?php
include 'db_connection.php';

// Initialize filter variables
$item_no_filter = isset($_GET['item_no']) ? $_GET['item_no'] : '';
$literature_type_filter = isset($_GET['literature_type']) ? $_GET['literature_type'] : '';

// Query to select items with filters
$sql = "SELECT item_id, item_no, item_name, literature_type, current_stock 
        FROM Items 
        WHERE (item_no LIKE '%$item_no_filter%' AND literature_type LIKE '%$literature_type_filter%')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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

<h2>Items List</h2>

<div class="filter-container">
    <form action="view_items.php" method="GET">
        <label for="item_no">Item No:</label>
        <input type="text" id="item_no" name="item_no" value="<?php echo $item_no_filter; ?>">

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
        <th>Item ID</th>
        <th>Item No</th>
        <th>Item Name</th>
        <th>Literature Type</th>
        <th>Current Stock</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        // Output data for each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["item_id"] . "</td>";
            echo "<td>" . $row["item_no"] . "</td>";
            echo "<td>" . $row["item_name"] . "</td>";
            echo "<td>" . $row["literature_type"] . "</td>";
            echo "<td>" . $row["current_stock"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No items found</td></tr>";
    }
    ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
