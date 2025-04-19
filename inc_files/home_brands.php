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
            <img src="/assets/BSRM.png" alt="Image 1">
        </div>

        <div class="brand_scroll">
            <img src="/assets/Unilever.png" alt="Image 2">
        </div>

        <div class="brand_scroll">
            <img src="/assets/Lafarge Holcim.png" alt="Image 3">
        </div>


      <img src="image3.jpg" alt="Image 3" />
      <img src="image1.jpg" alt="Image 1 Duplicate" />
      <img src="image2.jpg" alt="Image 2 Duplicate" />
      <img src="image3.jpg" alt="Image 3 Duplicate" />
    </div>
  </div>

</body>