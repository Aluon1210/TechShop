<div class="main-content">
    <div class="container">
        <div style="max-width: 600px; margin: 50px auto; text-align: center; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="margin-bottom: 30px;">
                <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745; margin-bottom: 20px;"></i>
                <h1 style="color: #333; margin-bottom: 10px;">Đặt hàng thành công!</h1>
                <p style="color: #666; font-size: 18px; margin-bottom: 20px;">
                    Cảm ơn bạn đã mua sắm tại TechShop
                </p>
            </div>
            
            <?php if (isset($_GET['order_id'])): ?>
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
                    <h3 style="color: #333; margin-bottom: 15px;">
                        <i class="fas fa-receipt"></i> Thông tin đơn hàng
                    </h3>
                    <p style="margin: 10px 0; font-size: 16px;">
                        <strong>Mã đơn hàng:</strong> 
                        <span style="color: #667eea; font-weight: bold;">#<?php echo htmlspecialchars($_GET['order_id']); ?></span>
                    </p>
                    <p style="margin: 10px 0; font-size: 16px;">
                        <strong>Ngày đặt:</strong> 
                        <span style="color: #333;"><?php echo date('d/m/Y H:i'); ?></span>
                    </p>
                    <p style="margin: 10px 0; font-size: 16px;">
                        <strong>Trạng thái:</strong> 
                        <span style="color: #28a745; font-weight: bold;">Đã xác nhận</span>
                    </p>
                </div>
            <?php endif; ?>
            
            <div style="background: #e7f3ff; padding: 20px; border-radius: 10px; margin-bottom: 30px; border-left: 4px solid #667eea;">
                <h4 style="color: #333; margin-bottom: 15px;">
                    <i class="fas fa-info-circle"></i> Những bước tiếp theo
                </h4>
                <ul style="text-align: left; color: #555; line-height: 1.8;">
                    <li>Chúng tôi sẽ xác nhận đơn hàng trong vòng 24 giờ</li>
                    <li>Bạn sẽ nhận được email thông báo khi đơn hàng được xử lý</li>
                    <li>Đơn hàng sẽ được giao trong vòng 3-5 ngày làm việc</li>
                    <li>Bạn có thể theo dõi trạng thái đơn hàng trong tài khoản cá nhân</li>
                </ul>
            </div>
            
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="?page=home" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; transition: transform 0.2s;">
                    <i class="fas fa-home"></i> Về trang chủ
                </a>
                <a href="?page=profile" style="background: #f8f9fa; color: #333; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; border: 2px solid #ddd; transition: transform 0.2s;">
                    <i class="fas fa-user"></i> Tài khoản cá nhân
                </a>
            </div>
            
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                <p style="color: #666; font-size: 14px;">
                    Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua:
                </p>
                <div style="display: flex; justify-content: center; gap: 20px; margin-top: 15px;">
                    <span style="color: #667eea;">
                        <i class="fas fa-phone"></i> 0123-456-789
                    </span>
                    <span style="color: #667eea;">
                        <i class="fas fa-envelope"></i> support@techshop.com
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.main-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

a:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
    .container {
        padding: 0 15px;
    }
    
    div[style*="max-width: 600px"] {
        margin: 20px auto;
        padding: 20px;
    }
    
    div[style*="display: flex; gap: 15px"] {
        flex-direction: column;
        align-items: center;
    }
    
    a[style*="padding: 15px 30px"] {
        width: 100%;
        text-align: center;
    }
}
</style> 