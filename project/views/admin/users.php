<div class="main-content">
    <div class="container">
        <div class="admin-users">
            <div class="admin-header">
                <h1>Quản lý người dùng</h1>
                <a href="?page=admin-dashboard" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Quay lại Dashboard
                </a>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="users-section">
                <h2>Danh sách người dùng (<?php echo count($users); ?> người dùng)</h2>
                
                <div class="users-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên đăng nhập</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['User_id']); ?></td>
                                        <td><?php echo htmlspecialchars($user['UserName']); ?></td>
                                        <td><?php echo htmlspecialchars($user['FullName']); ?></td>
                                        <td><?php echo htmlspecialchars($user['Email']); ?></td>
                                        <td><?php echo htmlspecialchars($user['Phone']); ?></td>
                                        <td>
                                            <div class="address-content">
                                                <?php echo htmlspecialchars($user['Adress']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-view" title="Xem chi tiết" 
                                                        onclick="viewUser('<?php echo $user['User_id']; ?>')">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <form method="POST" style="display: inline;" 
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['User_id']; ?>">
                                                    <button type="submit" class="btn-delete" title="Xóa người dùng">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 20px;">
                                        Chưa có người dùng nào.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.admin-users {
    padding: 30px 0;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.admin-header h1 {
    color: #333;
    margin: 0;
}

.back-btn {
    background: #6c757d;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s;
}

.back-btn:hover {
    background: #545b62;
}

.users-section {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.users-section h2 {
    color: #333;
    margin-bottom: 20px;
}

.users-table {
    overflow-x: auto;
}

.users-table table {
    width: 100%;
    border-collapse: collapse;
}

.users-table th,
.users-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.users-table th {
    background: #f8f9fa;
    font-weight: bold;
    color: #333;
}

.address-content {
    max-width: 200px;
    word-wrap: break-word;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.btn-view,
.btn-delete {
    padding: 5px 10px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    text-decoration: none;
    color: white;
    font-size: 14px;
}

.btn-view {
    background: #17a2b8;
}

.btn-delete {
    background: #dc3545;
}

.btn-view:hover {
    background: #138496;
}

.btn-delete:hover {
    background: #c82333;
}

.alert {
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .users-table {
        font-size: 14px;
    }
    
    .users-table th,
    .users-table td {
        padding: 8px 5px;
    }
    
    .address-content {
        max-width: 150px;
    }
}
</style>

<script>
function viewUser(userId) {
    // TODO: Implement view user functionality
    alert('Chức năng xem chi tiết người dùng sẽ được phát triển sau!');
}
</script> 