<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../img/logo.png" rel="icon" type="image/png">
    <style>
        /* General Body Styling */
        body {
            font-family: 'Spectral', serif;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
        }

        /* Background Video Styling */
        .background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        /* Container Styling */
        .container {
            background-color: rgb(255 255 255 / 27%);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* Heading Styling */
        h1 {
            color: #8B0000;
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        /* Label and Input Styling */
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input {
            width: 90%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* Button Styling */
        button {
            background-color: #4B0082;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #551A8B;
        }

        /* Error Message Styling */
        p {
            color: red;
            margin-top: 10px;
        }

        /* Responsive Adjustments */
        @media (max-width: 600px) {
            h1 {
                font-size: 2em;
            }

            .container {
                padding: 20px;
            }

            button {
                font-size: 1em;
            }
        }

        @media (max-width: 400px) {
            h1 {
                font-size: 1.8em;
            }

            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <video autoplay muted loop class="background-video">
        <source src="https://cdn.magicawakened.com/home/hero-june-2023-m.mp4?c=b" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container">
        <h1>Login to Racaf</h1>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
            
            
            <!-- Error message display -->
            <?php if (isset($error)) echo "<p>$error</p>"; ?>
        </form>
        <div style="margin-top: 15px;">
    <p>Not registered yet? <a href="register.php" style="color: #4B0082; text-decoration: underline;">Register here</a></p>
</div>
    </div>
</body>
</html>
