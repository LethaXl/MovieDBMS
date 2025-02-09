<?php
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Table</title>
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

        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #b3b3b3;
        }

        .menu {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .menu a {
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

        .menu a:hover {
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
    <h1>Update Table</h1>
    <p>Select a table to update:</p>
    <div class="menu">
        <a href="update_transaction.php">Transaction Table</a>
        <a href="update_customer.php">Customer Table</a>
        <a href="update_movie.php">Movie Table</a>
        <a href="update_rental.php">Rental Table</a>
        <a href="update_purchase.php">Purchase Table</a>
    </div>
    <a href="index.php" class="back-link">Back to Home</a>
</body>
</html>
