<div class="main-content">
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Chào mừng đến với TechShop</h1>
            <p>Khám phá thế giới công nghệ với những sản phẩm chất lượng cao</p>
            <a href="?page=products" class="cta-button">Mua sắm ngay</a>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="container">
        <h2 style="text-align: center; margin: 50px 0 30px; color: #333;">Sản phẩm nổi bật</h2>
        
        <div class="product-grid">
            <?php if (!empty($featuredProducts)): ?>
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['Image'] ?? 'assets/images/default-product.jpg'); ?>" 
                             alt="<?php echo htmlspecialchars($product['Name']); ?>" 
                             class="product-image">
                        <div class="product-info">
                            <h3 class="product-title"><?php echo htmlspecialchars($product['Name']); ?></h3>
                            <p class="product-price"><?php echo number_format($product['Price']); ?> VNĐ</p>
                            <p class="product-description"><?php echo htmlspecialchars($product['Description'] ?? ''); ?></p>
                            <p><strong>Thương hiệu:</strong> <?php echo htmlspecialchars($product['Brand_Name'] ?? 'N/A'); ?></p>
                            <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product['Category_Name'] ?? 'N/A'); ?></p>
                            <button class="add-to-cart" onclick="addToCart('<?php echo $product['Product_Id']; ?>')">
                                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; grid-column: 1 / -1; padding: 50px;">
                    <p>Chưa có sản phẩm nào.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
function addToCart(productId) {
    // Thêm vào giỏ hàng (sẽ implement sau)
    alert('Đã thêm sản phẩm vào giỏ hàng!');
}
</script> 