

<?php
  // ini_set('display_errors', 1);
  // error_reporting(E_ALL);

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
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<div class="container">
  <div class="cs_section_heading cs_style_1 text-center cs_mb_lg_40">
    <div class="cs_section_heading_in">
      <h3 class="cs_fs_20 text-accent fw-normal cs_lh_base wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.2s"></h3>
      <h2 class="cs_fs_48 cs_fs_lg_36 m-0">Our Products</h2>
    </div>
  </div>
</div>
<div class="container-fluid mb30">
  <div class="swiper cs_service_slider_2">
    <div class="swiper-wrapper">

      <?php foreach ($products as $product): ?>
      <div class="swiper-slide">
        <div class="cs_service cs_style_1 cs_type_1 cs_pt_25 cs_pl_25 cs_pr_25 cs_pb_15 bg-white cs_transition_4 shadow cs_mb_25 each-card">
          <div class="content-div">
            <div class="cs_service_thumb position-relative cs_rounded_5 cs_mb_25 img_box p20">
              <img src="../uploads/images/<?= $product['image'] ?>" alt="<?= $product['title'] ?>" class="img-fluid w-100 cs_rounded_5" />
            </div>
            <div class="cs_service_iconbox d-flex align-items-center cs_mb_20">
              <h2 class="cs_lh_base cs_fs_20 cs_fs_lg_18 m-0">
                <a href="<?= $product['link'] ?>" target="_blank"  class="inline-block"><?= $product['title'] ?></a>
              </h2>
            </div>
            <p class="cs_mb_20"><?= $product['desc'] ?></p>
          </div>
          <div class="btn-div">
            <div class="text-primary">
              <a href="<?= $product['link'] ?>" target="_blank" class="cs_post_btn_2 d-inline-flex justify-content-between align-items-center cs_column_gap_10">
                <span class="cs_post_btn-text">Read More</span>
                  <svg width="16" height="10" viewBox="0 0 16 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.9505 5.44725C14.9547 5.44105 14.9583 5.43463 14.9621 5.42827C14.9656 5.42241 14.9692 5.41669 14.9725 5.41066C14.9759 5.40418 14.9789 5.39751 14.982 5.3909C14.985 5.38461 14.9881 5.37844 14.9908 5.372C14.9934 5.36559 14.9956 5.35902 14.9979 5.3525C15.0004 5.34559 15.003 5.33877 15.0052 5.3317C15.0071 5.32519 15.0086 5.31857 15.0102 5.312C15.0121 5.3048 15.0141 5.29767 15.0155 5.29034C15.017 5.28274 15.0179 5.27507 15.019 5.26744C15.02 5.26099 15.0212 5.25466 15.0218 5.24814C15.0232 5.23406 15.0239 5.21991 15.024 5.20576C15.024 5.20554 15.024 5.20532 15.024 5.20512C15.024 5.20492 15.024 5.20469 15.024 5.20448C15.0239 5.19035 15.0232 5.17621 15.0218 5.1621C15.0212 5.15556 15.02 5.14925 15.019 5.1428C15.0179 5.13517 15.017 5.12749 15.0155 5.1199C15.0141 5.11256 15.0121 5.10544 15.0102 5.09824C15.0086 5.09167 15.0071 5.08505 15.0052 5.07854C15.003 5.07149 15.0004 5.06465 14.9979 5.05774C14.9956 5.05122 14.9934 5.04467 14.9908 5.03824C14.9881 5.0318 14.985 5.02562 14.982 5.01934C14.9789 5.01272 14.9759 5.00606 14.9725 4.99958C14.9692 4.99355 14.9656 4.98781 14.9621 4.98197C14.9583 4.97561 14.9547 4.96918 14.9505 4.96299C14.9462 4.9565 14.9414 4.9504 14.9367 4.94415C14.9328 4.93902 14.9293 4.93373 14.9252 4.92872C14.916 4.91758 14.9064 4.90689 14.8962 4.89672L10.887 0.88748C10.7167 0.717156 10.4405 0.717155 10.2702 0.88748C10.0999 1.0578 10.0999 1.33395 10.2702 1.50427L13.5349 4.76894L1.01817 4.76893C0.777297 4.76893 0.582021 4.96421 0.582021 5.20508C0.582021 5.44595 0.777297 5.64123 1.01817 5.64123L13.5349 5.64122L10.2702 8.9059C10.0999 9.07622 10.0999 9.35236 10.2702 9.52269C10.4405 9.69301 10.7167 9.69303 10.887 9.5227L14.8962 5.51349C14.9064 5.50333 14.916 5.49264 14.9251 5.48153C14.9292 5.47652 14.9328 5.47125 14.9367 5.46609C14.9414 5.45984 14.9462 5.45374 14.9505 5.44725Z" fill="currentColor"></path>
                  </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<style>
  .each-card{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    /* background-color: aqua !important; */
    height: 550px;
  }
  

  .img_box{
    height: 220px !important;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0px;
    width: 100% !important;
  }
  .img_box img{
    object-fit:contain;
    width:100% !important;
    height:100%;
  }
  .p20{
    padding: 20px !important;
  }
  .mb30{
    margin-bottom: 30px;
  }

</style>
<script>
  const swiper = new Swiper('.cs_service_slider_2', {
    loop: true,
    spaceBetween: 24,
    slidesPerView: 1,
    autoplay: {
      delay: 700,
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
