<?php
header('Content-Type: application/json');

// DB connection
$host = 'localhost';
$db = 'canteen';
$user = 'root';
$pass = ''; // Default for XAMPP
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "DB Connection Failed"]);
    exit;
}

// Add Item (via HTML form)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_item'])) {
    $name = $_POST['item_name'];
    $price = $_POST['item_price'];

    $stmt = $conn->prepare("INSERT INTO menu (name, price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);
    if ($stmt->execute()) {
        header('Location: ' . $_SERVER['PHP_SELF']); // Refresh page on success
        exit;
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add item"]);
        exit;
    }
}

// Delete Item (via JS fetch)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['add_item'])) {
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    if (isset($data['id'])) {
        $id = $data['id'];
        $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Item deleted"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed"]);
        }
        exit;
    }
}

// Fetch Menu
$result = $conn->query("SELECT * FROM menu ORDER BY id ASC");
$menu = [];

while ($row = $result->fetch_assoc()) {
    $menu[] = $row;
}

echo json_encode(["status" => "success", "menu" => $menu]);
?>
