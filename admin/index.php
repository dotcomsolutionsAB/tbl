    <?php
        // Database configuration
        require "../config.php";

        // Create a database connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Fetch all data from brands table
            // $stmt = $conn->prepare("SELECT b.*, c.name as category_name FROM brands b JOIN categories c ON b.category_id = c.id");
            $stmt = $conn->prepare("
            SELECT 
                b.*, 
                c.name AS category_name,
                u.name AS image_name 
            FROM 
                brands b 
            JOIN 
                categories c ON b.category_id = c.id
            LEFT JOIN 
                uploads u ON b.image_id = u.id");

            $stmt->execute();
            $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Brands Management</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        
        <div class="container mt-5">
        <div class="container">
            <a href="sheet.php" class="btn btn-warning btn-sm">Go To Sheet</a>
            <a href="insert_brand.php" class="btn btn-primary btn-sm">Add Brand</a>
        </div>
            <h2>Brands Table</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>URL</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sl = 1;   
                        foreach ($brands as $brand) { 
                    ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td><?= $brand['id'] ?></td>
                            <td><?= htmlspecialchars($brand['name']) ?></td>
                            <td><?= htmlspecialchars($brand['category_name']) ?></td>
                            <td><?= htmlspecialchars($brand['description']) ?></td>
                            <td>
                                <?php if (!empty($brand['url_link']) && $brand['url_link'] !== '#'): ?>
                                    <a href="<?= htmlspecialchars($brand['url_link']) ?>" target="_blank">Link</a>
                                <?php else: ?>
                                    <span>No Link</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($brand['image_name'])): ?>
                                    <img src="../uploads/images/<?= htmlspecialchars($brand['image_name']) ?>" alt="Photo" style="width: 50px; height: 50px;">
                                <?php else: ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="showUpdatePopup(<?= $brand['id'] ?>, '<?= addslashes($brand['name']) ?>', '<?= addslashes($brand['description']) ?>', '<?= addslashes($brand['url_link']) ?>', '<?= addslashes($brand['photos']) ?>')">Update</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteBrand(<?= $brand['id'] ?>)">Delete</button>
                                <button class="btn btn-info btn-sm" onclick="showUploadPopup(<?= $brand['id'] ?>)">Upload</button>
                            </td>
                        </tr>
                    <?php 
                    } 
                    
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Update Popup -->
        <div id="updatePopup" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Brand</h5>
                        <button type="button" class="btn-close" onclick="closePopup()"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm">
                            <input type="hidden" id="updateId">
                            <div class="mb-3">
                                <label for="updateName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="updateName" required>
                            </div>
                            <div class="mb-3">
                                <label for="updateDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="updateDescription" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="updateUrl" class="form-label">URL</label>
                                <input type="url" class="form-control" id="updateUrl">
                            </div>
                            <div class="mb-3">
                                <label for="updatePhoto" class="form-label">Photo</label>
                                <!-- <input type="text" class="form-control" id="updatePhotos"> -->
                                <img src="" alt="Photo preview" id="updatePhoto" style="width: 100px; height: 100px; margin-top: 10px; display: none;">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="submitUpdate()">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Modal -->
        <div id="uploadPopup" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Brand Photo</h5>
                        <button type="button" class="btn-close" onclick="closeUploadPopup()"></button>
                    </div>
                    <div class="modal-body">
                        <form id="uploadForm" enctype="multipart/form-data">
                            <input type="hidden" id="uploadId" name="uploadId">
                            <div class="mb-3">
                                <label for="uploadFile" class="form-label">Select Image</label>
                                <input type="file" class="form-control" id="uploadFile" name="photo" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-success">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Script -->
         <script>
            function showUploadPopup(id) {
                document.getElementById('uploadId').value = id;
                document.getElementById('uploadPopup').style.display = 'block';
            }
            function closeUploadPopup() {
                document.getElementById('uploadPopup').style.display = 'none';
            }

            // Handle file upload
            $('#uploadForm').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                formData.append('action', 'upload');

                $.ajax({
                    url: '',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        // alert('Photo uploaded successfully');
                        location.reload();
                    },
                    error: function(err) {
                        alert('Error uploading photo');
                    }
                });
            });
         </script>

        <!-- Update Script -->
        <script>
            function showUpdatePopup(id, name, description, url, photo) {
                document.getElementById('updateId').value = id;
                document.getElementById('updateName').value = name;
                document.getElementById('updateDescription').value = description;
                document.getElementById('updateUrl').value = url;
                // document.getElementById('updatePhotos').value = photo;

                document.getElementById('updatePhoto').src = photo; // ✅ Set preview
                document.getElementById('updatePhoto').style.display = 'block'; // ✅ Make sure it's visible

                document.getElementById('updatePopup').style.display = 'block';
            }

            function closePopup() {
                document.getElementById('updatePopup').style.display = 'none';
            }

            function deleteBrand(id) {
                if (confirm('Are you sure you want to delete this brand?')) {
                    $.post('', { action: 'delete', id: id }, function(response) {
                        location.reload();
                    });
                }
            }

            function submitUpdate() {
                const id = document.getElementById('updateId').value;
                const name = document.getElementById('updateName').value;
                const description = document.getElementById('updateDescription').value;
                const url = document.getElementById('updateUrl').value;
                const photo = document.getElementById('updatePhoto').value;

                $.post('', {
                    action: 'update',
                    id: id,
                    name: name,
                    description: description,
                    url: url,
                    photo: photo
                }, function(response) {
                    location.reload();
                });
            }
        </script>
    </body>
    </html>
    <?php
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            // For Delete
            if ($action === 'delete') {
                $id = $_POST['id'] ?? 0;
                $stmt = $conn->prepare("DELETE FROM brands WHERE id = :id");
                $stmt->execute([':id' => $id]);
                echo json_encode(["message" => "Brand deleted successfully"]);
                exit;
            }

            // For Update
            if ($action === 'update') {
                $id = $_POST['id'] ?? 0;
                $name = $_POST['name'] ?? '';
                $description = $_POST['description'] ?? '';
                $url = $_POST['url'] ?? '';
                $photo = $_POST['photo'] ?? '';

                $stmt = $conn->prepare("UPDATE brands SET name = :name, description = :description, url_link = :url, photos = :photo WHERE id = :id");
                $stmt->execute([
                    ':id' => $id,
                    ':name' => $name,
                    ':description' => $description,
                    ':url' => $url,
                    ':photo' => $photo
                ]);

                echo json_encode(["message" => "Brand updated successfully"]);
                exit;
            }

            // For Upload
            if ($action === 'upload') {
                $id = $_POST['uploadId'] ?? 0;
            
                if (!empty($_FILES['photo']['name'])) {
                    $uploadDir = '../uploads/images/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
            
                    // Step 1: Get current image_id from brands table
                    $stmt = $conn->prepare("SELECT image_id FROM brands WHERE id = :id");
                    $stmt->execute([':id' => $id]);
                    $brand = $stmt->fetch(PDO::FETCH_ASSOC);
            
                    if ($brand && !empty($brand['image_id'])) {
                        $imageId = $brand['image_id'];
            
                        // Step 2: Fetch file name from uploads table
                        $stmt = $conn->prepare("SELECT name FROM uploads WHERE id = :image_id");
                        $stmt->execute([':image_id' => $imageId]);
                        $upload = $stmt->fetch(PDO::FETCH_ASSOC);
            
                        if ($upload) {
                            $filePath = $uploadDir . $upload['name'];
            
                            // Step 3: Delete the file if it exists
                            if (file_exists($filePath)) {
                                unlink($filePath);
                            }
            
                            // Step 4: Delete record from uploads table
                            $stmt = $conn->prepare("DELETE FROM uploads WHERE id = :image_id");
                            $stmt->execute([':image_id' => $imageId]);
                        }
            
                        // Step 5: Set image_id to NULL in brands
                        $stmt = $conn->prepare("UPDATE brands SET image_id = NULL WHERE id = :id");
                        $stmt->execute([':id' => $id]);
                    }
            
                    // Step 6: Prepare new file info
                    $originalName = $_FILES['photo']['name'];
                    $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $newFileName = time() . '_' . uniqid() . '.' . $extension;
                    $targetFile = $uploadDir . $newFileName;

                    
            
                    // Step 7: Move uploaded file
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                        // Step 8: Insert new upload record
                        $stmt = $conn->prepare("
                            INSERT INTO uploads (name, path, extension, created_at, updated_at)
                            VALUES (:name, :path, :extension, NOW(), NOW())
                        ");
                        $stmt->execute([
                            ':name' => $newFileName,
                            ':path' => $targetFile,
                            ':extension' => $extension
                        ]);
                        $newImageId = $conn->lastInsertId();
            
                        // ✅ Set domain and image URL
                        $domain = 'https://abc.com';
                        $photoUrl = $domain . '/uploads/images/' . $newFileName;

                        // Step 9: Update brands table with new image_id
                        $stmt = $conn->prepare("UPDATE brands SET image_id = :image_id, photos = :photos WHERE id = :id");
                        $stmt->execute([
                            ':image_id' => $newImageId,
                            ':photos' => $photoUrl,
                            ':id' => $id
                        ]);
            
                        echo json_encode(["message" => "Photo uploaded and replaced successfully"]);
                    } else {
                        http_response_code(500);
                        echo json_encode(["message" => "Failed to move uploaded file"]);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(["message" => "No file uploaded"]);
                }
                exit;
            }
            
            
        }
    ?>
