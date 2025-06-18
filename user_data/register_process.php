<?php
// Get the form data from the registration page
$fullname = $_POST['fullname'];
$regno = $_POST['regno'];
$username = $_POST['username'];
$password = $_POST['password'];

// Format the user data to save in the text file
$userData = "Full Name: $fullname\nRegister Number: $regno\nUsername: $username\nPassword: $password\n--------------------\n";

// Define the file path where the data will be saved
$file = "user_data/registrations.txt";

// Create the folder if it doesn't exist
if (!file_exists("user_data")) {
    mkdir("user_data", 0777, true);
}

// Append the registration data to the text file
file_put_contents($file, $userData, FILE_APPEND);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Success</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                  url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092') no-repeat center center/cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #f1f1f1;
    }

    .success-container {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(12px);
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      text-align: center;
      max-width: 500px;
      animation: fadeGlow 1s ease-in-out;
    }

    @keyframes fadeGlow {
      from {
        opacity: 0;
        transform: scale(0.95);
        box-shadow: 0 0 0 rgba(0, 255, 204, 0);
      }
      to {
        opacity: 1;
        transform: scale(1);
        box-shadow: 0 0 25px rgba(0, 255, 204, 0.3);
      }
    }

    h2 {
      font-size: 28px;
      margin-bottom: 15px;
    }

    p {
      font-size: 16px;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      margin: 8px;
      padding: 12px 20px;
      background-color: #00b894;
      color: white;
      text-decoration: none;
      border-radius: 12px;
      font-weight: bold;
      font-size: 14px;
      transition: all 0.3s ease;
      box-shadow: 0 0 10px rgba(0, 255, 204, 0.3);
    }

    .btn:hover {
      background-color: #00cec9;
      box-shadow: 0 0 20px rgba(0, 255, 204, 0.6);
    }

    @media (max-width: 500px) {
      .success-container {
        margin: 0 20px;
      }
    }
  </style>
</head>
<body>

  <div class="success-container">
    <h2>🎉 Registration Successful!</h2>
    <p>Your data has been saved securely.</p>
    <a class="btn" href="register.html">🔁 Register Again</a>
    <a class="btn" href="user-login.html">🔐 Go to Login</a>
    <a class="btn" href="index.html.html">🏠 Go to Home</a>
  </div>

</body>
</html>
