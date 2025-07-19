<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch registered events for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "
    SELECT events.description, events.price, events.category
    FROM registered_events
    JOIN events ON registered_events.event_id = events.id
    WHERE registered_events.user_id = ?
";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$registered_events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap');
        body {
            font-family: 'Cinzel', serif;
            background-color: #1a1a1a;
            color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }
        h1 {
            color: #b4835b;
            font-size: 2.5em;
            text-align: center;
            margin: 0;
            padding: 10px 0;
            border-bottom: 2px solid #b4835b;
        }
        h2 {
            color: #d4af37;
            font-size: 1.8em;
            text-align: center;
            margin: 20px 0;
        }
        ul {
            list-style: none;
            padding: 0;
            max-width: 600px;
            width: 100%;
            margin: 20px 0;
        }
        li {
            background-color: #3b3b3b;
            margin-bottom: 10px;
            padding: 15px;
            border: 2px solid #d4af37;
            border-radius: 8px;
            font-size: 1.1em;
        }
        .button {
            background-color: #b4835b;
            color: #f5f5f5;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
            display: inline-block;
            margin-top: 10px;
        }
        .button:hover {
            background-color: #d4af37;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 2em;
            }
            h2 {
                font-size: 1.5em;
            }
            li {
                font-size: 1em;
                padding: 10px;
            }
            .button {
                font-size: 0.9em;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>
    <h1>Your Profile</h1>
    <h2>Registered Events:</h2>
    <ul>
        <?php if (empty($registered_events)): ?>
            <li>You have not registered for any events yet.</li>
        <?php else: ?>
            <?php foreach ($registered_events as $event): ?>
                <li>
                    <strong><?php echo htmlspecialchars($event['description']); ?></strong><br>
                    Price: ₹<?php echo htmlspecialchars($event['price']); ?><br>
                    Category: <?php echo htmlspecialchars($event['category']); ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

    <div class="button-container">
        <a href="index.php" class="button">Home</a>
        <a href="cart.php" class="button">Go to Cart</a>
    </div>
</body>
</html>
