<?php
session_start();
session_destroy(); // Destroy the session
header('Location: manager_login.php'); // Redirect to login page after logging out
exit;
?>
