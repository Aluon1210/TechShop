<div class="main-content">
    <div class="container">
        <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
            <h1 style="text-align: center; color: #333; margin-bottom: 30px;">
                <i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn
            </h1>

            <?php if ($message): ?>
                <div style="background: <?php echo strpos($message, 'thành công') !== false ? '#d4edda' : '#f8d7da'; ?>; 
                            color: <?php echo strpos($message, 'thành công') !== false ? '#155724' : '#721c24'; ?>; 
                            padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; border: 1px solid <?php echo strpos($message, 'thành công') !== false ? '#c3e6cb' : '#f5c6cb'; ?>;">
                    <i class="fas fa-<?php echo strpos($message, 'thành công') !== false ? 'check-circle' : 'exclamation-triangle'; ?>"></i> 
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if (!isset($_SESSION['user_id'])): ?>
                <div style="text-align: center; padding: 50px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <i class="fas fa-user-lock" style="font-size: 48px; color: #667eea; margin-bottom: 20px;"></i>
                    <h2>Vui lòng đăng nhập</h2>
                    <p>Bạn cần đăng nhập để xem giỏ hàng của mình.</p>
                    <a href="?page=login" style="background: #667eea; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 15px;">
                        <i class="fas fa-sign-in-alt"></i> Đăng nhập ngay
                    </a>
                </div>
            <?php elseif (empty($cartData['items'])): ?>
                <div style="text-align: center; padding: 50px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                    <h2>Giỏ hàng trống</h2>
                    <p>Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                    <a href="?page=home" style="background: #667eea; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 15px;">
                        <i class="fas fa-shopping-bag"></i> Mua sắm ngay
                    </a>
                </div>
            <?php else: ?>
                <!-- Danh sách sản phẩm trong giỏ hàng -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                    <!-- Danh sách sản phẩm -->
                    <div style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px;">
                        <h3 style="margin-bottom: 20px; color: #333; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">
                            <i class="fas fa-list"></i> Sản phẩm (<?php echo $cartData['count']; ?>)
                        </h3>
                        
                        <?php foreach ($cartData['items'] as $item): ?>
                            <div style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #f0f0f0; gap: 15px;">
                                <!-- Hình ảnh sản phẩm -->
                                <div style="flex-shrink: 0;">
                                    <img src="<?php echo $item['Image'] ?: 'assets/images/default-product.jpg'; ?>" 
                                         alt="<?php echo htmlspecialchars($item['Name']); ?>"
                                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #eee;">
                                </div>
                                
                                <!-- Thông tin sản phẩm -->
                                <div style="flex: 1;">
                                    <h4 style="margin: 0 0 5px 0; color: #333;"><?php echo htmlspecialchars($item['Name']); ?></h4>
                                    <p style="margin: 0; color: #667eea; font-weight: bold; font-size: 18px;">
                                        <?php echo number_format($item['Price']); ?> VNĐ
                                    </p>
                                    <p style="margin: 5px 0 0 0; color: #666; font-size: 14px;">
                                        Còn lại: <?php echo $item['StockQuantity']; ?> sản phẩm
                                    </p>
                                </div>
                                
                                <!-- Điều chỉnh số lượng -->
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <form method="POST" style="display: flex; align-items: center; gap: 5px;">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="cart_item_id" value="<?php echo $item['Cart_Item_Id']; ?>">
                                        <button type="button" onclick="updateQuantity(<?php echo $item['Cart_Item_Id']; ?>, <?php echo $item['Quantity'] - 1; ?>)" 
                                                style="background: #f8f9fa; border: 1px solid #ddd; width: 30px; height: 30px; border-radius: 5px; cursor: pointer;"
                                                <?php echo $item['Quantity'] <= 1 ? 'disabled' : ''; ?>>
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <span style="min-width: 40px; text-align: center; font-weight: bold;"><?php echo $item['Quantity']; ?></span>
                                        <button type="button" onclick="updateQuantity(<?php echo $item['Cart_Item_Id']; ?>, <?php echo $item['Quantity'] + 1; ?>)" 
                                                style="background: #f8f9fa; border: 1px solid #ddd; width: 30px; height: 30px; border-radius: 5px; cursor: pointer;"
                                                <?php echo $item['Quantity'] >= $item['StockQuantity'] ? 'disabled' : ''; ?>>
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Tổng tiền sản phẩm -->
                                <div style="text-align: right; min-width: 120px;">
                                    <p style="margin: 0; color: #333; font-weight: bold; font-size: 16px;">
                                        <?php echo number_format($item['Subtotal']); ?> VNĐ
                                    </p>
                                </div>
                                
                                <!-- Nút xóa -->
                                <div>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="hidden" name="cart_item_id" value="<?php echo $item['Cart_Item_Id']; ?>">
                                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')" 
                                                style="background: #dc3545; color: white; border: none; width: 35px; height: 35px; border-radius: 5px; cursor: pointer;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Tổng quan đơn hàng -->
                    <div style="background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; height: fit-content;">
                        <h3 style="margin-bottom: 20px; color: #333; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">
                            <i class="fas fa-receipt"></i> Tổng quan đơn hàng
                        </h3>
                        
                        <div style="margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span>Tạm tính:</span>
                                <span><?php echo number_format($cartData['total']); ?> VNĐ</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span>Phí vận chuyển:</span>
                                <span>Miễn phí</span>
                            </div>
                            <hr style="border: none; border-top: 1px solid #eee; margin: 15px 0;">
                            <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 18px; color: #667eea;">
                                <span>Tổng cộng:</span>
                                <span><?php echo number_format($cartData['total']); ?> VNĐ</span>
                            </div>
                        </div>
                        
                        <!-- Form thanh toán -->
                        <form method="POST" id="checkoutForm">
                            <input type="hidden" name="action" value="checkout">
                            
                            <div style="margin-bottom: 15px;">
                                <label for="shipping_address" style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">
                                    <i class="fas fa-map-marker-alt"></i> Địa chỉ giao hàng:
                                </label>
                                <textarea id="shipping_address" name="shipping_address" required
                                          placeholder="Nhập địa chỉ giao hàng chi tiết..."
                                          style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; resize: vertical; min-height: 80px;"></textarea>
                            </div>
                            
                            <div style="margin-bottom: 20px;">
                                <label for="phone" style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">
                                    <i class="fas fa-phone"></i> Số điện thoại:
                                </label>
                                <input type="tel" id="phone" name="phone" required
                                       placeholder="Nhập số điện thoại..."
                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                            </div>
                            
                            <button type="submit" onclick="return confirm('Xác nhận đặt hàng?')"
                                    style="width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                           color: white; padding: 15px; border: none; border-radius: 5px; 
                                           font-size: 16px; font-weight: bold; cursor: pointer; transition: transform 0.2s;">
                                <i class="fas fa-credit-card"></i> Thanh toán ngay
                            </button>
                        </form>
                        
                        <div style="text-align: center; margin-top: 15px;">
                            <a href="?page=home" style="color: #667eea; text-decoration: none; font-size: 14px;">
                                <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function updateQuantity(cartItemId, newQuantity) {
    if (newQuantity <= 0) {
        if (confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            // Tạo form để xóa
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="cart_item_id" value="${cartItemId}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
        return;
    }
    
    // Tạo form để cập nhật
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="cart_item_id" value="${cartItemId}">
        <input type="hidden" name="quantity" value="${newQuantity}">
    `;
    document.body.appendChild(form);
    form.submit();
}

// Auto-submit form khi thay đổi số lượng
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('input[name="quantity"]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script>

<style>
button:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}

textarea:focus, input:focus {
    outline: none;
    border-color: #667eea !important;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

@media (max-width: 768px) {
    .container > div {
        grid-template-columns: 1fr !important;
    }
    
    .cart-item {
        flex-direction: column;
        text-align: center;
    }
    
    .cart-item > div {
        margin-bottom: 10px;
    }
}
</style> 