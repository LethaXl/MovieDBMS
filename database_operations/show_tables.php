<?php

include 'connect.php';

if (!$conn) {
    echo "Failed to connect to the database.";
    exit;
}


$query = "SELECT table_name FROM user_tables";
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
    <title>Show Tables</title>
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
            height: 100vh;
        }

        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            color: #f8f8f8;
            margin-bottom: 30px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.6);
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        ul li {
            margin: 10px 0;
        }

        ul li a {
            text-decoration: none;
            color: #121212;
            background-color: #1db954; /* Spotify green */
            padding: 15px 40px;
            border-radius: 12px;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            display: inline-block;
            transition: all 0.3s ease;
            text-align: center;
            width: 300px; /* Ensures uniform size */
        }

        ul li a:hover {
            background-color: #1ed760;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(30, 215, 96, 0.5);
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
    <h1>List of Tables</h1>
    <ul>
    <?php
    while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
        $tableName = $row['TABLE_NAME'];
        // For the MOVIE table, direct it to view_movie.php
        if ($tableName == 'MOVIE') {
            echo "<li><a href='view_movie.php'>$tableName</a></li>";
        } else {
            echo "<li><a href='view_table.php?table=$tableName'>$tableName</a></li>";
        }
    }
    ?>
</ul>

    <a class="back-link" href="index.php">Back to Main Menu</a>
</body>
</html>

<?php

oci_free_statement($stid);
oci_close($conn);
?>
