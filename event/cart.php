<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Add event to the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    
    // Check if the event is already in the user's cart
    $checkStmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND event_id = ?");
    $checkStmt->execute([$_SESSION['user_id'], $event_id]);
    
    // If not in the cart, insert it
    if ($checkStmt->rowCount() === 0) {
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, event_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['user_id'], $event_id]);
    }
}

// Remove event from the cart
if (isset($_POST['remove'])) {
    $event_id = $_POST['event_id'];
    $removeStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND event_id = ?");
    $removeStmt->execute([$_SESSION['user_id'], $event_id]);
}

// Fetch cart items for the user
$user_id = $_SESSION['user_id'];
$cart_items = $pdo->prepare("SELECT events.* FROM cart JOIN events ON cart.event_id = events.id WHERE cart.user_id = ?");
$cart_items->execute([$user_id]);
$cart_items = $cart_items->fetchAll(PDO::FETCH_ASSOC);

// Calculate total price
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Magical Cart</title>
    <style>
         /* Basic styling */
        body {
            background: radial-gradient(circle, rgba(31, 9, 49, 0.8) 0%, rgba(0, 0, 0, 0.8) 100%);
            color: #f3f3f3;
            font-family: 'Georgia', serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            overflow-x: hidden;
            margin: 0;
        }

        /* Background stars */
        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 5s infinite ease-in-out;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }

        /* Heading */
        h1 {
            text-align: center;
            font-size: 2em;
            color: #f8f3e7;
            margin: 20px 0;
        }

        /* List and items */
        ul {
            list-style: none;
            padding: 0;
            max-width: 600px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        li {
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            background-color: #6b4f7f;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            flex: 1;
            max-width: 100px;
            text-align: center;
        }

        .btn:hover {
            background-color: #8a6b9f;
        }

        /* Price and navigation */
        .total-price {
            font-size: 1.5em;
            text-align: center;
            margin-top: 20px;
            color: #ffd700;
        }

        .checkout, .back-btn {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 10px auto;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
        }

        .checkout {
            background-color: #3d3d6b;
        }

        .back-btn {
            background-color: #4a4a6b;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            h1 {
                font-size: 1.8em;
            }

            ul, .total-price {
                font-size: 1em;
            }

            .btn, .checkout, .back-btn {
                font-size: 1em;
                padding: 10px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Your Magical Cart</h1>
    <ul>
        <?php if (empty($cart_items)): ?>
            <li>Your cart is empty.</li>
        <?php else: ?>
            <?php foreach ($cart_items as $item): ?>
                <li>
                    <span><?php echo htmlspecialchars($item['description']); ?> - ₹<?php echo htmlspecialchars($item['price']); ?></span>
                    <form action="cart.php" method="post" style="display:inline;">
                        <input type="hidden" name="event_id" value="<?php echo $item['id']; ?>">
                        <button type="submit" name="remove" class="btn">Remove</button>
                    </form>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    
    <?php if (!empty($cart_items)): ?>
    <h3 class="total-price">Total Price: ₹<?php echo $total_price; ?></h3>
    <a href="index.php" class="back-btn btn">Back</a>
    <button id="rzp-button1" class="checkout btn">Checkout</button>
    <p class="payment-message">Please be patient while paying. Wait for the page to redirect after successful payment.</p>
<?php endif; ?>


    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
    var options = {
        "key": "rzp_live_ISn6xVx9PhDWza", // Replace with your live Razorpay Key ID
        "amount": "<?php echo $total_price * 100; ?>", // Amount in paise (1 INR = 100 paise)
        "currency": "INR",
        "name": "Acme Corp",
        "description": "Test Transaction",
        "image": "https://example.com/your_logo",
        "callback_url": "payment_callback.php", // Callback URL after payment
        "prefill": {
            "name": "<?php echo $_SESSION['user_name']; ?>", // Prefill user data from session
            "email": "<?php echo $_SESSION['user_email']; ?>",
            "contact": "<?php echo $_SESSION['user_contact']; ?>"
        },
        "notes": {
            "address": "Acme Corp Office"
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp1 = new Razorpay(options);
    document.getElementById('rzp-button1').onclick = function(e){
        rzp1.open();
        e.preventDefault();
    }
    </script>
</body>
</html>
