<?php
session_start();
include 'db.php';

$events = $pdo->query("SELECT * FROM events")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <link href="../img/logo.png" rel="icon" type="image/png">
    <link rel="stylesheet" href="styles.css">
    <style>
        
        body {
                margin: 0;
    padding: 0;
    background: url(hogwarts.jpg) no-repeat;
    background-size: 100% 100%; /* Adjusts the image to fit the page */
    background-position: center;

        }

        nav {
            background-color: #4b494da8; /* Dark background color */
            color: #fff; /* Text color */
            width: 100%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); /* Shadow for depth */
            position: absolute; /* Stick to the top on scroll */
            top: 0; /* Positioning */
            z-index: 1000; /* Layer above other elements */
        }

        .nav-container {
            display: flex;
            justify-content: space-between; /* Space between items */
            align-items: center; /* Center items vertically */
			height: 50px;
        }

        .nav-links {
            display: flex;
            gap: 20px; /* Space between links */
        }

        nav button {
            background-color: transparent; /* Transparent background */
            border: none; /* Remove border */
            color: #fff; /* Text color */
            padding: 10px 15px; /* Padding around buttons */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s, color 0.3s; /* Smooth transitions */
            font-size: 1em; /* Font size */
        }

        nav button:hover {
            background-color: #9e4b4b; /* Background color on hover */
            color: #fff; /* Change text color on hover */
        }

        .dropdown {
            position: relative; /* Position for dropdown */
        }

        .dropdown-content {
            display: none; /* Hidden by default */
            position: absolute; /* Absolute positioning */
            background-color: #4a4e69; /* Dropdown background */
            min-width: 160px; /* Minimum width */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Shadow for depth */
            z-index: 1; /* Layer above other elements */
        }

        .dropdown:hover .dropdown-content {
            display: block; /* Show dropdown on hover */
        }

        .dropdown-content button {
            color: #fff; /* Text color */
            padding: 10px 15px; /* Padding around dropdown buttons */
            border: none; /* Remove border */
            text-align: left; /* Align text to the left */
            width: 100%; /* Full width */
            background-color: transparent; /* Transparent background */
            transition: background-color 0.3s; /* Smooth transition */
        }

        .dropdown-content button:hover {
            background-color: #9e4b4b; /* Background color on hover */
        }

        .center-menu {
            display: flex;
            justify-content: center;
            margin: 20px 0; /* Increased margin for better spacing */
            gap: 15px; /* Increased gap between buttons */
            flex-wrap: wrap; /* Wrap buttons on small screens */
        }

        .center-menu button {
			margin-top:30px;
            background-color: #4d305dde; /* Main button color */
            color: #fff; /* Text color */
            border: none; /* No border */
            padding: 12px 20px; /* Padding for better click area */
            border-radius: 8px; /* More rounded corners */
            font-size: 1.1em; /* Slightly larger text */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s, transform 0.3s; /* Smooth transition */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow for depth */
        }

        .center-menu button:hover {
            background-color: #ff6347; /* Darker shade on hover */
            transform: translateY(-3px); /* Lift effect on hover */
        }

        .center-menu button:active {
            transform: translateY(1px); /* Slightly lower when active */
        }

        .event-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            width: 100%; /* Full width for containers */
            margin-top: 20px;
        }

        .event-poster {
            background-color: #07080875;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%; /* Full width for posters */
            max-width: 300px; /* Max width for larger screens */
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .event-poster:hover {
            transform: translateY(-10px);
        }

        .poster {
            width: 100%;
            max-height: 500px;
            object-fit: cover; /* Adjusted to cover for better image filling */
        }

        .event-details {
            padding: 15px;
            text-align: center;
        }

        .event-details h3 {
            font-size: 1.4em;
            color: #333;
            margin-bottom: 10px;
        }

        .event-details p {
            font-size: 1.1em;
            color: #fff502;
            margin-bottom: 15px;
        }

        .event-details button {
            background-color: #4d305dde;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
			margin-bottom: 10px;
        }

        .event-details button:hover {
            background-color: #ff6347;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            margin: auto;
            max-width: 90%;
            max-height: 90%;
        }

        .modal-description {
            color: #fff;
            text-align: center;
            margin-top: 15px;
            font-size: 1.2em;
            max-width: 80%;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .content-section {
            margin-top: 20px;
            text-align: center;
        }

        .content-section h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .content-section p {
            font-size: 1.2em;
            color: #555;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .event-poster {
                width: 90%; /* Allow for more width on smaller screens */
            }

            nav button {
                font-size: 0.9em; /* Smaller font size */
            }

            .center-menu button {
                flex: 1 1 45%; /* Responsive button size */
            }

            .content-section h2 {
                font-size: 1.5em; /* Smaller font size for headings */
            }

            .content-section p {
                font-size: 1em; /* Smaller font size for paragraph text */
            }
        }

        @media (max-width: 480px) {
            nav button {
                font-size: 0.8em; /* Smaller font size */
            }

            .center-menu button {
                flex: 1 1 100%; /* Full width buttons */
            }

            .event-details h3 {
                font-size: 1.2em; /* Smaller heading font size */
            }

            .event-details p {
                font-size: 0.9em; /* Smaller paragraph font size */
            }
        }
        /* Existing styles for page layout */

        /* Additional styles for the modal */
        .rules-modal, .image-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0 0 0 / 44%);
            justify-content: center;
            align-items: center;
        }

        .rules-modal-content, .image-modal-content {
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 90%;
            max-height: 90%;
            text-align: center;
            width: 300px; /* Default size for rules modal */
        }

        .image-modal-content {
            max-width: 100%;
            max-height: 100%;
        }

        .rules-modal h3, .image-modal h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .rules-modal p {
            font-size: 1.2em;
            color: #333;
        }

        .rules-modal .close, .image-modal .close {
            color: #ff0000;
            float: right;
            font-size: 53px;
            font-weight: bold;
            cursor: pointer;
        }

        .full-screen-image {
            max-width: 100%;
            max-height: 100%;
        }
		
		<style>
    /* ... (existing styles remain here) */

    /* Adjustments for screens below 480px */
    @media (max-width: 480px) {
        body {
            padding: 5px;
            flex-direction: column;
            align-items: center;
        }

        nav {
            padding: 8px 15px;
        }

        .nav-container {
            flex-direction: column;
            gap: 10px;
        }

        .nav-links {
            flex-direction: column;
            gap: 10px;
        }

        .center-menu button {
            font-size: 0.9em; /* Adjusted for smaller screens */
            padding: 10px 12px;
            flex: 1 1 100%; /* Full-width buttons on mobile */
        }

        .event-container {
            gap: 15px;
            padding: 0 5px;
        }

        .event-poster {
            max-width: 100%; /* Full width for mobile */
            width: 100%;
        }

        .event-details h3 {
            font-size: 1.1em;
            margin-bottom: 8px;
        }

        .event-details p {
            font-size: 0.9em;
        }

        .content-section h2 {
            font-size: 1.3em;
        }

        .content-section p {
            font-size: 1em;
        }

        .rules-modal-content, .image-modal-content {
            padding: 15px;
            width: 90%;
        }

        .modal-description {
            font-size: 1em;
            max-width: 100%;
        }

        /* Reduce close icon size for mobile */
        .rules-modal .close, .image-modal .close {
            font-size: 30px;
        }
    }
