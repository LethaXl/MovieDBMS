<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Movie Store DBMS</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: #1db954; /* Green accent */
            font-size: 3rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: #bbb;
            margin-bottom: 40px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .menu a {
            display: block;
            padding: 12px 25px;
            font-size: 1.1rem;
            color: #fff;
            background-color: #1e1e1e;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
            width: 200px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .menu a:hover {
            background-color: #16a34a; /* Green hover effect */
            transform: translateY(-2px);
        }

        .menu a:active {
            transform: translateY(1px);
        }

        /* Add mobile responsiveness */
        @media (max-width: 600px) {
            h1 {
                font-size: 2.2rem;
            }
            .menu a {
                width: 150px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <h1>Online Movie Store DBMS</h1>
    <p>Choose an action:</p>
    <div class="menu">
        <a href="show_tables.php">Show Tables</a>
    <a href="populate_tables.php">Populate Tables</a>
    <a href="update_tables.php">Update Tables</a>
    <a href="query_tables.php">Query Tables</a>
    <a href="exit.php">Exit</a>
    </div>
</body>
</html>
