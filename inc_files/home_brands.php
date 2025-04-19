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
      animation: scroll 15s linear infinite;
    }

    .scroll-content img {
      width: 300px; /* Adjust width as needed */
      height: auto;
      margin-right: 20px;
    }
    .brand_scroll{
        height: 100px;
        width:300px;
    }
    .brand_scroll img{
        height: 100%;
        width: 100%;
        object-fit: contain;
    }


    @keyframes scroll {
      0% {
        transform: translateX(100%);
      }
      100% {
        transform: translateX(-100%);
      }
    }
  </style>
<body>

  <div class="scroll-container">
    <div class="scroll-content">
        <div class="brand_scroll">
            <img src="/assets/brands/BSRM.png" alt="Image 1">
        </div>

        <div class="brand_scroll">
            <img src="/assets/brands/Unilever.png" alt="Image 2">
        </div>

        <div class="brand_scroll">
            <img src="/assets/brands/Lafarge Holcim.png" alt="Image 3">
        </div>

        <div class="brand_scroll">
            <img src="/assets/brands/Nestle.png" alt="Image 4">
        </div>

        <div class="brand_scroll">
            <img src="/assets/brands/Pran.png" alt="Image 5">
        </div>


    </div>
  </div>

</body>