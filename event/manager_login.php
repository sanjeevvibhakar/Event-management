<?php
session_start();
$manager_password = 'A7#dR9f!4Xv2@M'; // Set your manager password here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['password']) && $_POST['password'] === $manager_password) {
        $_SESSION['manager_logged_in'] = true; // Set session if password matches
        header('Location: view_all_registered_users.php'); // Redirect to the protected page
        exit;
    } else {
        $error = "Incorrect password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        input[type="password"] {
            padding: 10px;
            width: 100%;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <h1>Manager Login</h1>
    <form action="manager_login.php" method="POST">
        <label for="password">Enter Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

</body>
</html>
