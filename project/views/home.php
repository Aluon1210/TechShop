<div class="main-content">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">Khám Phá Thế Giới Công Nghệ</h1>
                    <p class="hero-subtitle">Trải nghiệm những sản phẩm công nghệ tiên tiến nhất với chất lượng đảm bảo và giá cả hợp lý</p>
                    <div class="hero-buttons">
                        <a href="?page=products" class="btn-primary">
                            <i class="fas fa-shopping-bag"></i>
                            Mua Sắm Ngay
                        </a>
                        <a href="#featured-products" class="btn-secondary">
                            <i class="fas fa-star"></i>
                            Sản Phẩm Nổi Bật
                        </a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="assets/images/hero-tech.jpg" alt="TechShop Hero" onerror="this.src='https://images.unsplash.com/photo-1498049794561-7780e7231661?w=600&h=400&fit=crop'">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3>Giao Hàng Nhanh</h3>
                    <p>Giao hàng miễn phí toàn quốc cho đơn hàng từ 500K</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Bảo Hành Chính Hãng</h3>
                    <p>Cam kết 100% sản phẩm chính hãng với bảo hành đầy đủ</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Hỗ Trợ 24/7</h3>
                    <p>Đội ngũ tư vấn chuyên nghiệp sẵn sàng hỗ trợ mọi lúc</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <h3>Đổi Trả Dễ Dàng</h3>
                    <p>Chính sách đổi trả linh hoạt trong vòng 30 ngày</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="section-header">
                <h2>Danh Mục Sản Phẩm</h2>
                <p>Khám phá các danh mục sản phẩm đa dạng của chúng tôi</p>
            </div>
            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=200&fit=crop" alt="Laptop">
                    </div>
                    <div class="category-content">
                        <h3>Laptop</h3>
                        <p>Laptop gaming, văn phòng, ultrabook</p>
                        <a href="?page=products&category=laptop" class="category-link">Xem thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300&h=200&fit=crop" alt="Smartphone">
                    </div>
                    <div class="category-content">
                        <h3>Smartphone</h3>
                        <p>Điện thoại thông minh các thương hiệu</p>
                        <a href="?page=products&category=smartphone" class="category-link">Xem thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=300&h=200&fit=crop" alt="Headphones">
                    </div>
                    <div class="category-content">
                        <h3>Tai Nghe</h3>
                        <p>Tai nghe gaming, âm thanh chất lượng cao</p>
                        <a href="?page=products&category=headphones" class="category-link">Xem thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="category-card">
                    <div class="category-image">
                        <img src="https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=300&h=200&fit=crop" alt="Accessories">
                    </div>
                    <div class="category-content">
                        <h3>Phụ Kiện</h3>
                        <p>Chuột, bàn phím, sạc dự phòng</p>
                        <a href="?page=products&category=accessories" class="category-link">Xem thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products-section" id="featured-products">
        <div class="container">
            <div class="section-header">
                <h2>Sản Phẩm Nổi Bật</h2>
                <p>Những sản phẩm được yêu thích nhất tại TechShop</p>
            </div>
            
            <div class="products-grid">
                <?php if (!empty($featuredProducts)): ?>
                    <?php foreach ($featuredProducts as $product): ?>
                        <div class="product-card">
                            <div class="product-image-container">
                                <img src="<?php echo htmlspecialchars($product['Image'] ?? 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=300&h=300&fit=crop'); ?>" 
                                     alt="<?php echo htmlspecialchars($product['Name']); ?>" 
                                     class="product-image">
                                <div class="product-overlay">
                                    <button class="btn-quick-view" onclick="viewProduct('<?php echo $product['Product_Id']; ?>')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-add-cart" onclick="addToCart('<?php echo $product['Product_Id']; ?>')">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                                <?php if (isset($product['discount']) && $product['discount'] > 0): ?>
                                    <div class="product-badge">-<?php echo $product['discount']; ?>%</div>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <div class="product-brand"><?php echo htmlspecialchars($product['Brand_Name'] ?? 'TechShop'); ?></div>
                                <h3 class="product-title"><?php echo htmlspecialchars($product['Name']); ?></h3>
                                <div class="product-rating">
                                    <div class="stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <span class="rating-count">(4.5)</span>
                                </div>
                                <div class="product-price">
                                    <span class="current-price"><?php echo number_format($product['Price']); ?> VNĐ</span>
                                    <?php if (isset($product['original_price']) && $product['original_price'] > $product['Price']): ?>
                                        <span class="original-price"><?php echo number_format($product['original_price']); ?> VNĐ</span>
                                    <?php endif; ?>
                                </div>
                                <button class="btn-add-to-cart" onclick="addToCart('<?php echo $product['Product_Id']; ?>')">
                                    <i class="fas fa-shopping-cart"></i>
                                    Thêm Vào Giỏ
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-products">
                        <i class="fas fa-box-open"></i>
                        <h3>Chưa có sản phẩm nào</h3>
                        <p>Hãy quay lại sau để khám phá những sản phẩm mới nhất</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="section-footer">
                <a href="?page=products" class="btn-view-all">
                    Xem Tất Cả Sản Phẩm
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <div class="newsletter-text">
                    <h3>Đăng Ký Nhận Tin</h3>
                    <p>Nhận thông tin về sản phẩm mới và ưu đãi đặc biệt</p>
                </div>
                <div class="newsletter-form">
                    <form class="newsletter-form-container">
                        <input type="email" placeholder="Nhập email của bạn..." required>
                        <button type="submit">
                            <i class="fas fa-paper-plane"></i>
                            Đăng Ký
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="brands-section">
        <div class="container">
            <div class="section-header">
                <h2>Thương Hiệu Đối Tác</h2>
                <p>Chúng tôi hợp tác với những thương hiệu hàng đầu thế giới</p>
            </div>
            <div class="brands-slider">
                <div class="brand-item">
                    <img src="https://logos-world.net/wp-content/uploads/2020/09/Apple-Logo.png" alt="Apple">
                </div>
                <div class="brand-item">
                    <img src="https://logos-world.net/wp-content/uploads/2020/09/Samsung-Logo.png" alt="Samsung">
                </div>
                <div class="brand-item">
                    <img src="https://logos-world.net/wp-content/uploads/2020/11/Dell-Logo.png" alt="Dell">
                </div>
                <div class="brand-item">
                    <img src="https://logos-world.net/wp-content/uploads/2020/11/HP-Logo.png" alt="HP">
                </div>
                <div class="brand-item">
                    <img src="https://logos-world.net/wp-content/uploads/2020/11/Asus-Logo.png" alt="ASUS">
                </div>
                <div class="brand-item">
                    <img src="https://logos-world.net/wp-content/uploads/2020/11/Lenovo-Logo.png" alt="Lenovo">
                </div>
            </div>
        </div>
    </section>
