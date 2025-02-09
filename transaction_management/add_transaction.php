<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $customer_id = $_POST['customer_id'];
    $movie_id = $_POST['movie_id'];
    $transaction_type = $_POST['transaction_type'];
    $start_date = $_POST['start_date'] ?? null; // Optional
    $rental_duration = $_POST['rental_duration'] ?? null; // Optional

   
    $query = "SELECT PRICE_RENTAL, PRICE_PURCHASE FROM movie WHERE MOVIE_ID = :movie_id";
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ":movie_id", $movie_id);
    oci_execute($stid);
    $movie = oci_fetch_array($stid, OCI_ASSOC);

    if (!$movie) {
        echo "Error: Movie not found.";
        exit;
    }

  
    if ($transaction_type === 'Rental') {
        $cost = $movie['PRICE_RENTAL'];
    } elseif ($transaction_type === 'Purchase') {
        $cost = $movie['PRICE_PURCHASE'];
    } else {
        echo "Error: Invalid transaction type.";
        exit;
    }

    $transaction_query = "SELECT MAX(TRANSACTION_ID) AS max_transaction_id FROM transaction";
    $stid = oci_parse($conn, $transaction_query);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC);
    $transaction_id = ($row['MAX_TRANSACTION_ID'] ?? 0) + 1; 

    
    $transaction_insert_query = "INSERT INTO transaction (TRANSACTION_ID, CUSTOMER_ID, MOVIE_ID, COST, TRANSACTION_DATE, TRANSACTION_TYPE) 
                                  VALUES (:transaction_id, :customer_id, :movie_id, :cost, SYSDATE, :transaction_type)";
    $stid = oci_parse($conn, $transaction_insert_query);
    oci_bind_by_name($stid, ":transaction_id", $transaction_id);
    oci_bind_by_name($stid, ":customer_id", $customer_id);
    oci_bind_by_name($stid, ":movie_id", $movie_id);
    oci_bind_by_name($stid, ":cost", $cost);
    oci_bind_by_name($stid, ":transaction_type", $transaction_type);
    $transaction_execute = oci_execute($stid);

    if ($transaction_execute) {
        echo "Transaction successfully added!<br>";

        // Additional logic for Purchase
        if ($transaction_type === 'Purchase') {
            $purchase_query = "INSERT INTO purchase (PURCHASE_ID, TRANSACTION_ID, MOVIE_ID, PURCHASE_DATE) 
                               VALUES ((SELECT NVL(MAX(PURCHASE_ID), 0) + 1 FROM purchase), :transaction_id, :movie_id, SYSDATE)";
            $stid = oci_parse($conn, $purchase_query);
            oci_bind_by_name($stid, ":transaction_id", $transaction_id);
            oci_bind_by_name($stid, ":movie_id", $movie_id);
            $purchase_execute = oci_execute($stid);

           
        }
    } else {
        $error = oci_error($stid);
        echo "Error executing transaction query: " . $error['message'] . "<br>";
    }

    oci_free_statement($stid);
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Montserrat:wght@600&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            color: #f8f8f8;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            box-sizing: border-box;
        }

        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 2.5rem;
            color: #1db954;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: block;
            font-weight: 600;
            color: #f8f8f8;
        }

        input[type="text"], input[type="email"], input[type="date"], select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #333;
            border-radius: 6px;
            font-size: 1rem;
            background-color: #333;
            color: #f8f8f8;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, select:focus {
            outline: none;
            border-color: #1db954;
            background-color: #222;
        }

        button[type="submit"] {
            background-color: #1db954;
            color: white;
            font-size: 1.2rem;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: #16a34a;
            transform: translateY(-2px);
        }

        button[type="submit"]:active {
            transform: translateY(1px);
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #1db954;
            font-size: 1rem;
            font-weight: 600;
        }

        a:hover {
            color: #16a34a;
        }

        #rental_fields {
            display: none;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Transaction</h1>
        <form method="POST">
            <div class="form-group">
                <label for="customer_id">Customer ID:</label>
                <input type="text" id="customer_id" name="customer_id" required>
            </div>

            <div class="form-group">
                <label for="movie_id">Movie ID:</label>
                <input type="text" id="movie_id" name="movie_id" required>
            </div>

            <div class="form-group">
                <label for="transaction_type">Transaction Type:</label>
                <select name="transaction_type" id="transaction_type" required>
                    <option value="Purchase">Purchase</option>
                    <option value="Rental">Rental</option>
                </select>
            </div>

            <!-- Rental-specific fields -->
            <div id="rental_fields">
                <div class="form-group">
                    <label for="start_date">Start Date (only for Rental):</label>
                    <input type="date" name="start_date" id="start_date">
                </div>

                <div class="form-group">
                    <label for="rental_duration">Rental Duration (weeks):</label>
                    <select name="rental_duration" id="rental_duration">
                        <option value="">Select</option>
                        <option value="1">1 Week</option>
                        <option value="2">2 Weeks</option>
                        <option value="3">3 Weeks</option>
                        <option value="4">4 Weeks</option>
                    </select>
                </div>
            </div>

            <button type="submit">Add Transaction</button>
        </form>
        <a href="populate_tables.php">Back to Populate Tables</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const transactionType = document.getElementById('transaction_type');
            const rentalFields = document.getElementById('rental_fields');

            transactionType.addEventListener('change', function () {
                if (this.value === 'Rental') {
                    rentalFields.style.display = 'block';
                } else {
                    rentalFields.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>

