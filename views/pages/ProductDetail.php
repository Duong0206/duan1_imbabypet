<?php include('./views/includes/header.php'); ?>

<section class="product-details my-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <img width="500px" src="admin/<?php echo $product['HinhAnh']; ?>" alt="<?php echo $product['TenSP']; ?>" class="img-fluid">
                <div class="product-gallery mt-3">
                    <!-- Giả sử bạn có thêm các hình ảnh khác lưu trong cơ sở dữ liệu -->
                    <img src="admin/<?php echo $product['HinhAnh']; ?>" alt="Thumbnail 1" class="img-thumbnail me-2" style="width: 80px; height: auto;">
                    <img src="admin/<?php echo $product['HinhAnh']; ?>" alt="Thumbnail 2" class="img-thumbnail me-2" style="width: 80px; height: auto;">
                    <img src="admin/<?php echo $product['HinhAnh']; ?>" alt="Thumbnail 3" class="img-thumbnail me-2" style="width: 80px; height: auto;">
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="product-title"><?php echo $product['TenSP']; ?></h2>
                <div class="product-rating mb-3">
                    <span class="star-rating">&#9733;&#9733;&#9733;&#9733;&#9734;</span> <!-- 4 sao -->
                    <span class="text-muted">(10 đánh giá)</span>
                </div>
                <p class="product-description"><?php echo $product['MoTa']; ?></p>
                <h3 class="product-price">$<?php echo number_format($product['DonGiaBan'], 2); ?></h3>
                
                <div class="d-flex align-items-center mt-4">
                    <h4 class="star-rating" style="padding-right: 10px;">Số lượng:  </h4>
                    <input type="number" class="form-control me-2" value="1" min="1" style="width: 80px; height: 65px;">
                    <button class="btn btn-primary me-2">Thêm vào giỏ hàng</button>
                    <button class="btn btn-success">Mua ngay</button>
                </div>
            </div>
        </div>
    </div>
</section>

  <section class="product-comments my-5">
    <div class="container">
      <h3 class=" mb-4">Bình luận sản phẩm</h3>
      
      <div class="comments-list mb-4">
        <div class="comment-item border p-3 mb-3">
          <h5 class="star-rating">Nguyễn Văn A</h5>
          <p class="comment-text">Sản phẩm rất tốt, tôi rất hài lòng với chất lượng!</p>
        </div>
        <div class="comment-item border p-3 mb-3">
          <h5 class="star-rating">Trần Thị B</h5>
          <p class="comment-text">Giao hàng nhanh chóng, sản phẩm đúng như mô tả.</p>
        </div>
      </div>
  
      <div class="comment-form">
        <h4>Để lại bình luận của bạn</h4>
        <form id="comment-form" class="mt-3">
          <div class="mb-3">
            <input type="text" class="form-control" placeholder="Tên của bạn" required>
          </div>
          <div class="mb-3">
            <textarea class="form-control" rows="3" placeholder="Nội dung bình luận" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Gửi bình luận</button>
        </form>
      </div>
    </div>
  </section>

  <section id="clothing" class="my-5 overflow-hidden">
    <div class="container pb-5">

      

      <div class="products-carousel swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item1.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                    
                  </div>


                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item2.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                   
                  </div>

                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item3.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                    
                  </div>


                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item4.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                    
                  </div>


                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item7.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                   
                  </div>


                </div>

              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card position-relative">
              <a href="single-product.html"><img src="images/item8.jpg" class="img-fluid rounded-4" alt="image"></a>
              <div class="card-body p-0">
                <a href="single-product.html">
                  <h3 class="card-title pt-4 m-0">Grey hoodie</h3>
                </a>

                <div class="card-text">
                  <span class="rating secondary-font">
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    <iconify-icon icon="clarity:star-solid" class="text-primary"></iconify-icon>
                    5.0</span>

                  <h3 class="secondary-font text-primary">$18.00</h3>

                  <div class="d-flex flex-wrap mt-3">
                    <a href="#" class="btn-cart me-3 px-4 pt-3 pb-3">
                      <h5 class="text-uppercase m-0">Xem chi tiết</h5>
                    </a>
                    
                  </div>


                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

<?php include('./views/includes/footer.php'); ?>