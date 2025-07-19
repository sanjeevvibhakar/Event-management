<?php
session_start();
if (!isset($_SESSION['manager_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include the database connection
include 'db.php';

// Modify the SQL query to include mobile_no and arrange by registration date
$stmt = $pdo->query("SELECT users.name, users.email, users.mobile_no, events.description, registered_events.registration_date
    FROM registered_events
    JOIN users ON registered_events.user_id = users.id
    JOIN events ON registered_events.event_id = events.id
    ORDER BY registered_events.registration_date DESC");

$registered_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Registered Users</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a.button-logout {
            display: inline-block;
            background-color: red;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        a.button-logout:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <h1>All Registered Users</h1>
    <a href="mlogout.php" style="display: inline-block; background-color: red; color: white; padding: 10px 20px; text-align: center; text-decoration: none; border-radius: 5px; font-size: 1em; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='darkred'" onmouseout="this.style.backgroundColor='red'">Logout</a>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No</th>
                <th>Event Description</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $number = 1; ?>
            <?php foreach ($registered_users as $user): ?>
                <tr>
                    <td><?php echo $number++; ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['mobile_no']); ?></td>
                    <td><?php echo htmlspecialchars($user['description']); ?></td>
                    <td><?php echo htmlspecialchars($user['registration_date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
