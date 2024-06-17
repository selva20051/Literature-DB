<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Item</title>
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
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 15px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <!-- Include jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>

<div class="navbar">
    <a href="insert.php">Insert</a>
    <a href="index.html">Inventory Transaction</a>
    <a href="view_transactions.php">Transactions</a>
    <a href="view_items.php">Stock</a>
</div>

<h2>Insert New Item</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db_connection.php';

    // Get form data
    $item_no = $_POST['item_no'];
    $item_name = $_POST['item_name'];
    $literature_type = $_POST['literature_type'];
    $current_stock = $_POST['current_stock'];

    // Insert item into the Items table
    $sql_insert_item = "INSERT INTO Items (item_no, item_name, literature_type, current_stock) 
                        VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert_item);
    $stmt->bind_param("sssd", $item_no, $item_name, $literature_type, $current_stock);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>New item inserted successfully</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<form action="" method="POST">
    <label for="item_no">Item Number:</label>
    <input type="text" id="item_no" name="item_no" required>

    <label for="item_name">Item Name:</label>
    <input type="text" id="item_name" name="item_name" required>

    <label for="literature_type">Literature Type:</label>
    <select id="literature_type" name="literature_type" required>
        <option value="books">Books</option>
        <option value="toolbox">Teaching Toolbox</option>
        <option value="brochures">Brochures</option>
        <option value="magazines">Public Magazines</option>
    </select>

    <label for="current_stock">Current Stock:</label>
    <input type="number" id="current_stock" name="current_stock" required>

    <input type="submit" value="Insert Item">
</form>

<script>
    $(document).ready(function() { 
        var items = [ 
            "Invitation to congregation meetings inv",
            "Contact card (picture of open Bible) jwcd1",
            "Contact card (jw.org logo only) jwcd4",
            "Contact card (in-person Bible course) jwcd9",
            "Contact card (virtual Bible course) jwcd10",
            "Enjoy Life Forever! book lff",
            "Enjoy Life Forever! brochure lffi",
            "Listen and Live ll",
            "View the Bible T-30",
            "View the Future T-31",
            "Happy Family Life T-32",
            "Who Controls the World? T-33",
            "Will Suffering End? T-34",
            "Live Again T-35",
            "Kingdom T-36",
            "Website tract T-37",
            "Ministry School be",
            "Teach Us bhs",
            "Bearing Witness bt",
            "\"My Follower\" cf",
            "Close to Jehovah cl",
            "Family Happiness fy",
            "Imitate ia",
            "Isaiah’s Prophecy I ip-1",
            "Isaiah’s Prophecy II ip-2",
            "Jeremiah jr",
            "Jesus—The Way jy",
            "God’s Kingdom Rules! kr",
            "Learn From the Bible lfb",
            "Teacher lr",
            "Remain in God’s Love lvs",
            "Organized od",
            "Pure Worship rr",
            "\"Sing Out Joyfully\" sjj",
            "\"Sing Out Joyfully\" (large size) sjjls",
            "\"Sing Out Joyfully\"—Lyrics Only sjjyls",
            "Young People Ask, Volume 1 yp1",
            "Young People Ask, Volume 2 yp2",
            "Reading and Writing ay",
            "Bible’s Message bm",
            "Education ed",
            "Good News fg",
            "God’s Friend gf",
            "Happy Family hf",
            "Happy Life hl",
            "Jehovah’s Will jl",
            "Satisfying Life la",
            "Was Life Created? lc",
            "Listen to God ld",
            "Origin of Life lf",
            "My Bible Lessons mb",
            "Road to Life ol",
            "Lasting Peace pc",
            "Pathway ph",
            "Return to Jehovah rj",
            "Real Faith rk",
            "Spirits of the Dead sp",
            "Teaching th",
            "Wisdom From the Gospels wfg",
            "Why Worship God wj",
            "Teach Your Children yc",
            "10 Questions ypq",
            "Awake! No. 1 2018 g18.1",
            "Awake! No. 2 2018 g18.2",
            "Awake! No. 3 2018 g18.3",
            "Awake! No. 1 2019 g19.1",
            "Awake! No. 2 2019 g19.2",
            "Awake! No. 3 2019 g19.3",
            "Awake! No. 1 2020 g20.1",
            "Awake! No. 2 2020 g20.2",
            "Awake! No. 3 2020 g20.3",
            "Awake! No. 1 2021 g21.1",
            "Awake! No. 2 2021 g21.2",
            "Awake! No. 3 2021 g21.3",
            "Awake! No. 1 2022 g22.1",
            "Watchtower No. 1 2018 wp18.1",
            "Watchtower No. 2 2018 wp18.2",
            "Watchtower No. 3 2018 wp18.3",
            "Watchtower No. 1 2019 wp19.1",
            "Watchtower No. 2 2019 wp19.2",
            "Watchtower No. 3 2019 wp19.3",
            "Watchtower No. 1 2020 wp20.1",
            "Watchtower No. 2 2020 wp20.2",
            "Watchtower No. 3 2020 wp20.3",
            "Watchtower No. 1 2021 wp21.1",
            "Watchtower No. 2 2021 wp21.2",
            "Watchtower No. 3 2021 wp21.3",
            "Watchtower No. 1 2022 wp22.1"
        ]; 

        $("#item_name").autocomplete({ 
            source: items
        });
    });
</script>

</body>
</html>
