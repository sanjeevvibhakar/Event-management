<?php
// Database configuration
$host = 'localhost';
$db = 'Sona_reg';
$user = 'root';
$pass = ''; // Ensure you set the correct password if any


// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $number = htmlspecialchars($_POST['number']);
    $address = htmlspecialchars($_POST['address']);
    $gender = htmlspecialchars($_POST['gender']);
    $message = htmlspecialchars($_POST['message']);
    
    // Prepare an SQL statement to insert the data
    $sql = "INSERT INTO users (name, email, number, address, gender, message) VALUES (:name, :email, :number, :address, :gender, :message)";
    $stmt = $pdo->prepare($sql);
    
    // Execute the SQL statement
    try {
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':number' => $number,
            ':address' => $address,
            ':gender' => $gender,
            ':message' => $message
        ]);

        // Redirect or display success message
        echo "Registration successful!";
    } catch (PDOException $e) {
        die("Database query failed: " . $e->getMessage());
    }
}
?>
