<style>
    .scroll-container {
      width: 100%;
      overflow: hidden;
      background: #f9f9f9;
      padding-top: 20px;
      padding-bottom: 20px;
    }

    .scroll-content {
      display: flex;
      animation: scroll 5s linear infinite;
    }

    .scroll-content img {
      width: 500px; /* Adjust width as needed */
      height: auto;
      margin-right: 20px;
    }

    @keyframes scroll {
      0% {
        transform: translateX(0%);
      }
      100% {
        transform: translateX(-50%);
      }
    }
  </style>
<body>

  <div class="scroll-container">
    <div class="scroll-content">
      <img src="/assets/img/BSRM.jpg" alt="Image 1" />
      <img src="image2.jpg" alt="Image 2" />
      <img src="image3.jpg" alt="Image 3" />
      <img src="image1.jpg" alt="Image 1 Duplicate" />
      <img src="image2.jpg" alt="Image 2 Duplicate" />
      <img src="image3.jpg" alt="Image 3 Duplicate" />
    </div>
  </div>

</body>