</style>

    </style>
</head>
<body>
<nav>
    <div class="nav-container">
        <div class="nav-links">
            <button><a href="index.php" style="color: inherit; text-decoration: none;">Home</a></button>
            
            <!-- Show "Login" and "Register" only if the user is not logged in -->
            <?php if (!isset($_SESSION['user_id'])): ?>
                <button><a href="login.php" style="color: inherit; text-decoration: none;">Login</a></button>
                <button><a href="register.php" style="color: inherit; text-decoration: none;">Register</a></button>
            <?php endif; ?>
            
            <button><a href="cart.php" style="color: inherit; text-decoration: none;">Cart</a></button>
            
            <!-- Show "Account" dropdown only if the user is logged in -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="dropdown">
                    <button>Account</button>
                    <div class="dropdown-content">
                        <button><a href="profile.php" style="color: inherit; text-decoration: none;">Profile</a></button>
                        <button><a href="logout.php" style="color: inherit; text-decoration: none;">Logout</a></button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>


    </nav>

    <div class="center-menu">
        <button onclick="showContent('block_event')">Block Event</button>
        <button onclick="showContent('individual_event')">Individual Event</button>
        <button onclick="showContent('game_zone')">Game Zone</button>
    </div>

    <div class="content-section" id="contentSection">
        <!-- Dynamic content will be displayed here -->
    </div>

    <div class="event-container" id="eventContainer">
        <?php foreach ($events as $event): ?>
            <div class="event-poster" data-category="<?php echo htmlspecialchars($event['category']); ?>">
                <img src="<?php echo htmlspecialchars($event['poster']); ?>" alt="Event Poster" class="poster" onclick="openImageModal('<?php echo htmlspecialchars($event['poster']); ?>')">
                <div class="event-details">
                    <?php if ($event['category'] !== 'block'): ?>
                        <p>Price: ₹<?php echo htmlspecialchars($event['price']); ?></p>
                        <form action="cart.php" method="post">
                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                            <button type="submit">Add to Cart</button>
                        </form>
                    <?php endif; ?>
                    <button onclick="openRulesModal('<?php echo htmlspecialchars($event['description']); ?>')">Rules</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Rules Modal -->
    <div id="rulesModal" class="rules-modal">
        <div class="rules-modal-content">
            <span class="close" onclick="closeRulesModal()">&times;</span>
            <div id="rulesContent">
                <!-- Event description will be shown here dynamically -->
            </div>
        </div>
    </div>

    <!-- Image Modal for Full-Screen Poster -->
    <div id="imageModal" class="image-modal">
        <div class="image-modal-content">
            <span class="close" onclick="closeImageModal()">&times;</span>
            <img id="fullScreenImage" class="full-screen-image" src="" alt="Full Screen Poster">
        </div>
    </div>

    <script>
        // For showing the rules in a modal
        function openRulesModal(description) {
            const modal = document.getElementById("rulesModal");
            const rulesContent = document.getElementById("rulesContent");

            rulesContent.innerHTML = "<h3>Event Rules</h3><p>" + description + "</p>";
            modal.style.display = "flex";
        }

        function closeRulesModal() {
            const modal = document.getElementById("rulesModal");
            modal.style.display = "none";
        }

        // For showing full-screen event posters
        function openImageModal(imageSrc) {
            const modal = document.getElementById("imageModal");
            const fullScreenImage = document.getElementById("fullScreenImage");

            fullScreenImage.src = imageSrc;
            modal.style.display = "flex";
        }

        function closeImageModal() {
            const modal = document.getElementById("imageModal");
            modal.style.display = "none";
        }

        // For filtering events by category
        function showContent(section) {
            const contentSection = document.getElementById("contentSection");
            const eventContainers = document.querySelectorAll('.event-poster');

            contentSection.innerHTML = ""; // Clear the content section

            if (section === 'block_event') {
                contentSection.innerHTML = "<h2>Block Event</h2>";
                eventContainers.forEach(event => {
                    if (event.dataset.category !== 'block') {
                        event.style.display = 'none';
                    } else {
                        event.style.display = 'block';
                    }
                });
            } else if (section === 'individual_event') {
                contentSection.innerHTML = "<h2>Individual Event</h2>";
                eventContainers.forEach(event => {
                    if (event.dataset.category !== 'individual') {
                        event.style.display = 'none';
                    } else {
                        event.style.display = 'block';
                    }
                });
            } else if (section === 'game_zone') {
                contentSection.innerHTML = "<h2>Game Zone</h2>";
                eventContainers.forEach(event => {
                    if (event.dataset.category !== 'gamezone') {
                        event.style.display = 'none';
                    } else {
                        event.style.display = 'block';
                    }
                });
            } else {
                eventContainers.forEach(event => {
                    event.style.display = 'block';
                });
            }
        }
    </script>
</body>
</html>