<?php include("connection.php"); ?>
<!-- Start Header Section -->
<header class="cs_site_header cs_style_1 cs_sticky_header cs_site_header_full_width">
  <div class="cs_main_header">
    <div class="container">
      <div class="cs_main_header_in">
        <div class="cs_main_header_left">
          <a class="cs_site_branding" href="index.php">
            <img src="assets/img/logo.png" alt="Logo">
          </a>

        </div>
        <div class="cs_main_header_right">
          <div class="cs_nav cs_primary_font fw-medium">
            <ul class="cs_nav_list fw-medium text-uppercase">
              <li class="#">
                <a href="index.php">Home</a>
                <!-- <ul>
                      <li><a href="index.html">Business</a></li>
                      <li><a href="corporate.html">Corporate</a></li>
                      <li><a href="finance.html">Financial institute</a></li>
                      <li><a href="insurance.html">Insurance Company</a></li>
                      <li><a href="consulting.html">Consulting Agency</a></li>
                      <li><a href="business-with-ecommerce.html">Business With E-Commerce</a></li>
                    </ul> -->
              </li>
              <li class="menu-item-has-children">
                <a href="about.php">About Us</a>
                <ul>
                  <li><a href="about.php">About Us</a></li>
                  <li><a href="why_work_with_us.php">Why Work With Us</a></li>
                </ul>
              </li>
              <li class="menu-item-has-children">
                <a href="carbon_brush_technology.php?category_id=<?= $category['id'] ?>">Products</a>
                <?php
                // Fetch categories
                $stmt = $conn->prepare("SELECT id, name FROM categories");
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Handle category selection
                $categoryDetails = null;
                if (isset($_GET['category_id'])) {
                  $categoryId = intval($_GET['category_id']);
                  $stmt = $conn->prepare("SELECT * FROM categories WHERE id = :id");
                  $stmt->execute([':id' => $categoryId]);
                  $categoryDetails = $stmt->fetch(PDO::FETCH_ASSOC);
                }
                ?>
                <ul>
                  <?php foreach ($categories as $category): ?>
                    <li><a href="carbon_brush_technology.php?category_id=<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </li>
              <li class="menu-item-has-children">
                <a href="hydraulics_servicing_solutions_center.php">Services</a>
                <ul>
                  <li><a href="hydraulics_servicing_solutions_center.php">Hydraulics Servicing & Solutions Center</a></li>
                  <li><a href="eot_cranes.php">EOT Cranes</a></li>
                </ul>
              </li>
              <li><a href="contact.php">Contact Us</a></li>
            </ul>
          </div>
          <div class="cs_toolbox">
            <div class="cs_header_contact">

              <div class="div">
                <div class="cs_header_contact_right">
                  <h3 class="text-white fw-normal cs_mb_6 cs_fs_13">Need help? Call us:</h3>
                  <h3 class="text-white fw-normal cs_mb_6 cs_fs_13">E-Mail Us:</h3>
                  <h3 class="text-white fw-normal cs_mb_6 cs_fs_13">Our Brochure:</h3>

                </div>
                <div class="cs_header_contact_right">
                  <a href="https://wa.me/+919836000409">
                    <h3 class="text-white m-0 cs_fs_13"> +91 9836000409</h3>
                  </a>
                  <a href="mailto:tbl@tblindustrial.com">
                    <h3 class="text-white m-0 cs_fs_13" style="padding-top: 5px;">tbl@tblindustrial.com</h3>
                  </a>
                  <a href="/assets/TBL.pdf">
                    <h3 class="text-white m-0 cs_fs_13" style="padding-top: 5px;">Click Here</h3>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- End Header Section -->
<style>
  @media (min-width: 520px) {
    .cs_site_header.cs_style_1 .cs_main_header_left {
        width: 370px;
    }
  }
  @media (max-width: 480px) {
    .cs_site_header.cs_style_1 .cs_main_header_left {
      width: 250px !important;
    }
  }

  .cs_header_contact_right {
    display: flex;
    flex-direction: column;
  }

  .cs_header_contact_right h3,
  .cs_header_contact_right a h3 {
    padding: 0px 5px;
  }

  .div {
    display: flex;
    flex-direction: row;
    width: 280px;
    margin-right: 5px;
    margin-left: 20px;
  }

  .cs_header_contact .cs_header_contact_icon {}

</style>