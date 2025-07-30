<div class="main-content">
    <div class="container">
        <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden; margin: 20px 0;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; padding: 30px;">
                <!-- Product Image -->
                <div>
                    <img src="<?php echo htmlspecialchars($product['Image'] ?? 'assets/images/default-product.jpg'); ?>" 
                         alt="<?php echo htmlspecialchars($product['Name']); ?>" 
                         style="width: 100%; height: 400px; object-fit: cover; border-radius: 10px;">
                </div>
                
                <!-- Product Info -->
                <div>
                    <h1 style="color: #333; margin-bottom: 15px;"><?php echo htmlspecialchars($product['Name']); ?></h1>
                    
                    <div style="font-size: 28px; color: #667eea; font-weight: bold; margin-bottom: 20px;">
                        <?php echo number_format($product['Price']); ?> VNĐ
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <p><strong>Thương hiệu:</strong> <?php echo htmlspecialchars($product['Brand_Name'] ?? 'N/A'); ?></p>
                        <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product['Category_Name'] ?? 'N/A'); ?></p>
                        <p><strong>Số lượng còn lại:</strong> <?php echo $product['Quantity']; ?> sản phẩm</p>
                    </div>
                    
                    <div style="margin-bottom: 30px;">
                        <h3>Mô tả sản phẩm:</h3>
                        <p style="color: #666; line-height: 1.6;"><?php echo htmlspecialchars($product['Description'] ?? 'Chưa có mô tả.'); ?></p>
                    </div>
                    
                    <div style="display: flex; gap: 15px;">
                        <button class="add-to-cart" onclick="addToCart('<?php echo $product['Product_Id']; ?>')" style="flex: 2;">
                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                        </button>
                        <button style="flex: 1; background: #28a745; color: white; padding: 15px; border: none; border-radius: 25px; cursor: pointer; font-weight: bold;">
                            <i class="fas fa-heart"></i> Yêu thích
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Back to Products -->
        <div style="text-align: center; margin: 30px 0;">
            <a href="?page=products" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách sản phẩm
            </a>
        </div>
    </div>
</div>

<script>
function addToCart(productId) {
    alert('Đã thêm sản phẩm vào giỏ hàng!');
}
</script> 