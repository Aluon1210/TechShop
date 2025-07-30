<nav class="navigation">
    <div class="container">
        <div class="nav-content">
            <div class="nav-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="?page=home">Trang chủ</a></li>
                <li class="dropdown">
                    <a href="?page=products">Sản phẩm <i class="fas fa-chevron-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="?page=products&category=laptop">Laptop</a></li>
                        <li><a href="?page=products&category=phone">Điện thoại</a></li>
                        <li><a href="?page=products&category=tablet">Máy tính bảng</a></li>
                        <li><a href="?page=products&category=accessory">Phụ kiện</a></li>
                    </ul>
                </li>
                <li><a href="?page=about">Giới thiệu</a></li>
                <li><a href="?page=contact">Liên hệ</a></li>
            </ul>
        </div>
    </div>
</nav>

<script>
document.getElementById('navToggle').addEventListener('click', function() {
    document.getElementById('navMenu').classList.toggle('active');
    this.classList.toggle('active');
});
</script> 