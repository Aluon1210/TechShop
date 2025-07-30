<div class="main-content">
    <div class="container">
        <div class="profile-section">
            <h1>Thông tin cá nhân</h1>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="profile-form">
                <div class="form-group">
                    <label for="UserName">Tên đăng nhập:</label>
                    <input type="text" id="UserName" value="<?php echo htmlspecialchars($user['UserName']); ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="FullName">Họ và tên:</label>
                    <input type="text" id="FullName" name="FullName" value="<?php echo htmlspecialchars($user['FullName']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input type="email" id="Email" name="Email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="Phone">Số điện thoại:</label>
                    <input type="text" id="Phone" name="Phone" value="<?php echo htmlspecialchars($user['Phone']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="Adress">Địa chỉ:</label>
                    <textarea id="Adress" name="Adress" rows="3" required><?php echo htmlspecialchars($user['Adress']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="Role">Vai trò:</label>
                    <input type="text" id="Role" value="<?php echo htmlspecialchars($user['Role']); ?>" readonly>
                </div>
                
                <button type="submit" class="btn-primary">Cập nhật thông tin</button>
            </form>
        </div>
    </div>
</div>

<style>
.profile-section {
    max-width: 600px;
    margin: 50px auto;
    padding: 30px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.profile-section h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
}

.profile-form {
    display: flex;
    flex-direction: column;
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
.form-group textarea {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.form-group input[readonly] {
    background-color: #f5f5f5;
    color: #666;
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
}

.btn-primary:hover {
    background: #0056b3;
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
</style> 