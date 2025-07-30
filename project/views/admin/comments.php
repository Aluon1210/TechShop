<div class="main-content">
    <div class="container">
        <div class="admin-comments">
            <div class="admin-header">
                <h1>Quản lý bình luận</h1>
                <a href="?page=admin-dashboard" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Quay lại Dashboard
                </a>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="comments-section">
                <h2>Danh sách bình luận (<?php echo count($comments); ?> bình luận)</h2>
                
                <div class="comments-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Người dùng</th>
                                <th>Sản phẩm</th>
                                <th>Nội dung</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($comments)): ?>
                                <?php foreach ($comments as $comment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($comment['Comment_Id']); ?></td>
                                        <td>
                                            <div class="user-info">
                                                <strong><?php echo htmlspecialchars($comment['User_Name'] ?? 'N/A'); ?></strong>
                                                <small>(<?php echo htmlspecialchars($comment['UserName'] ?? 'N/A'); ?>)</small>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="?page=product-detail&id=<?php echo $comment['Product_Id']; ?>" 
                                               class="product-link">
                                                <?php echo htmlspecialchars($comment['Product_Name'] ?? 'N/A'); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="comment-content">
                                                <?php echo htmlspecialchars($comment['Content']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo date('d/m/Y H:i', strtotime($comment['Create_at'])); ?>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?page=product-detail&id=<?php echo $comment['Product_Id']; ?>" 
                                                   class="btn-view" title="Xem sản phẩm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form method="POST" style="display: inline;" 
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="comment_id" value="<?php echo $comment['Comment_Id']; ?>">
                                                    <button type="submit" class="btn-delete" title="Xóa bình luận">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 20px;">
                                        Chưa có bình luận nào.
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
.admin-comments {
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

.comments-section {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.comments-section h2 {
    color: #333;
    margin-bottom: 20px;
}

.comments-table {
    overflow-x: auto;
}

.comments-table table {
    width: 100%;
    border-collapse: collapse;
}

.comments-table th,
.comments-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.comments-table th {
    background: #f8f9fa;
    font-weight: bold;
    color: #333;
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-info strong {
    color: #333;
}

.user-info small {
    color: #666;
    font-size: 12px;
}

.product-link {
    color: #007bff;
    text-decoration: none;
}

.product-link:hover {
    text-decoration: underline;
}

.comment-content {
    max-width: 300px;
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
    
    .comments-table {
        font-size: 14px;
    }
    
    .comments-table th,
    .comments-table td {
        padding: 8px 5px;
    }
    
    .comment-content {
        max-width: 200px;
    }
}
</style> 