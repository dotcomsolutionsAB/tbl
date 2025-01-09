<?php
// Database configuration
$host = 'localhost';
$dbname = 'your_database_name';
$username = 'tbl_';
$password = 'Jzz4Qp1e5Za1k@can';

// Create a database connection
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch Google Sheet paths where status == 0
$stmt = $conn->prepare("SELECT * FROM google_sheet WHERE status = 0");
$stmt->execute();
$googleSheets = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$googleSheets) {
    echo json_encode(["message" => "No Google Sheets with status 0 found."]);
    exit;
}

foreach ($googleSheets as $sheet) {
    $spreadsheetPath = $sheet['path'];

    if (!file_exists($spreadsheetPath)) {
        echo json_encode(["message" => "File not found: " . $spreadsheetPath]);
        continue;
    }

    // Open the file and read data
    $file = fopen($spreadsheetPath, 'r');
    $data = [];
    while (($row = fgetcsv($file)) !== false) {
        $data[] = $row;
    }
    fclose($file);

    if (count($data) < 2) { // Ensure there is data beyond the header row
        echo json_encode(["message" => "No data found in the sheet: " . $sheet['name']]);
        continue;
    }

    // Skip the header row
    $headers = array_shift($data);

    $addedCount = 0;
    $incompleteCount = 0;

    foreach ($data as $row) {
        $sn = $row[0] ?? null;
        $categoryName = $row[1] ?? null;
        $name = $row[2] ?? null;
        $description = $row[3] ?? null;
        $url = $row[4] ?? null;
        $photo = $row[5] ?? null;

        if (!$categoryName || !$name) {
            $incompleteCount++;
            continue; // Skip rows with missing essential data
        }

        // Insert or fetch the category ID
        $stmt = $conn->prepare("SELECT id FROM categories WHERE name = :name");
        $stmt->execute([':name' => $categoryName]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->execute([':name' => $categoryName]);
            $categoryId = $conn->lastInsertId();
        } else {
            $categoryId = $category['id'];
        }

        // Insert or update the brand
        $stmt = $conn->prepare("SELECT id FROM brands WHERE name = :name");
        $stmt->execute([':name' => $name]);
        $brand = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$brand) {
            $stmt = $conn->prepare(
                "INSERT INTO brands (name, category_id, description, url_link, photos) VALUES (:name, :category_id, :description, :url_link, :photos)"
            );
            $stmt->execute([
                ':name' => $name,
                ':category_id' => $categoryId,
                ':description' => $description,
                ':url_link' => $url,
                ':photos' => $photo
            ]);
            $addedCount++;
        } else {
            $stmt = $conn->prepare(
                "UPDATE brands SET category_id = :category_id, description = :description, url_link = :url_link, photos = :photos WHERE id = :id"
            );
            $stmt->execute([
                ':id' => $brand['id'],
                ':category_id' => $categoryId,
                ':description' => $description,
                ':url_link' => $url,
                ':photos' => $photo
            ]);
        }
    }

    // Update the google_sheet status to 0
    $stmt = $conn->prepare("UPDATE google_sheet SET status = 0 WHERE id = :id");
    $stmt->execute([':id' => $sheet['id']]);

    echo json_encode([
        "message" => "Sheet processed successfully.",
        "sheet_name" => $sheet['name'],
        "added_count" => $addedCount,
        "incomplete_count" => $incompleteCount
    ]);
}
