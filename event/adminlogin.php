<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Spectral:wght@400;700&display=swap">
    <style>
        body {
            background-image: url('img5.jfif'); /* Replace with your background image */
            background-size: cover;
            font-family: 'Spectral', serif;
            color: #f0e68c; /* Light yellow color for text */
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 3em;
            color: #ffcc00; /* Golden color */
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        form {
            background: rgba(0, 0, 0, 0.7); /* Dark translucent background */
            padding: 20px;
            border-radius: 15px;
            max-width: 400px;
            margin: 50px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #f0e68c;
            border-radius: 5px;
            background-color: #ffffff;
        }

        button {
            background-color: #ffcc00; /* Golden color */
            color: black;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #e6b800; /* Darker golden on hover */
        }

        p {
            color: #ff0000; /* Red for error messages */
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Admin Login</h1>
    <form action="adminlogin.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Login</button>
        
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
</body>
</html>
