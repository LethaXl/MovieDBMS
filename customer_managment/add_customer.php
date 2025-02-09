<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob']; 
    $phone_number = $_POST['phone'];  

    
    $dob = DateTime::createFromFormat('Y-m-d', $dob);
    if ($dob === false) {
        echo "Invalid date format. Please use yyyy-mm-dd.";
        exit;
    }
    $dob = $dob->format('d-M-Y');  
    
    if (!$dob) {
        echo "Error formatting the date.";
        exit;
    }

   
    $query = "SELECT MAX(CUSTOMER_ID) AS last_id FROM customer";
    $stid = oci_parse($conn, $query);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC);
    $last_id = $row['LAST_ID'] ?? 0;

   
    $new_id = $last_id + 1;

  
    $query = "INSERT INTO customer (CUSTOMER_ID, NAME, EMAIL, DOB, PHONE_NUMBER) 
              VALUES (:customer_id, :name, :email, TO_DATE(:dob, 'DD-MON-YYYY'), :phone_number)";
    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":customer_id", $new_id);
    oci_bind_by_name($stid, ":name", $name);
    oci_bind_by_name($stid, ":email", $email);
    oci_bind_by_name($stid, ":dob", $dob);
    oci_bind_by_name($stid, ":phone_number", $phone_number);

    $r = oci_execute($stid);

    if ($r) {
        echo "Customer added successfully!";
    } else {
        echo "Error adding customer: " . oci_error($stid)['message'];
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
    <title>Add Customer</title>
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

        h2 {
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

        label {
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: block;
            font-weight: 600;
            color: #f8f8f8;
        }

        input[type="text"], input[type="email"], input[type="date"] {
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

        input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus {
            outline: none;
            border-color: #1db954;
            background-color: #222;
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #16a34a;
            transform: translateY(-2px);
        }

        input[type="submit"]:active {
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
    </style>
</head>
<body>
    <h2>Add New Customer</h2>

    <form action="add_customer.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required> 

        <input type="submit" value="Add Customer">
    </form>

    <a href="populate_tables.php">Back to Populate Tables</a>
</body>
</html>
