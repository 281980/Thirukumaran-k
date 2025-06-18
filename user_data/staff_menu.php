<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Canteen Menu | Staff Panel</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                  url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092') no-repeat center center/cover;
      background-size: cover;
      padding: 20px;
      color: black;
    }

    .home-btn {
      position: absolute;
      top: 20px;
      left: 20px;
      background-color: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(8px);
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: bold;
      cursor: pointer;
      color: white;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.4);
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .home-btn:hover {
      background-color: rgba(255, 255, 255, 0.4);
      box-shadow: 0 0 20px rgba(255, 255, 255, 0.6);
    }

    .login-container {
      background-color: rgba(255, 255, 255, 0.8);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 800px;
      margin: auto;
    }

    h2 {
      color: #2c3e50;
      text-align: center;
    }

    .menu-table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    .menu-table th, .menu-table td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }

    .menu-table th {
      background-color: #27ae60;
      color: black;
    }

    .add-item-form {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 10px;
    }

    .add-item-form input {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .add-item-form button {
      padding: 10px;
      background-color:#f39c12;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .add-item-form button:hover {
      background-color:#f39c12;
    }

    .delete-link {
      color: #e74c3c;
      text-decoration: none;
    }

    .delete-link:hover {
      text-decoration: underline;
    }

    .menu-item {
      margin: 15px;
      background-color: #fff;
      padding: 10px;
      border-radius: 6px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .menu-item button {
      background-color:#f39c12;
      color: white;
      padding: 5px 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .menu-item button:hover {
      background-color: darkred;
    }
  </style>
</head>
<body>

  <a class="home-btn" href="index.html.html">🏠 Home</a>

  <div class="login-container">
    <h2>Canteen Menu Management</h2>

    <!-- Add Item Form -->
    <form action="add_item.php" method="POST" class="add-item-form">
      <input type="text" name="item_name" placeholder="Item Name" required>
      <input type="number" name="item_price" placeholder="Item Price" required>
      <button type="submit" name="add_item">Add Item</button>
    </form>

    <!-- View Orders Button -->
    <div style="text-align: center; margin-top: 30px;">
      <button onclick="goToOrderPage()" style="background-color:#2980b9; padding: 12px 20px; font-size: 16px; border: none; border-radius: 6px; color: white; cursor: pointer;">
        View Orders
      </button>
    </div>

    <!-- Menu Items will be injected here -->
    <div class="menu-item" id="menu-container">
      <!-- Menu items will appear dynamically here -->
    </div>

    <!-- Orders Section -->
    <div id="orders-section" style="display:none;">
      <h2>Orders</h2>
      <div id="orders-container"></div>
    </div>

  </div>

  <script>
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const user = JSON.parse(localStorage.getItem('user')) || { name: 'Guest' }; // Assuming user details are stored in localStorage

    // Fetch menu from backend
    fetch('menu_api.php')
      .then(response => response.json())
      .then(data => {
        const menuContainer = document.getElementById('menu-container');
        menuContainer.innerHTML = ''; // Clear placeholder

        if (data.status === "success") {
          data.menu.forEach(item => {
            const div = document.createElement('div');
            div.className = 'menu-item';
            div.innerHTML = ` 
              <span>${item.name} - ₹${item.price}</span>
              <div>
                <button onclick='addToCart(${JSON.stringify(item)})'>Add</button>
                <button onclick="deleteItem(${item.id})">Delete</button>
              </div>
            `;
            menuContainer.appendChild(div);
          });
        } else {
          menuContainer.innerHTML += `<p>Failed to load menu.</p>`;
        }
      })
      .catch(error => {
        console.error('Error fetching menu:', error);
      });

    function addToCart(item) {
      cart.push(item);
      localStorage.setItem('cart', JSON.stringify(cart)); // Save to localStorage
      alert(`${item.name} has been added to your cart!`);
    }

    function deleteItem(id) {
      if (!confirm("Are you sure you want to delete this item?")) return;

      fetch('menu_api.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
      })
      .then(response => response.json())
      .then(data => {
        alert(data.message);
        location.reload(); // Refresh the list after deletion
      })
      .catch(error => {
        console.error('Error deleting item:', error);
      });
    }

    function viewOrder() {
      const ordersSection = document.getElementById('orders-section');
      const ordersContainer = document.getElementById('orders-container');
      ordersContainer.innerHTML = ''; // Clear the previous content

      if (cart.length === 0) {
        ordersContainer.innerHTML = '<p>No orders placed yet.</p>';
      } else {
        const userName = user.name; // Get user name from localStorage or backend
        const orderHeader = document.createElement('div');
        orderHeader.className = 'menu-item';
        orderHeader.innerHTML = `<strong>Order placed by: ${userName}</strong>`;
        ordersContainer.appendChild(orderHeader);

        cart.forEach(item => {
          const orderDiv = document.createElement('div');
          orderDiv.className = 'menu-item';
          orderDiv.innerHTML = ` 
            <span>${item.name} - ₹${item.price}</span>
          `;
          ordersContainer.appendChild(orderDiv);
        });
      }
      ordersSection.style.display = 'block'; // Show orders section
    }

    function goToOrderPage() {
      window.location.href = "staff_order.html";
    }
  </script>

</body>
</html>
