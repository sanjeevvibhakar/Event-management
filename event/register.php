<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $registration_no = $_POST['registration_no'];
    $gender = $_POST['gender'];
    $mobile_no = $_POST['mobile_no'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, name, email, registration_no, gender, mobile_no, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $name, $email, $registration_no, $gender, $mobile_no, $password]);

    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="../img/logo.png" rel="icon" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Spectral:wght@400;700&display=swap">
    <link rel="stylesheet" href="style.css"> <!-- Link to your external CSS file -->
    <style>
        /* General Body Styling */
        body {
            background-image: url('img2.jpg');
            background-size: cover;
            font-family: 'Spectral', serif;
            color: #f0e68c;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Heading Styling */
        h1 {
            text-align: center;
            font-size: 2.5em;
            color: #ffcc00;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
        }

        /* Form Container */
        form {
            background: rgba(0, 0, 0, 0.7);
            padding: 25px;
            border-radius: 15px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        /* Label and Input Field Styling */
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #f0e68c;
            border-radius: 5px;
            background-color: #ffffff;
        }

        /* Button Styling */
        button {
            background-color: #ffcc00;
            color: black;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        button:hover {
            background-color: #e6b800;
        }

        /* Responsive Styling */
        @media (max-width: 600px) {
            h1 {
                font-size: 2em;
            }
            form {
                padding: 20px;
            }
        }

        @media (max-width: 400px) {
            h1 {
                font-size: 1.8em;
            }
            form {
                padding: 15px;
            }
            button {
                font-size: 1em;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div>
        <h1>Register</h1>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="registration_no">Registration No:</label>
            <input type="text" id="registration_no" name="registration_no" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="mobile_no">Mobile No:</label>
            <input type="text" id="mobile_no" name="mobile_no" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
