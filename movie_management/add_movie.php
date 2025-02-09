<?php
include 'connect.php';


$successMessage = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = $_POST['rating'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $price_purchase = $_POST['price_purchase'];
    $price_rental = $_POST['price_rental'];

   
    $query = "SELECT MAX(MOVIE_ID) AS last_id FROM MOVIE";
    $stid = oci_parse($conn, $query);
    oci_execute($stid);
    $row = oci_fetch_array($stid, OCI_ASSOC);
    $last_id = $row['LAST_ID'] ?? 0;

    
    $new_id = $last_id + 1;

    
    $query = "INSERT INTO MOVIE (MOVIE_ID, RATING, TITLE, GENRE, PRICE_PURCHASE, PRICE_RENTAL) 
              VALUES (:movie_id, :rating, :title, :genre, :price_purchase, :price_rental)";
    $stid = oci_parse($conn, $query);

    oci_bind_by_name($stid, ":movie_id", $new_id);
    oci_bind_by_name($stid, ":rating", $rating);
    oci_bind_by_name($stid, ":title", $title);
    oci_bind_by_name($stid, ":genre", $genre);
    oci_bind_by_name($stid, ":price_purchase", $price_purchase);
    oci_bind_by_name($stid, ":price_rental", $price_rental);

    $r = oci_execute($stid);

    
    if ($r) {
        $successMessage = "Movie added successfully!"; 
    } else {
        $successMessage = "Error adding movie: " . oci_error($stid)['message'];
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
    <title>Add Movie</title>
    <style>
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

        input[type="text"], input[type="number"] {
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

        input[type="text"]:focus, input[type="number"]:focus {
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

        .success-message {
            color: #16a34a;
            font-size: 1.2rem;
            margin-top: 20px;
            font-weight: bold;
        }

        .error-message {
            color: #ff4d4d;
            font-size: 1.2rem;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Add New Movie</h2>

    
    <?php if ($successMessage): ?>
        <div class="<?= strpos($successMessage, 'Error') === false ? 'success-message' : 'error-message' ?>">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <form action="add_movie.php" method="POST">
        

        <label for="title">Movie Title:</label>
        <input type="text" id="title" name="title" required>
		
		<label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="10" required>
        
        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" required>

        <label for="price_purchase">Purchase Price:</label>
        <input type="number" id="price_purchase" name="price_purchase" step="0.01" required>

        <label for="price_rental">Rental Price:</label>
        <input type="number" id="price_rental" name="price_rental" step="0.01" required>

        <input type="submit" value="Add Movie">
    </form>

    <a href="populate_tables.php">Back to Populate Tables</a>
</body>
</html>
