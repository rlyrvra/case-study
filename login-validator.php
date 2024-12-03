<?php include_once __DIR__ . '/database/database.php'; ?>
<?php require_once __DIR__ . '/includes/file-locations.php' ?>
<?php
// Check if the remember me cookie exists
if (isset($_COOKIE['remember_me'])) {
    list($selector, $token) = explode(':', $_COOKIE['remember_me']);

    // Retrieve the corresponding hashed token from the database
    $sql = "SELECT user_id, hashed_token, expires_at FROM remember_me_tokens WHERE selector = ? AND expires_at > NOW()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$selector]);

    $token_data = $stmt->fetch();

    if ($token_data) {
        // Validate the token
        if (hash('sha256', $token) === $token_data['hashed_token']) {
            // Token is valid, log the user in
            $_SESSION['id'] = $token_data['user_id'];
            // Fetch user data if needed (e.g., role) and set in session
        } else {
            // Invalid token, remove the cookie
            setcookie('remember_me', '', time() - 3600, '/', '', false, true);
        }
    } else {
        // Token expired or doesn't exist, remove the cookie
        setcookie('remember_me', '', time() - 3600, '/', '', false, true);
    }
}
?>

<?php
if (isset($_SESSION['id'])){
    header("Location: ". $SMARTWAGE_LOCATION . "/smartWage-index.php?s=true");
    exit;
}
?>