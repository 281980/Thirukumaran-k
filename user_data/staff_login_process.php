<?php
// Hardcoded staff credentials (for testing)
$staff_username = "admin";
$staff_password = "admin123";

// Get the login credentials from the form
$entered_username = $_POST['staff_username'];
$entered_password = $_POST['staff_password'];

// Check if the credentials match
if ($entered_username === $staff_username && $entered_password === $staff_password) {
    // If login is successful, redirect to the staff menu page
    header('Location: staff_menu.php');
    exit;
} else {
    // If login fails, show an error
    echo "<h2>Login Failed</h2>";
    echo "<p>Invalid username or password. <a href='staff_login.html'>Try again</a>.</p>";
}
?>