</div>

<script>
// Add to cart function
function addToCart(productId) {
    if (!productId) {
        showNotification('Lỗi: Không tìm thấy sản phẩm', 'error');
        return;
    }

    // Show loading state
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
    button.disabled = true;

    // AJAX call to add product to cart
    fetch('?page=ajax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=add_to_cart&product_id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
            updateCartCount();
        } else {
            showNotification(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
    })
    .finally(() => {
        // Restore button state
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// View product function
function viewProduct(productId) {
    window.location.href = `?page=product-detail&id=${productId}`;
}

// Update cart count
function updateCartCount() {
    fetch('?page=ajax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=get_cart_count'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = data.count;
                
                // Update all cart count displays
                const allCartCounts = document.querySelectorAll('.cart-count, [data-cart-count]');
                allCartCounts.forEach(element => {
                    element.textContent = data.count;
                });
            }
        }
    })
    .catch(error => console.error('Error updating cart count:', error));
}

// Show notification
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

    // Add to page
    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Newsletter form submission
document.querySelector('.newsletter-form-container').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = this.querySelector('input[type="email"]').value;
    
    if (email) {
        showNotification('Cảm ơn bạn đã đăng ký nhận tin!', 'success');
        this.reset();
    }
});

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Add animation classes to elements when they come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observe elements for animation
    document.querySelectorAll('.feature-card, .category-card, .product-card').forEach(el => {
        observer.observe(el);
    });
});
</script> 