<?php
    // Database connection
    $conn = new mysqli('localhost', 'tbl_', 'Jzz4Qp1e5Za1k@can', 'tbl_');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check the status of the Google Sheets table
    $sheetQuery = "SELECT * FROM google_sheet WHERE status = 0 LIMIT 1";
    $sheetResult = $conn->query($sheetQuery);
    if ($sheetResult->num_rows == 0) {
        echo "No sheets to process.<br>\n";
        exit;
    }
    $sheet = $sheetResult->fetch_assoc();

    // Path to the Google Sheet (assumed to be a CSV URL)
    $sheetPath = $sheet['path'];
    echo "Checking file at path: $sheetPath<br>\n";

    // Fetch the Google Sheet content
    $sheetContent = file_get_contents($sheetPath);
    if ($sheetContent === false) {
        echo "Failed to fetch the sheet content from: $sheetPath<br>\n";
        exit;
    }

    echo "File content fetched successfully.<br>\n";

    // Convert the content into an array
    $sheetData = array_filter(array_map('str_getcsv', explode("\n", $sheetContent)), function($row) {
        return array_filter($row); // Filter out completely empty rows
    });
    $headers = array_map('trim', $sheetData[0]);
    array_shift($sheetData); // Remove headers row

    $insertCount = 0;
    $skippedRows = [];

    foreach ($sheetData as $rowIndex => $row) {
        // Skip empty or whitespace-only rows
        if (empty(trim(implode('', $row)))) {
            $skippedRows[] = ["row" => $rowIndex + 2, "issue" => "Empty row"];
            continue;
        }

        // Check for header and row field count mismatch
        if (count($row) < count($headers)) {
            $skippedRows[] = ["row" => $rowIndex + 2, "issue" => "Incomplete row (header/field mismatch)"];
            continue;
        }

        $rowData = array_combine($headers, $row);

        // Skip rows with empty 'Name' field
        if (empty(trim($rowData['Name']))) {
            $skippedRows[] = ["row" => $rowIndex + 2, "issue" => "Name column is empty"];
            continue;
        }

        echo "Processing row: " . json_encode($rowData) . "<br>\n";

        // Check or insert category
        $categoryName = trim($rowData['Category']);
        $categoryQuery = "SELECT id FROM categories WHERE name = ?";
        $stmt = $conn->prepare($categoryQuery);
        $stmt->bind_param('s', $categoryName);
        if (!$stmt->execute()) {
            echo "Error selecting category: " . $stmt->error . "<br>\n";
            continue;
        }
        $stmt->bind_result($categoryId);
        if (!$stmt->fetch()) {
            $stmt->close();
            echo "Category not found. Inserting: {$categoryName}<br>\n";
            $insertCategoryQuery = "INSERT INTO categories (name) VALUES (?)";
            $insertStmt = $conn->prepare($insertCategoryQuery);
            $insertStmt->bind_param('s', $categoryName);
            if (!$insertStmt->execute()) {
                echo "Error inserting category: " . $insertStmt->error . "<br>\n";
                $insertStmt->close();
                continue;
            }
            $categoryId = $insertStmt->insert_id;
            $insertStmt->close();
            echo "Inserted category with ID: {$categoryId}<br>\n";
        } else {
            $stmt->close();
            echo "Found category ID: {$categoryId} for '{$categoryName}'<br>\n";
        }

        // Insert brand
        $brandName = trim($rowData['Name']);
        $description = $rowData['Description'] ?: null;
        $urlLink = $rowData['URL'] ?: null;
        $photo = $rowData['Photo'] ?: null;

        echo "Inserting brand: {$brandName}<br>\n";
        $insertBrandQuery = "INSERT INTO brands (name, category_id, description, image_id, url_link, photos) VALUES (?, ?, ?, 0, ?, ?)";
        $insertStmt = $conn->prepare($insertBrandQuery);
        $insertStmt->bind_param('sisss', $brandName, $categoryId, $description, $urlLink, $photo);
        if (!$insertStmt->execute()) {
            echo "Error inserting brand: " . $insertStmt->error . "<br>\n";
            continue;
        }
        echo "Inserted new brand ID: {$insertStmt->insert_id}<br>\n";
        $insertCount++;
        $insertStmt->close();
    }

    // Update the Google Sheets table status
    $updateSheetQuery = "UPDATE google_sheet SET status = 1 WHERE id = ?";
    $stmt = $conn->prepare($updateSheetQuery);
    $stmt->bind_param('i', $sheet['id']);
    if (!$stmt->execute()) {
        echo "Error updating sheet status: " . $stmt->error . "<br>\n";
    } else {
        echo "Sheet status updated successfully.<br>\n";
    }
    $stmt->close();

    // Summary
    echo "Insertion Count: $insertCount<br>\n";
    if (!empty($skippedRows)) {
        echo "Skipped Rows:<br>\n";
        foreach ($skippedRows as $row) {
            echo "Row {$row['row']}: {$row['issue']}<br>\n";
        }
    }

    // Close connection
    $conn->close();
?>
