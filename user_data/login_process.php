<?php
// Get the login credentials from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Read the registration data from the text file
$file = "user_data/registrations.txt";
$data = file_get_contents($file);

// Check if the username and password match any data in the file
if (strpos($data, "Username: $username") !== false && strpos($data, "Password: $password") !== false) {
    // Successful login - redirect to home page
    header('Location: home.html');
    exit;
} else {
    // Login failed - show an error message
    echo "<h2>Login Failed</h2>";
    echo "<p>Invalid username or password. <a href='login.html'>Try again</a>.</p>";
}
?>
