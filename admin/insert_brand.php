<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli('localhost', 'tbl_', 'Jzz4Qp1e5Za1k@can', 'tbl_');
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Initialize variables for feedback messages
$message = "";
$error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category_id = (int)$_POST['category_id'];
    $description = trim($_POST['description']);

    // Validate inputs
    if (empty($name) || empty($category_id)) {
        $error = "Brand name and category ID are required.";
    } elseif (!isset($_FILES['image']['name']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        $error = "A valid image file is required.";
    } else {
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
            $insertQuery = "INSERT INTO brands (name, category_id, description, image_path) VALUES (?, ?, ?, ?)";
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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Brand</title>
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

        <label for="category">Category ID:</label><br>
        <input type="number" id="category" name="category_id" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br><br>

        <label for="image">Brand Image:</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <button type="submit">Upload Brand</button>
    </form>
</body>
</html>

<?php
    // Close database connection
    $conn->close();
?>