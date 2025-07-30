<div class="main-content">
    <div class="container">
        <div style="max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <h2 style="text-align: center; margin-bottom: 30px; color: #333;">Đăng ký tài khoản</h2>
            
            <?php if ($message): ?>
                <div style="background: <?php echo $messageType === 'success' ? '#d4edda' : '#f8d7da'; ?>; 
                            color: <?php echo $messageType === 'success' ? '#155724' : '#721c24'; ?>; 
                            padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="?page=register">
                <div style="margin-bottom: 20px;">
                    <label for="UserName" style="display: block; margin-bottom: 5px; font-weight: bold;">Tên đăng nhập:</label>
                    <input type="text" id="UserName" name="UserName" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="PassWord" style="display: block; margin-bottom: 5px; font-weight: bold;">Mật khẩu:</label>
                    <input type="password" id="PassWord" name="PassWord" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="Email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email:</label>
                    <input type="email" id="Email" name="Email" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="FullName" style="display: block; margin-bottom: 5px; font-weight: bold;">Họ và tên:</label>
                    <input type="text" id="FullName" name="FullName" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="Phone" style="display: block; margin-bottom: 5px; font-weight: bold;">Số điện thoại:</label>
                    <input type="text" id="Phone" name="Phone" required 
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="Adress" style="display: block; margin-bottom: 5px; font-weight: bold;">Địa chỉ:</label>
                    <textarea id="Adress" name="Adress" required rows="3"
                              style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; resize: vertical;"></textarea>
                </div>
                
                <button type="submit" style="width: 100%; background: #667eea; color: white; padding: 12px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer;">
                    <i class="fas fa-user-plus"></i> Đăng ký
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <p>Đã có tài khoản? <a href="?page=login" style="color: #667eea; text-decoration: none;">Đăng nhập ngay</a></p>
            </div>
        </div>
    </div>
</div> 