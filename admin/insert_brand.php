<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli('127.0.0.1', 'tbl_', '2?A18bzc4', 'tbl_');  //live

// $conn = new mysqli('localhost', 'root', '', 'tbl_');  //local
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch categories dynamically
$categories = [];
$categoryQuery = "SELECT id, name FROM categories ORDER BY name ASC";
$result = $conn->query($categoryQuery);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Initialize variables for feedback messages
$message = "";
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $description = trim($_POST['description']);
    $new_category_name = trim($_POST['new_category'] ?? '');

    // Validate inputs
    if (empty($name)) {
        $error = "Brand name is required.";
    } elseif (empty($category_id) && empty($new_category_name)) {
        $error = "Please select a category or add a new one.";
    } elseif (!isset($_FILES['image']['name']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        $error = "A valid image file is required.";
    } else {
        // If "Other" is selected, insert the new category
        if ($category_id === 0 && !empty($new_category_name)) {
            $checkCategoryQuery = "SELECT id FROM categories WHERE name = ?";
            $stmt = $conn->prepare($checkCategoryQuery);
            $stmt->bind_param("s", $new_category_name);
            $stmt->execute();
            $stmt->bind_result($existingCategoryId);
            if ($stmt->fetch()) {
                $category_id = $existingCategoryId;
                $stmt->close();
            } else {
                $stmt->close();
                $insertCategoryQuery = "INSERT INTO categories (name) VALUES (?)";
                $stmt = $conn->prepare($insertCategoryQuery);
                $stmt->bind_param("s", $new_category_name);
                if ($stmt->execute()) {
                    $category_id = $stmt->insert_id;
                    $stmt->close();
                } else {
                    $error = "Error adding new category: " . $stmt->error;
                    $stmt->close();
                }
            }
        }

        if (!$error) {
            // Handle file upload
            $targetDir = "../uploads/images/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
            }

            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . uniqid() . "_" . $fileName; // Unique name to avoid overwrites
            $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Validate file type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedTypes)) {
                $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            } elseif (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                $error = "There was an error uploading the image.";
            } else {
                // Insert into the database
                $insertQuery = "INSERT INTO brands (name, category_id, description, photos) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("siss", $name, $category_id, $description, $targetFilePath);

                if ($stmt->execute()) {
                    $message = "Brand uploaded successfully with ID: " . $stmt->insert_id . "<br>Image path: " . $targetFilePath;
                } else {
                    $error = "Error inserting brand: " . $stmt->error;
                }

                $stmt->close();
            }
        }
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Brand</title>
    <script>
        function toggleNewCategoryInput() {
            const categorySelect = document.getElementById('category');
            const newCategoryInput = document.getElementById('new-category-input');
            if (categorySelect.value === "0") {
                newCategoryInput.style.display = 'block';
            } else {
                newCategoryInput.style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <h1>Upload Brand</h1>
    <?php if (!empty($message)): ?>
        <p style="color: green;"><?= $message ?></p>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Brand Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="category">Category:</label><br>
        <select id="category" name="category_id" onchange="toggleNewCategoryInput()" required>
            <option value="" disabled selected>Select a category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
            <?php endforeach; ?>
            <option value="0">Other</option>
        </select><br><br>

        <div id="new-category-input" style="display: none;">
            <label for="new-category">New Category Name:</label><br>
            <input type="text" id="new-category" name="new_category"><br><br>
        </div>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br><br>

        <label for="image">Brand Image:</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <button type="submit">Upload Brand</button>
    </form>
</body>
</html>
