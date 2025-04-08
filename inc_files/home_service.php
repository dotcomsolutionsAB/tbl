

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

  $conn = new mysqli("localhost", "tbl_", "Jzz4Qp1e5Za1k@can", "tbl_");
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Query to join brands with categories and uploads
  $sql = "
    SELECT 
        b.name AS brand_name,
        b.description,
        b.url_link,
        c.name AS category_name,
        u.path AS image_path,
        u.name AS image_name,
        u.extension
    FROM brands b
    LEFT JOIN categories c ON b.category_id = c.id
    LEFT JOIN uploads u ON b.image_id = u.id
    ";

  $result = $conn->query($sql);
  if ($result->num_rows === 0) {
      echo "No data found!";
      exit;
  }

  $products = [];

  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $image_full_path = $row['image_name'];
          // if (!empty($row['extension'])) {
          //     $image_full_path .= '.' . $row['extension'];
          // }

          $products[] = [
              "title" => $row['category_name'],
              "desc"  => $row['brand_name'] . " - " . $row['description'],
              "image" => $image_full_path,
              "link"  => $row['url_link']
          ];
      }
  }
?>

<!-- <section class="cs_pb_140 cs_pb_lg_80">
  <div class="container">
    <div class="cs_section_heading cs_style_1 text-center cs_mb_60 cs_mb_lg_40">
      <div class="cs_section_heading_in">
        <h2 class="cs_fs_48 cs_fs_lg_36 m-0">Our Products</h2>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="cs_service_slider_2 cs_gap_24">
      <div class="cs_slider_activate">

        <?php foreach ($products as $product): ?>
        <div class="cs_slide">
          <div class="cs_service cs_style_1 cs_type_1 cs_pt_25 cs_pl_25 cs_pr_25 cs_pb_15 bg-white cs_transition_4 shadow cs_mb_25">
            <div class="cs_service_thumb position-relative cs_rounded_5 cs_mb_25">
              <div class="cs_service_thumb-in position-relative-in background-filled h-100" data-src="uploads/image/<?= $product['image'] ?>"></div>
            </div>
            <div class="cs_service_iconbox d-flex align-items-center cs_mb_20">
              <h2 class="cs_lh_base cs_fs_20 cs_fs_lg_18 m-0">
                <a href="<?= $product['link'] ?>" class="inline-block"><?= $product['title'] ?></a>
              </h2>
            </div>
            <p class="cs_mb_20"><?= $product['desc'] ?></p>
            <div class="text-primary">
              <a href="<?= $product['link'] ?>" class="cs_post_btn_2 d-inline-flex justify-content-between align-items-center cs_column_gap_10">
                <span class="cs_post_btn-text">Read More</span>
                <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14.9505 5.44725...Z" fill="currentColor"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>
</section> -->

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<div class="container-fluid">
  <div class="swiper cs_service_slider_2">
    <div class="swiper-wrapper">

      <?php foreach ($products as $product): ?>
      <div class="swiper-slide">
        <div class="cs_service cs_style_1 cs_type_1 cs_pt_25 cs_pl_25 cs_pr_25 cs_pb_15 bg-white cs_transition_4 shadow cs_mb_25">
          <div class="cs_service_thumb position-relative cs_rounded_5 cs_mb_25">
            <div class="cs_service_thumb-in position-relative-in background-filled h-100" style="background-image: url('../uploads/images/<?= $product['image'] ?>'); background-size: cover; background-position: center;"></div>
          </div>
          <div class="cs_service_iconbox d-flex align-items-center cs_mb_20">
            <h2 class="cs_lh_base cs_fs_20 cs_fs_lg_18 m-0">
              <a href="<?= $product['link'] ?>" class="inline-block"><?= $product['title'] ?></a>
            </h2>
          </div>
          <p class="cs_mb_20"><?= $product['desc'] ?></p>
          <div class="text-primary">
            <a href="<?= $product['link'] ?>" class="cs_post_btn_2 d-inline-flex justify-content-between align-items-center cs_column_gap_10">
              <span class="cs_post_btn-text">Read More</span>
              <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.9505 5.44725...Z" fill="currentColor"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</div>

<script>
  const swiper = new Swiper('.cs_service_slider_2', {
    loop: true,
    spaceBetween: 24,
    slidesPerView: 1,
    autoplay: {
      delay: 2000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true // Pause when hovering
    },
    breakpoints: {
      576: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      1024: { slidesPerView: 4 }
    }
  });
</script>
