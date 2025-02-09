<?php

include 'connect.php';


session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exit - Online Movie Store DBMS</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(145deg, #121212, #1c1c1c);
            color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            box-sizing: border-box;
        }

        h1 {
            color: #1db954; /* Green accent */
            font-size: 3.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        p {
            font-size: 1.3rem;
            color: #bbb;
            margin-bottom: 40px;
            text-align: center;
            max-width: 600px;
        }

        .message-container {
            background-color: #222;
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            border: 2px solid #333;
        }

        .message-container a {
            display: inline-block;
            padding: 15px 30px;
            margin-top: 25px;
            font-size: 1.2rem;
            color: #fff;
            background-color: #1e1e1e;
            text-decoration: none;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        }

        .message-container a:hover {
            background-color: #16a34a; /* Green hover effect */
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .message-container a:active {
            transform: translateY(2px);
        }

        /* Add mobile responsiveness */
        @media (max-width: 600px) {
            h1 {
                font-size: 2.5rem;
            }

            p {
                font-size: 1.1rem;
                max-width: 100%;
            }

            .message-container {
                padding: 30px 40px;
            }

            .message-container a {
                width: 150px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="message-container">
        <h1>You have successfully logged out</h1>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
