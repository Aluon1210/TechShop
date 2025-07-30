<div class="main-content">
    <div class="container">
        <div class="admin-dashboard">
            <div class="admin-header">
                <h1>Admin Dashboard</h1>
                <p>Chào mừng, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</p>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['products']; ?></h3>
                        <p>Sản phẩm</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['users']; ?></h3>
                        <p>Người dùng</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['comments']; ?></h3>
                        <p>Bình luận</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="stat-content">
                        <h3><?php echo $stats['orders']; ?></h3>
                        <p>Đơn hàng</p>
                    </div>
                </div>
            </div>
            
            <div class="admin-actions">
                <h2>Quản lý hệ thống</h2>
                <div class="action-grid">
                    <a href="?page=admin-products" class="action-card">
                        <i class="fas fa-box"></i>
                        <h3>Quản lý sản phẩm</h3>
                        <p>Thêm, sửa, ẩn sản phẩm</p>
                    </a>
                    
                    <a href="?page=admin-comments" class="action-card">
                        <i class="fas fa-comments"></i>
                        <h3>Quản lý bình luận</h3>
                        <p>Xem và quản lý bình luận</p>
                    </a>
                    
                    <a href="?page=admin-users" class="action-card">
                        <i class="fas fa-users"></i>
                        <h3>Quản lý người dùng</h3>
                        <p>Xem danh sách người dùng</p>
                    </a>
                    
                    <a href="?page=home" class="action-card">
                        <i class="fas fa-home"></i>
                        <h3>Về trang chủ</h3>
                        <p>Quay lại website</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    padding: 30px 0;
}

.admin-header {
    text-align: center;
    margin-bottom: 40px;
}

.admin-header h1 {
    color: #333;
    margin-bottom: 10px;
}

.admin-header p {
    color: #666;
    font-size: 18px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 20px;
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.stat-content h3 {
    font-size: 32px;
    color: #333;
    margin: 0;
}

.stat-content p {
    color: #666;
    margin: 5px 0 0 0;
}

.admin-actions h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.action-card {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-decoration: none;
    color: inherit;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.action-card i {
    font-size: 48px;
    color: #007bff;
    margin-bottom: 15px;
}

.action-card h3 {
    color: #333;
    margin: 0 0 10px 0;
}

.action-card p {
    color: #666;
    margin: 0;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .action-grid {
        grid-template-columns: 1fr;
    }
}
</style> 