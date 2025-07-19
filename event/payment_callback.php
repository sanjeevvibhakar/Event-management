<?php
session_start();
include 'db.php';

// Assuming Razorpay sends the payment details here via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_id = $_POST['razorpay_payment_id'];
    $user_id = $_SESSION['user_id'];

    // Verify payment details (optional: validate with Razorpay API for added security)
    if ($payment_id) {
        // Fetch all items in the cart for the user
        $cart_items = $pdo->prepare("SELECT event_id FROM cart WHERE user_id = ?");
        $cart_items->execute([$user_id]);
        $events = $cart_items->fetchAll(PDO::FETCH_ASSOC);

        // Insert each event into the registered_events table
        $registerStmt = $pdo->prepare("INSERT INTO registered_events (user_id, event_id) VALUES (?, ?)");
        foreach ($events as $event) {
            $registerStmt->execute([$user_id, $event['event_id']]);
        }

        // Clear the cart after registration
        $clearCartStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $clearCartStmt->execute([$user_id]);

        // Redirect to success page
        header('Location: success.php');
        exit();
    } else {
        // Payment failed, redirect to failure page
        header('Location: failure.php');
        exit();
    }
}
