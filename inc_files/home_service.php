

<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  // Database configuration
  $host = 'localhost';
  $dbname = 'tbl_';
  $username = 'tbl_';
  $password = 'Jzz4Qp1e5Za1k@can';

  // Create a database connection
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // 2. Fetch brand data with JOINs
  $sql = "
  SELECT 
      b.id, 
      b.name AS brand_name,
      b.description,
      b.url_link,
      c.name AS category_name,
      u.name AS image_name
  FROM brands b
  LEFT JOIN categories c ON b.category_id = c.id
  LEFT JOIN uploads u ON b.image_id = u.id
  ";

  $result = $conn->query($sql);

  $products = [];

  if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $products[] = [
              "title" => $row['category_name'],
              "desc" => $row['brand_name'] . ' - ' . $row['description'],
              "image" => "assets/img/" . $row['image_name'],
              "link"  => $row['url_link']
          ];
      }
  } else {
      echo "No brand data found.";
      $conn->close();
      return;
  }

  $conn->close();
?>
  <div class="brand-slider" style="display: flex; gap: 20px; overflow-x: auto;">
    <?php foreach ($products as $product): ?>
        <div class="slide" style="min-width: 250px; border: 1px solid #ccc; padding: 10px; text-align: center;">
            <img src="<?= $product['image'] ?>" alt="Brand Image" style="width: 100%; max-height: 150px; object-fit: contain;">
            <h4 style="margin: 10px 0;"><?= $product['title'] ?></h4>
            <p><?= $product['desc'] ?></p>
            <a href="<?= $product['link'] ?>" target="_blank" style="display: inline-block; margin-top: 10px; background: #000; color: #fff; padding: 5px 10px; text-decoration: none;">Visit Brand</a>
        </div>
    <?php endforeach; ?>
  </div>