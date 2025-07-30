<div class="main-content">
    <div class="container">
        <h1 style="text-align: center; margin-bottom: 30px; color: #333;">Tất cả sản phẩm</h1>
        
        <!-- Filter Section -->
        <div class="filter-section" style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
            <form method="GET" action="?page=products" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
                <input type="hidden" name="page" value="products">
                
                <div>
                    <label for="search">Tìm kiếm:</label>
                    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" 
                           placeholder="Tên sản phẩm..." style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                </div>
                
                <div>
                    <label for="category">Danh mục:</label>
                    <select id="category" name="category" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Tất cả danh mục</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['Category_Name']); ?>" 
                                    <?php echo ($_GET['category'] ?? '') === $cat['Category_Name'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['Category_Name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="brand">Thương hiệu:</label>
                    <select id="brand" name="brand" style="padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                        <option value="">Tất cả thương hiệu</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?php echo htmlspecialchars($brand['Brand_Name']); ?>" 
                                    <?php echo ($_GET['brand'] ?? '') === $brand['Brand_Name'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($brand['Brand_Name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" style="background: #667eea; color: white; padding: 8px 20px; border: none; border-radius: 5px; cursor: pointer;">
                    <i class="fas fa-search"></i> Lọc
                </button>
                
                <a href="?page=products" style="background: #6c757d; color: white; padding: 8px 20px; text-decoration: none; border-radius: 5px;">
                    <i class="fas fa-times"></i> Xóa bộ lọc
                </a>
            </form>
        </div>
        
        <!-- Products Grid -->
        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
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
                            <p><strong>Còn lại:</strong> <?php echo $product['Quantity']; ?> sản phẩm</p>
                            <div style="display: flex; gap: 10px;">
                                <button class="add-to-cart" onclick="addToCart('<?php echo $product['Product_Id']; ?>')">
                                    <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                                </button>
                                <a href="?page=product-detail&id=<?php echo $product['Product_Id']; ?>" 
                                   style="background: #28a745; color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; text-align: center; flex: 1;">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; grid-column: 1 / -1; padding: 50px;">
                    <p>Không tìm thấy sản phẩm nào phù hợp.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    // Thêm vào giỏ hàng (sẽ implement sau)
    alert('Đã thêm sản phẩm vào giỏ hàng!');
}
</script> 