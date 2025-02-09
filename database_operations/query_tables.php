<?php
// Include the database connection
include 'connect.php';

// Initialize variables for query and results
$query = '';
$error_message = '';
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sql_query'])) {
    // Get the submitted query
    $query = $_POST['sql_query'];

    // Remove trailing semicolon
    $query = rtrim($query, ';');

    // Parse the SQL query
    $stid = oci_parse($conn, $query);

    if (!$stid) {
        // If parsing fails, display error
        $e = oci_error($conn);
        $error_message = "SQL Parse Error: " . htmlspecialchars($e['message']);
    } else {
        // Execute the query
        $exec = oci_execute($stid);
        if (!$exec) {
            // If execution fails, display error
            $e = oci_error($stid);
            $error_message = "SQL Execution Error: " . htmlspecialchars($e['message']);
        } else {
            // Fetch results if the query executed successfully
            while ($row = oci_fetch_assoc($stid)) {
                $results[] = $row;
            }
        }
        oci_free_statement($stid);
    }
}

// Close the connection
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Tables - Online Movie Store DBMS</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212; /* Dark background for the page */
            color: #f4f4f4; /* Light text for contrast */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        h1 {
            font-size: 2.5rem;
            color: #1db954; /* Bright green for the main heading */
            margin: 20px 0;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        textarea {
            width: 100%;
            max-width: 1600px;
            height: 200px;
            padding: 15px;
            font-size: 1rem;
            color: #fff;
            background-color: #1e1e1e;
            border: 2px solid #333;
            border-radius: 8px;
            resize: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: border-color 0.3s ease;
        }

        textarea:focus {
            outline: none;
            border-color: #1db954; /* Highlight on focus */
        }

        button {
            padding: 12px 25px;
            font-size: 1.1rem;
            color: #fff;
            background-color: #1db954;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #16a34a; /* Lighter green on hover */
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(1px);
        }

        table {
            width: 90%;
            max-width: 700px;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: left;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #333;
        }

        table th {
            background-color: #1db954; /* Bright green for table headers */
            color: #121212;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #1b1b1b; /* Alternating row colors */
        }

        table tr:hover {
            background-color: #333; /* Highlight row on hover */
        }

        .error-message {
            margin: 20px auto;
            padding: 15px;
            background-color: #b71c1c;
            color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            max-width: 700px;
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
    <h1>Query Tables</h1>
    <form method="POST">
        <textarea name="sql_query" placeholder="Enter your SQL query here..."><?= htmlspecialchars($query) ?></textarea><br>
        <button type="submit">Execute Query</button>
    </form>

    <!-- Display error message -->
    <?php if ($error_message): ?>
        <div class="error-message"><?= $error_message ?></div>
    <?php endif; ?>

    <!-- Display results -->
    <?php if ($results): ?>
        <table>
            <thead>
                <tr>
                    <?php foreach (array_keys($results[0]) as $header): ?>
                        <th><?= htmlspecialchars($header) ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <?php foreach ($row as $value): ?>
                            <td><?= htmlspecialchars($value) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

     <a class="back-link" href="index.php">Back to Main Menu</a>
</body>
</html>
