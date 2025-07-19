<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            font-size: 24px;
            color: #4CAF50;
        }
        .tick-mark {
            color: #4CAF50;
            font-size: 36px;
            margin-right: 10px;
            vertical-align: middle;
        }
        .button {
            margin-top: 20px;
        }
        .button a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
        }
        .button a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><span class="tick-mark">&#10004;</span>Payment Successful</h1>
        <div class="button">
            <a href="https://sonabyss2k24.in/event/index.php">Home</a>
        </div>
    </div>
</body>
</html>
