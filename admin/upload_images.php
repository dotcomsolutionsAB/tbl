<?php
// Database configuration
require "../config.php";

// Create a database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Fetch brands where image_id is 0
$stmt = $conn->prepare("SELECT id, photos FROM brands WHERE image_id = 0");
$stmt->execute();
$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$brands) {
    echo json_encode(["message" => "No brands with image_id = 0 found."]);
    exit;
}

// Directory to save images
$imageDir = '../uploads/images/';
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0777, true);
}

$downloadedCount = 0;
$failedLinks = [];

foreach ($brands as $brand) {
    $brandId = $brand['id'];
    $photoUrl = $brand['photos'];

    // Validate photo URL
    if (!filter_var($photoUrl, FILTER_VALIDATE_URL)) {
        $failedLinks[] = $photoUrl;
        continue;
    }

    // Get image content
    $imageContent = @file_get_contents($photoUrl);
    if ($imageContent === false) {
        $failedLinks[] = $photoUrl;
        continue;
    }

    // Get file extension
    $extension = pathinfo(parse_url($photoUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (!$extension) {
        $failedLinks[] = $photoUrl;
        continue;
    }

    // Generate unique file name
    $imageName = uniqid('img_') . '.' . $extension;
    $imagePath = $imageDir . $imageName;

    // Save image to directory
    if (file_put_contents($imagePath, $imageContent) === false) {
        $failedLinks[] = $photoUrl;
        continue;
    }

    // Insert image details into uploads table
    $stmt = $conn->prepare("INSERT INTO uploads (name, path, extension, created_at, updated_at) VALUES (:name, :path, :extension, NOW(), NOW())");
    $stmt->execute([
        ':name' => $imageName,
        ':path' => $imagePath,
        ':extension' => $extension
    ]);

    $uploadId = $conn->lastInsertId();

    // Update brands table with the new image_id
    $stmt = $conn->prepare("UPDATE brands SET image_id = :image_id WHERE id = :id");
    $stmt->execute([
        ':image_id' => $uploadId,
        ':id' => $brandId
    ]);

    $downloadedCount++;
}

// Output results
$response = [
    "message" => "Image processing completed.",
    "downloaded_count" => $downloadedCount,
    "failed_links" => $failedLinks
];

echo json_encode($response);
