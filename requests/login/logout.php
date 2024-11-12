<?php require_once __DIR__ . '/../../includes/session.php'; ?>

<?php
// Logout functionality
setcookie('remember_me', '', time() - 3600, '/', '', false, true); // Expire the cookie
session_destroy(); // Destroy the session
header("Location: /case-study/login.php?l=true");
?>