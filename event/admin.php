<?php
session_start();
include 'db.php'; // Use 'db.php' for database connection

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: adminlogin.php');
    exit();
}

// Handle form submission for adding new events
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle file upload
    $target_dir = "uploads/"; // Ensure this directory exists
    $target_file = $target_dir . basename($_FILES["poster"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["poster"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check file size (maximum 100MB)
    if ($_FILES["poster"]["size"] > 104857600) { // 100MB in bytes
        echo "Sorry, your file must not exceed 100MB.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file)) {
            // Insert into the database after successful upload
            $stmt = $pdo->prepare("INSERT INTO events (category, poster, price, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$category, $target_file, $price, $description]);
            echo "The event has been successfully added.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Spectral:wght@400;700&display=swap">
    <style>
        body {
            background-image: url('img4.png');
            background-size: cover;
            font-family: 'Spectral', serif;
            color: #d64e13;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 3em;
            color: #ffcc00;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        form {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 15px;
            max-width: 600px;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="file"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #f0e68c;
            border-radius: 5px;
            background-color: #ffffff;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #f0e68c;
            border-radius: 5px;
            background-color: #ffffff;
        }

        button {
            background-color: #ffcc00;
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
            background-color: #e6b800;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        img {
            width: 100px;
            height: auto;
            margin-right: 10px;
            vertical-align: middle;
        }

        li {
            margin-bottom: 20px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Logout Button -->
    <form action="logout.php" method="post" style="display:inline;">
        <button type="submit">Logout</button>
    </form>

    <h2>Add New Event</h2>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <label for="category">Category:</label>
        <select name="category" required>
            <option value="block">Block</option>
            <option value="individual">Individual</option>
            <option value="gamezone">Game Zone</option>
        </select>

        <label for="poster">Event Poster:</label>
        <input type="file" name="poster" required>

        <label for="price">Price:</label>
        <input type="text" name="price" required>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <button type="submit">Add Event</button>
    </form>

    <h2>Current Events</h2>
    <ul>
        <?php
        // Fetch and display current events
        $events = $pdo->query("SELECT * FROM events")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($events as $event) {
            echo '<li>';
            echo '<img src="' . htmlspecialchars($event['poster']) . '" alt="Event Poster">';
            echo htmlspecialchars($event['description']) . ' - ₹' . htmlspecialchars($event['price']);
            // Add delete button with event ID
            echo '<form action="delete_event.php" method="post" style="display:inline;">
                    <input type="hidden" name="event_id" value="' . $event['id'] . '">
                    <button type="submit" onclick="return confirm(\'Are you sure you want to delete this event?\')">Delete</button>
                  </form>';
            echo '</li>';
        }
        ?>
    </ul>
</body>
</html>
