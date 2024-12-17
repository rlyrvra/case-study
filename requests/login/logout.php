<?php require_once __DIR__ . '/../../includes/session.php'; ?>
<?php require_once __DIR__ . '/../../includes/file-locations.php' ?>

<?php
// Logout functionality
setcookie('remember_me', '', time() - 3600, '/', '', false, true); // Expire the cookie
session_destroy(); // Destroy the session
header("Location: https://". $SMARTWAGE_LOCATION ."/login.php?l=true");
?>