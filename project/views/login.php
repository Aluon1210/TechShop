<div class="main-content">
    <div class="container">
        <div style="max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <h2 style="text-align: center; margin-bottom: 30px; color: #333;">
                <i class="fas fa-user-lock"></i> Đăng nhập
            </h2>
            
            <?php if ($error): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; border: 1px solid #f5c6cb;">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; border: 1px solid #c3e6cb;">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="?page=login">
                <div style="margin-bottom: 20px;">
                    <label for="username" style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">
                        <i class="fas fa-user"></i> Tên đăng nhập:
                    </label>
                    <input type="text" id="username" name="username" required 
                           placeholder="Nhập tên đăng nhập..."
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; transition: border-color 0.3s;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold; color: #555;">
                        <i class="fas fa-lock"></i> Mật khẩu:
                    </label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Nhập mật khẩu..."
                           style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; transition: border-color 0.3s;">
                </div>
                
                <button type="submit" style="width: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; transition: transform 0.2s;">
                    <i class="fas fa-sign-in-alt"></i> Đăng nhập
                </button>
            </form>
            
            <div style="text-align: center; margin-top: 20px;">
                <p>Chưa có tài khoản? <a href="?page=register" style="color: #667eea; text-decoration: none; font-weight: bold;">Đăng ký ngay</a></p>
            </div>
            
            <!-- Thông tin tài khoản demo -->
            <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px; border-left: 4px solid #667eea;">
                <h4 style="margin: 0 0 10px 0; color: #333; font-size: 14px;">
                    <i class="fas fa-info-circle"></i> Tài khoản demo:
                </h4>
                <div style="font-size: 12px; color: #666;">
                    <p style="margin: 5px 0;"><strong>Admin:</strong> thanhcong / admin123</p>
                    <p style="margin: 5px 0;"><strong>User:</strong> Tạo tài khoản mới</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
input:focus {
    outline: none;
    border-color: #667eea !important;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
}
</style> 