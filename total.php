<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Table and Display Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Table and Display Data</h2>
        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="table_name">Select Table:</label>
                <select id="table_name" name="table_name">
                    <option value="books">Books</option>
                    <option value="brochures">Brochures</option>
                    <option value="public_magazines">Public Magazines</option>
                    <option value="teaching_toolbox">Teaching Toolbox</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Display Data</button>
            </div>
        </form>

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

        // Initialize variables
        $table_name = ""; // Initialize table name variable

        // Check if table_name parameter is set in URL and validate it against allowed tables
        $allowed_tables = array("books", "brochures", "public_magazines", "teaching_toolbox");

        if (isset($_GET['table_name']) && in_array($_GET['table_name'], $allowed_tables)) {
            $table_name = $_GET['table_name'];
        } else {
            // Default to books table if no or invalid table_name provided
            $table_name = "books";
        }

        // Query to fetch data from specified table
        $sql = "SELECT item_id, item_name, currently_in_hand FROM $table_name";
        $result = $conn->query($sql);

        // Close connection
        $conn->close();
        ?>

        <h3><?php echo ucfirst($table_name); ?> Table</h3>
        <table>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Currently in Hand</th>
            </tr>
            <?php
            // Iterate through the fetched data and display each row
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["item_id"] . "</td>";
                    echo "<td>" . $row["item_name"] . "</td>";
                    echo "<td>" . $row["currently_in_hand"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No records found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
