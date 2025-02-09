<?php
include 'connect.php';

if (!$conn) {
    echo "Failed to connect to the database.";
    exit;
}

$table = isset($_GET['table']) ? $_GET['table'] : '';

if (empty($table)) {
    echo "Table not specified.";
    exit;
}

$query = "SELECT * FROM $table";
$stid = oci_parse($conn, $query);

if (!$stid) {
    echo "Error parsing query: " . oci_error($conn)['message'];
    oci_close($conn);
    exit;
}

$r = oci_execute($stid);

if (!$r) {
    echo "Error executing query: " . oci_error($stid)['message'];
    oci_close($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Table - <?php echo $table; ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@600&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            color: #f8f8f8;
            margin-bottom: 30px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        table {
            width: 80%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: center;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th, td {
            padding: 15px;
            font-size: 1rem;
        }

        th {
            background-color: #1db954;
            color: #fff;
        }

        td {
            background-color: #222;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #2c2c2c;
        }

        tr:hover {
            background-color: #444;
        }

        .movie-table td img {
            max-width: 200px;
            border-radius: 8px;
        }

        a.back-link {
            text-decoration: none;
            color: #121212;
            background-color: #f39c12;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
            margin-top: 30px;
            transition: all 0.3s ease;
        }

        a.back-link:hover {
            background-color: #d35400;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(243, 156, 18, 0.5);
        }
    </style>
</head>
<body>

<h1><?php echo $table; ?> Table</h1>

<table class="<?php echo strtolower($table) == 'movie' ? 'movie-table' : ''; ?>">
    <thead>
        <tr>
            <?php
            $columns = oci_fetch_assoc($stid);
            foreach ($columns as $colName => $value) {
                echo "<th>$colName</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        oci_execute($stid);
        while ($row = oci_fetch_assoc($stid)) {
            echo "<tr>";
            foreach ($row as $column => $value) {
                if (strtolower($table) == 'movie' && $column == 'image_url') {
                    echo "<td><img src='$value' alt='Movie Cover'></td>";
                } else {
                    echo "<td>$value</td>";
                }
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<a class="back-link" href="show_tables.php">Back to Tables List</a>

</body>
</html>

<?php
oci_free_statement($stid);
oci_close($conn);
?>
