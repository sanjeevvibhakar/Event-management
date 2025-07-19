<?php
session_start();
include 'config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: adminlogin.php');
    exit();
}

// Check if event ID is provided
if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Fetch the event's poster file path to delete the associated file
    $stmt = $pdo->prepare("SELECT poster FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        $poster_path = $event['poster'];

        // Prepare the DELETE query
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
        if ($stmt->execute([$event_id])) {
            // Delete the associated poster file
            if (file_exists($poster_path)) {
                unlink($poster_path); // Deletes the file from the server
            }

            // Redirect back to the admin dashboard after successful deletion
            header('Location: admin.php?message=Event deleted successfully');
            exit();
        } else {
            echo "Error deleting event.";
        }
    } else {
        echo "Event not found.";
    }
} else {
    echo "No event ID provided.";
}
?>
