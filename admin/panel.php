<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Nav and Sidebar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
        }

        /* Navigation Bar */
        .navbar {
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar .logo {
            font-size: 1.5em;
            font-weight: bold;
        }

        .navbar .menu {
            display: flex;
            gap: 15px;
        }

        .navbar .menu a {
            color: white;
            text-decoration: none;
            font-size: 1em;
        }

        .navbar .menu-toggle {
            display: none;
            font-size: 1.5em;
            cursor: pointer;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #444;
            color: white;
            position: fixed;
            top: 0;
            left: -250px;
            height: 100%;
            padding: 20px;
            transition: 0.3s;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .content {
            margin-left: 0;
            padding: 20px;
            transition: 0.3s;
        }

        .sidebar.open ~ .content {
            margin-left: 250px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .navbar .menu {
                display: none;
            }

            .navbar .menu-toggle {
                display: block;
            }

            .sidebar {
                width: 200px;
            }

            .sidebar.open ~ .content {
                margin-left: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">My Website</div>
        <div class="menu-toggle" onclick="toggleSidebar()">&#9776;</div>
        <div class="menu">
            <a href="#">Home</a>
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="#">Contact</a>
        </div>
    </div>

    <div class="sidebar" id="sidebar">
        <a href="#">Dashboard</a>
        <a href="#">Profile</a>
        <a href="#">Settings</a>
        <a href="#">Logout</a>
    </div>

    <div class="content">
        <h1>Welcome to My Website</h1>
        <p>This is a fully responsive layout with a navigation bar and a sidebar. Resize your browser to see the responsiveness in action.</p>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }
    </script>
</body>
</html>
