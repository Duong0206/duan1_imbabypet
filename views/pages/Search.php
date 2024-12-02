<!DOCTYPE html>
<html lang="en">

<head>
  <title>Kết quả tìm kiếm</title>
</head>

<body>
  <div class="container">
    <h2>Kết quả tìm kiếm cho từ khóa: "<?php echo htmlspecialchars($_GET['q']); ?>"</h2>
    <div class="row">
      <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
          <div class="col-md-4">
            <div class="card">
              <img src="<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="Product Image">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                <a href="?act=product&id=<?php echo $product['id']; ?>" class="btn btn-primary">Chi tiết</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Không tìm thấy sản phẩm nào.</p>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>
