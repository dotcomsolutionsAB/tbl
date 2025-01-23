<?php
  include("connection.php"); 

  // Check if a category_id is passed
  if (isset($_GET['category_id'])) {
      $categoryId = intval($_GET['category_id']);

      // Fetch brands for the specific category
      $stmt = $conn->prepare("SELECT b.*, c.name as category_name FROM brands b JOIN categories c ON b.category_id = c.id WHERE b.category_id = :category_id");
      $stmt->execute([':category_id' => $categoryId]);
      $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
      echo "<p>No category selected.</p>";
      exit;
  }
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Laralink">
    <!-- Favicon Icon -->
    <link rel="icon" href="assets/img/favicon.png">
    <!-- Site Title -->
    <title>Carbon Brush Technology</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/plugins/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/plugins/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/plugins/slick.css">
    <link rel="stylesheet" href="assets/css/plugins/animate.css">
    <link rel="stylesheet" href="assets/css/plugins/swiper.min.css">
    <link rel="stylesheet" href="assets/css/plugins/odometer.css">
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <!-- <div class="cs_preloader cs_accent_color cs_white_bg">
      <div class="cs_preloader bg-white d-flex justify-content-center align-items-center">
        <div class="cs_preloader_in">
          <img src="assets/img/favicon.png" alt="Logo">
        </div>
      </div>
    </div> -->

      <!-- Start Header Section -->
    <?php include("inc_files/header2.php"); ?>
      <!-- End Header Section -->

    <!-- Start Page Header -->
    <section class="cs_page_header position-relative background-filled d-flex align-items-center justify-content-between" data-src="assets/img/page_header_1.jpg">
      <div class="container position-relative z-index-1">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb text-white cs_fs_18 cs_mb_5">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <?php
              if (!empty($brands)) {
                // Get the category name from the first brand record
                $categoryName = $brands[0]['category_name'];
            ?>
              <li class="breadcrumb-item active"><?php echo $categoryName; ?></li>
            <?php              
              }
            ?>
          </ol>
        </nav>
        <h1 class="cs_fs_48 cs_fs_lg_36 text-white m-0"><?php echo $categoryName; ?></h1>
      </div>
      <div class="position-absolute end-0 bottom-0">
        <svg width="660" height="497" viewBox="0 0 660 497" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M240 0H660L430 497H0L240 0Z" fill="url(#paint0_linear_81_9510)"/>
          <defs>
          <linearGradient id="paint0_linear_81_9510" x1="330" y1="78.2497" x2="375.052" y2="780.743" gradientUnits="userSpaceOnUse">
          <stop stop-color="white" stop-opacity="0" offset="none"/>
          <stop offset="0.9999" stop-color="#D9D9D9" stop-opacity="0.35"/>
          <stop offset="1" stop-color="#222121" stop-opacity="0"/>
          <stop offset="1" stop-color="#222121" stop-opacity="0"/>
          </linearGradient>
          </defs>
        </svg> 
      </div>       
    </section>
    <!-- End Page Header -->

    <!-- Start Service Section -->
    
    <style>
      .cs_service.cs_style_1 .cs_service_thumb-in {
          display: flex;
          justify-content: center;
          align-items: center;
      }
    </style>
  <!-- <h3>Brands in Category: <?= htmlspecialchars($brands[0]['category_name'] ?? 'Unknown') ?></h3> -->
  <section class="cs_pb_140 cs_pb_lg_80">
    <div class="container-fluid">
      <div class="cs_service_slider_2 cs_gap_24">
        <div class="cs_slider_activate">
        
        <?php foreach ($brands as $brand): ?>
          <div class="cs_slide">
            <div class="cs_service cs_style_1 cs_type_1 cs_pt_25 cs_pl_25 cs_pr_25 cs_pb_15 bg-white cs_transition_4 shadow cs_mb_25">
              <div class="cs_service_thumb position-relative cs_rounded_5 cs_mb_25">
                <div class="cs_service_thumb-in position-relative-in background-filled h-100" data-src="">
                  <img src="<?= htmlspecialchars($brand['photos']); ?>" alt="brands" >
                </div>
              </div>
              <div class="cs_service_iconbox d-flex align-items-center cs_mb_20">
                <h2 class="cs_lh_base cs_fs_20 cs_fs_lg_18 m-0">
                  <a href="<?= htmlspecialchars($brand['url_link']) ?>" class="inline-block">
                      <?= htmlspecialchars($brand['name']) ?>
                  </a>
                </h2>
              </div>
              <p class="cs_mb_20"><?= htmlspecialchars($brand['description']) ?></p>
              <div class="text-primary">
                <a href="<?= htmlspecialchars($brand['url_link']) ?>" class="cs_post_btn_2 d-inline-flex justify-content-between align-items-center cs_column_gap_10">
                  <span class="cs_post_btn-text">Read More</span>
                  <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.9505 5.44725C14.9547 5.44105 14.9583 5.43463 14.9621 5.42827C14.9656 5.42241 14.9692 5.41669 14.9725 5.41066C14.9759 5.40418 14.9789 5.39751 14.982 5.3909C14.985 5.38461 14.9881 5.37844 14.9908 5.372C14.9934 5.36559 14.9956 5.35902 14.9979 5.3525C15.0004 5.34559 15.003 5.33877 15.0052 5.3317C15.0071 5.32519 15.0086 5.31857 15.0102 5.312C15.0121 5.3048 15.0141 5.29767 15.0155 5.29034C15.017 5.28274 15.0179 5.27507 15.019 5.26744C15.02 5.26099 15.0212 5.25466 15.0218 5.24814C15.0232 5.23406 15.0239 5.21991 15.024 5.20576C15.024 5.20554 15.024 5.20532 15.024 5.20512C15.024 5.20492 15.024 5.20469 15.024 5.20448C15.0239 5.19035 15.0232 5.17621 15.0218 5.1621C15.0212 5.15556 15.02 5.14925 15.019 5.1428C15.0179 5.13517 15.017 5.12749 15.0155 5.1199C15.0141 5.11256 15.0121 5.10544 15.0102 5.09824C15.0086 5.09167 15.0071 5.08505 15.0052 5.07854C15.003 5.07149 15.0004 5.06465 14.9979 5.05774C14.9956 5.05122 14.9934 5.04467 14.9908 5.03824C14.9881 5.0318 14.985 5.02562 14.982 5.01934C14.9789 5.01272 14.9759 5.00606 14.9725 4.99958C14.9692 4.99355 14.9656 4.98781 14.9621 4.98197C14.9583 4.97561 14.9547 4.96918 14.9505 4.96299C14.9462 4.9565 14.9414 4.9504 14.9367 4.94415C14.9328 4.93902 14.9293 4.93373 14.9252 4.92872C14.916 4.91758 14.9064 4.90689 14.8962 4.89672L10.887 0.88748C10.7167 0.717156 10.4405 0.717155 10.2702 0.88748C10.0999 1.0578 10.0999 1.33395 10.2702 1.50427L13.5349 4.76894L1.01817 4.76893C0.777297 4.76893 0.582021 4.96421 0.582021 5.20508C0.582021 5.44595 0.777297 5.64123 1.01817 5.64123L13.5349 5.64122L10.2702 8.9059C10.0999 9.07622 10.0999 9.35236 10.2702 9.52269C10.4405 9.69301 10.7167 9.69303 10.887 9.5227L14.8962 5.51349C14.9064 5.50333 14.916 5.49264 14.9251 5.48153C14.9292 5.47652 14.9328 5.47125 14.9367 5.46609C14.9414 5.45984 14.9462 5.45374 14.9505 5.44725Z" fill="currentColor"></path>
                  </svg>                                  
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
    <!-- End Service Section -->

    <!-- Start Footer -->
    <?php include("inc_files/footer.php"); ?>
    <!-- End Footer -->
    <!-- Script -->
    <script src="assets/js/plugins/jquery-3.6.0.min.js"></script>
    <script src="assets/js/plugins/isotope.pkg.min.js"></script>
    <script src="assets/js/plugins/jquery.slick.min.js"></script>
    <script src="assets/js/plugins/odometer.js"></script>
    <script src="assets/js/plugins/ripples.min.js"></script>
    <script src="assets/js/plugins/wow.min.js"></script>
    <script src="assets/js/plugins/swiper.min.js"></script>
    <script src="assets/js/plugins/YTPlayer.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
