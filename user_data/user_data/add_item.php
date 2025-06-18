<?php
// Connect to DB
$host = 'localhost';
$db = 'canteen';
$user = 'root';
$pass = '';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $name = $_POST['item_name'];
    $price = $_POST['item_price'];

    $stmt = $conn->prepare("INSERT INTO menu (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);

    if ($stmt->execute()) {
        header('Location: staff_menu.php'); // Redirect back to main page
        exit;
    } else {
        echo "Failed to add item.";
    }
}
?>
