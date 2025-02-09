<?php
include 'connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'customer':
                header('Location: add_customer.php');
                break;
            case 'transaction':
                header('Location: add_transaction.php');
                break;
            case 'movie':
                header('Location: add_movie.php');
                break;
            default:
                echo "Invalid action.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Populate Tables</title>
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

        .button-group {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .button-group button {
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
            margin: 10px 0;
            text-align: center;
            width: 300px; /* Ensures uniform size */
        }

        .button-group button:hover {
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

    <h1>Populate Tables</h1>

    <form method="POST">
        <div class="button-group">
            <button type="submit" name="action" value="customer">Add Customer</button>
            <button type="submit" name="action" value="transaction">Add Transaction</button>
            <button type="submit" name="action" value="movie">Add Movie</button>
        </div>
    </form>

    <a class="back-link" href="index.php">Back to Main Menu</a>

</body>
</html>
