<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');


include 'connect.php'; 

// Handle Update functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $field = $_POST['field_name']; 
    $newValue = $_POST['new_value'];  
    $identifierValue = $_POST['identifier'];   
 
    $identifierColumn = 'TRANSACTION_ID';   

   
    if ($field === 'TRANSACTION_ID' || $field === 'CUSTOMER_ID' || $field === 'MOVIE_ID') {
       
        if (!is_numeric($newValue)) {
            $error = "New value must be a number for $field.";
        }
        $newValue = (int)$newValue;   
        $identifierValue = (int)$identifierValue;   
    } elseif ($field === 'COST') {
         
        if (!is_numeric($newValue)) {
            $error = "New value must be a number for $field.";
        }
        $newValue = (float)$newValue;   
    } else {
       
        $newValue = "'" . $newValue . "'";  
    }

    
    $sql = "UPDATE transaction SET $field = :newValue WHERE $identifierColumn = :identifierValue";

    
    $stid = oci_parse($conn, $sql);

    if (!$stid) {
        $error = "Error preparing statement: " . oci_error($conn)['message'];
    } else {
         
        oci_bind_by_name($stid, ":newValue", $newValue);
        oci_bind_by_name($stid, ":identifierValue", $identifierValue);

        
        $execute = oci_execute($stid);

        if ($execute) {
            $message = "Record updated successfully!";
        } else {
            $error = "Error executing statement: " . oci_error($stid)['message'];
        }

       
        oci_free_statement($stid);
    }
}

 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $deleteIdentifier = $_POST['delete_identifier'];   

    
    $deleteSql = "DELETE FROM transaction WHERE TRANSACTION_ID = :deleteIdentifier";
    $stidDelete = oci_parse($conn, $deleteSql);

    if (!$stidDelete) {
        $error = "Error preparing delete statement: " . oci_error($conn)['message'];
    } else {
         
        oci_bind_by_name($stidDelete, ":deleteIdentifier", $deleteIdentifier);

      
        $executeDelete = oci_execute($stidDelete);

        if ($executeDelete) {
            $message = "Record deleted successfully!";
        } else {
            $error = "Error executing delete statement: " . oci_error($stidDelete)['message'];
        }

       
        oci_free_statement($stidDelete);
    }
}

 
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update or Delete Transaction</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            margin: 0;
        }

        h1 {
            margin-bottom: 20px;
        }

        .form-container {
            display: flex;
            flex-direction: column;
            gap: 40px;  
            width: 100%;
            max-width: 400px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
        }

        h2 {
            margin-bottom: 10px;
            color: #f39c12;
        }

        label, input, select {
            color: #fff;
        }

        input, select {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
        }

        button {
            padding: 10px 20px;
            background-color: #1db954;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #17a441;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .error {
            background-color: #d32f2f;
        }

        .back-link {
            text-decoration: none;
            color: #f39c12;
            font-weight: bold;
            margin-top: 20px;
            padding: 12px 30px;
            background-color: #333;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-link:hover { 
            background-color: #555;
        }
    </style>
</head>
<body>
    <h1>Manage Transaction</h1>

    <div class="form-container">
        <!-- Update Section -->
        <form method="POST" action="">
            <h2>Update Transaction</h2>
            <label for="field_name">Field to update:</label>
            <select id="field_name" name="field_name" required>
                <option value="TRANSACTION_ID">TRANSACTION_ID</option>
                <option value="CUSTOMER_ID">CUSTOMER_ID</option>
                <option value="MOVIE_ID">MOVIE_ID</option>
                <option value="COST">COST</option>
                <option value="TRANSACTION_DATE">TRANSACTION_DATE</option>
                <option value="TRANSACTION_TYPE">TRANSACTION_TYPE</option>
            </select>

            <label for="new_value">New value:</label>
            <input type="text" id="new_value" name="new_value" placeholder="e.g., newprice" required>

            <label for="identifier">Identifier value (e.g., 4 for TRANSACTION_ID):</label>
            <input type="text" id="identifier" name="identifier" placeholder="e.g., 4" required>

            <button type="submit" name="update">Update</button>
        </form>

        <!-- Delete Section -->
        <form method="POST" action="">
            <h2>Delete Transaction</h2>
            <label for="delete_identifier">Transaction ID to delete:</label>
            <input type="text" id="delete_identifier" name="delete_identifier" placeholder="e.g., 4" required>
            <button type="submit" name="delete">Delete</button>
        </form>
    </div>

    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php elseif (!empty($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <a class="back-link" href="update_tables.php">Back to Update Tables</a>
</body>
</html>
