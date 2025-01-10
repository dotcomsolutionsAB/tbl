<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    /* Navigation Bar */
    nav {
      background-color: #333;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.5rem 1rem;
    }

    nav .menu-icon {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
    }

    nav ul {
      list-style: none;
      display: flex;
    }

    nav ul li {
      margin: 0 1rem;
    }

    nav ul li a {
      text-decoration: none;
      color: white;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: -250px;
      width: 250px;
      height: 100%;
      background-color: #222;
      color: white;
      padding: 1rem;
      transition: left 0.3s ease;
    }

    .sidebar.active {
      left: 0;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
    }

    .sidebar ul li {
      margin: 1rem 0;
    }

    .sidebar ul li a {
      text-decoration: none;
      color: white;
      display: block;
      padding: 0.5rem;
      border-radius: 5px;
      transition: background-color 0.2s ease;
    }

    .sidebar ul li a:hover {
      background-color: #444;
    }

    /* Main Content */
    .content {
      margin-left: 0;
      padding: 1rem;
      transition: margin-left 0.3s ease;
    }

    .content.shift {
      margin-left: 250px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      nav ul {
        display: none;
      }

      nav .menu-icon {
        display: block;
      }

      .content {
        margin-left: 0;
      }

      .content.shift {
        margin-left: 0;
      }

      .sidebar {
        width: 200px;
      }

      .sidebar.active {
        left: 0;
      }
    }
  </style>
</head>
<body>
  <nav>
    <div class="menu-icon" onclick="toggleSidebar()">&#9776;</div>
    <h1>Brand Name</h1>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Services</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav>

  <div class="sidebar" id="sidebar">
    <ul>
      <li><a href="#">Dashboard</a></li>
      <li><a href="#">Profile</a></li>
      <li><a href="#">Settings</a></li>
      <li><a href="#">Logout</a></li>
    </ul>
  </div>

  <div class="content" id="content">
    <h2>Responsive Navigation and Sidebar</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt, dolor ut bibendum consectetur, lorem odio ultrices tortor, id vehicula metus justo et lorem.</p>
  </div>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const content = document.getElementById('content');
      sidebar.classList.toggle('active');
      content.classList.toggle('shift');
    }
  </script>
</body>
</html>
