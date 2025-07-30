<div class="main-content">
    <div class="container">
        <div class="admin-products">
            <div class="admin-header">
                <h1>Quản lý sản phẩm</h1>
                <a href="?page=admin-dashboard" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Quay lại Dashboard
                </a>
            </div>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <!-- Form thêm sản phẩm -->
            <div class="add-product-section">
                <h2>Thêm sản phẩm mới</h2>
                <form method="POST" class="add-product-form">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Name">Tên sản phẩm:</label>
                            <input type="text" id="Name" name="Name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="Price">Giá (VNĐ):</label>
                            <input type="number" id="Price" name="Price" min="0" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Category_Id">Danh mục:</label>
                            <select id="Category_Id" name="Category_Id" required>
                                <option value="">Chọn danh mục</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['Category_Id']; ?>">
                                        <?php echo htmlspecialchars($category['Category_Name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="Brand_Id">Thương hiệu:</label>
                            <select id="Brand_Id" name="Brand_Id" required>
                                <option value="">Chọn thương hiệu</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?php echo $brand['Brand_Id']; ?>">
                                        <?php echo htmlspecialchars($brand['Brand_Name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="Quantity">Số lượng:</label>
                            <input type="number" id="Quantity" name="Quantity" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="Image">Link hình ảnh:</label>
                            <input type="text" id="Image" name="Image" placeholder="https://example.com/image.jpg">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="Description">Mô tả:</label>
                        <textarea id="Description" name="Description" rows="3"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-primary">Thêm sản phẩm</button>
                </form>
            </div>
            
            <!-- Danh sách sản phẩm -->
            <div class="products-list-section">
                <h2>Danh sách sản phẩm (<?php echo count($products); ?> sản phẩm)</h2>
                
                <div class="products-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Danh mục</th>
                                <th>Thương hiệu</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['Product_Id']); ?></td>
                                        <td>
                                            <img src="<?php echo htmlspecialchars($product['Image'] ?? 'assets/images/default-product.jpg'); ?>" 
                                                 alt="<?php echo htmlspecialchars($product['Name']); ?>" 
                                                 class="product-thumbnail">
                                        </td>
                                        <td><?php echo htmlspecialchars($product['Name']); ?></td>
                                        <td><?php echo number_format($product['Price']); ?> VNĐ</td>
                                        <td><?php echo $product['Quantity']; ?></td>
                                        <td><?php echo htmlspecialchars($product['Category_Name'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($product['Brand_Name'] ?? 'N/A'); ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?page=product-detail&id=<?php echo $product['Product_Id']; ?>" 
                                                   class="btn-view" title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn-edit" title="Sửa sản phẩm" 
                                                        onclick="editProduct('<?php echo $product['Product_Id']; ?>')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form method="POST" style="display: inline;" 
                                                      onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['Product_Id']; ?>">
                                                    <button type="submit" class="btn-delete" title="Xóa sản phẩm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align: center; padding: 20px;">
                                        Chưa có sản phẩm nào.
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
.admin-products {
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

.add-product-section {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.add-product-section h2 {
    color: #333;
    margin-bottom: 20px;
}

.add-product-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.form-group label {
    font-weight: bold;
    color: #555;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.btn-primary {
    background: #007bff;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
    align-self: flex-start;
}

.btn-primary:hover {
    background: #0056b3;
}

.products-list-section {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.products-list-section h2 {
    color: #333;
    margin-bottom: 20px;
}

.products-table {
    overflow-x: auto;
}

.products-table table {
    width: 100%;
    border-collapse: collapse;
}

.products-table th,
.products-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.products-table th {
    background: #f8f9fa;
    font-weight: bold;
    color: #333;
}

.product-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.btn-view,
.btn-edit,
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

.btn-edit {
    background: #ffc107;
}

.btn-delete {
    background: #dc3545;
}

.btn-view:hover {
    background: #138496;
}

.btn-edit:hover {
    background: #e0a800;
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
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .admin-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .products-table {
        font-size: 14px;
    }
    
    .products-table th,
    .products-table td {
        padding: 8px 5px;
    }
}
</style>

<script>
function editProduct(productId) {
    // TODO: Implement edit functionality
    alert('Chức năng sửa sản phẩm sẽ được phát triển sau!');
}
</script> 