<?php
// Database configuration
$host = 'localhost';
$dbname = 'tbl_';
$username = 'tbl_';
$password = 'Jzz4Qp1e5Za1k@can';

// Create a database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Logging function
function logMessage($message) {
    file_put_contents('process_log.txt', date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
}

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
    logMessage("Processing sheet: " . $sheet['name']);

    // Check if the path is a URL
    if (filter_var($spreadsheetPath, FILTER_VALIDATE_URL)) {
        $csvContent = @file_get_contents($spreadsheetPath);
        if ($csvContent === false) {
            logMessage("Failed to fetch the sheet: " . $sheet['name']);
            continue;
        }

        $lines = explode(PHP_EOL, $csvContent);
        $data = array_map('str_getcsv', $lines);
    } else {
        if (!file_exists($spreadsheetPath)) {
            logMessage("File not found: " . $spreadsheetPath);
            continue;
        }

        $file = fopen($spreadsheetPath, 'r');
        $data = [];
        while (($row = fgetcsv($file)) !== false) {
            $data[] = $row;
        }
        fclose($file);
    }

    if (count($data) < 2) { // Ensure there is data beyond the header row
        logMessage("No data found in the sheet: " . $sheet['name']);
        continue;
    }

    $headers = array_shift($data);

    $addedCount = 0;
    $updatedCount = 0;
    $incompleteCount = 0;
    $totalRows = count($data);

    try {
        $conn->beginTransaction();

        foreach ($data as $row) {
            $sn = $row[0] ?? null;
            $categoryName = trim($row[1] ?? '');
            $name = trim($row[2] ?? '');
            $description = trim($row[3] ?? '');
            $url = trim($row[4] ?? '');
            $photo = trim($row[5] ?? '');

            if (!$categoryName || !$name) {
                $incompleteCount++;
                continue;
            }

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

            $stmt = $conn->prepare("SELECT id FROM brands WHERE name = :name");
            $stmt->execute([':name' => $name]);
            $brand = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$brand) {
                $stmt = $conn->prepare(
                    "INSERT INTO brands (name, category_id, description, url_link, photos, image_id) VALUES (:name, :category_id, :description, :url_link, :photos, :image_id)"
                );
                $stmt->execute([
                    ':name' => $name,
                    ':category_id' => $categoryId,
                    ':description' => $description,
                    ':url_link' => $url,
                    ':photos' => $photo,
                    ':image_id' => 0
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
                $updatedCount++;
            }
        }

        $stmt = $conn->prepare("UPDATE google_sheet SET status = 1 WHERE id = :id");
        $stmt->execute([':id' => $sheet['id']]);

        $conn->commit();

        $response = [
            "message" => "Sheet processed successfully.",
            "sheet_name" => $sheet['name'],
            "total_rows" => $totalRows,
            "added_count" => $addedCount,
            "updated_count" => $updatedCount,
            "incomplete_count" => $incompleteCount
        ];

        logMessage(json_encode($response));
        echo json_encode($response);

    } catch (Exception $e) {
        $conn->rollBack();
        logMessage("Error processing sheet " . $sheet['name'] . ": " . $e->getMessage());
        echo json_encode(["message" => "Error processing sheet: " . $e->getMessage()]);
    }
}
?>
