<?php /* sale.php — Trang Giảm giá (3 khối: 2 gradient + 1 đỏ) */ ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Giảm giá - YesStyle</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="CSS/style.css">
  <style>
    /* ====== SALE page minimal styles (khớp giao diện bạn gửi) ====== */
    .sale-wrap{ max-width:1240px; margin:18px auto 40px; padding:0 24px; }
    .sale-row{ display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-top:16px; }
    .sale-panel{
      border-radius:14px; overflow:hidden;
      border:1px solid var(--line);
      box-shadow: var(--shadow-1);
      padding:14px;
    }
    .sale-panel .head{
      display:flex; align-items:center; justify-content:space-between;
      margin-bottom:10px; color:#111827; font-weight:900;
    }
    .sale-panel .head .ttl{ font-size:1.05rem; letter-spacing:.2px; }
    .sale-grid{ display:grid; grid-template-columns: repeat(4, 1fr); gap:10px; }
    .sale-item{
      background:#fff; border:1px solid var(--line); border-radius:12px; overflow:hidden;
      aspect-ratio:1/1; display:flex; align-items:center; justify-content:center; font-size:.9rem; color:#6b7280;
    }
    .sale-cta{ text-align:center; margin-top:10px; }
    .sale-cta .btn-primary{ border-radius:999px; padding:8px 14px; }

    /* 2 khối gradient trên */
    .sale-gradient-1{ background: linear-gradient(135deg,#9333ea,#22d3ee); }
    .sale-gradient-2{ background: linear-gradient(135deg,#22c55e,#f59e0b); }

    /* Khối đỏ dưới (clearance) */
    .sale-red{
      background: #ef4444;
      color:#fff;
      padding:16px;
      border-radius:14px;
      border:1px solid rgba(255,255,255,.2);
      box-shadow: var(--shadow-1);
      margin-top:18px;
    }
    .sale-red .head{ color:#fff; }
    .sale-red .sale-item{ background: rgba(255,255,255,.95); }

    @media (max-width:1024px){
      .sale-grid{ grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width:768px){
      .sale-row{ grid-template-columns: 1fr; }
      .sale-grid{ grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width:520px){
      .sale-grid{ grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body>

  <!-- ================ HEADER (giữ nguyên giống các trang khác) ================ -->
  <header class="site-header">
    <div class="top-bar container">
      <div class="regions">
        <select aria-label="Quốc gia/khu vực">
          <option>Việt Nam</option>
          <option>Hoa Kỳ</option>
        </select>
      </div>
      <div class="user-links">
        <a href="#" onclick="openModal('authModal')">Đăng nhập</a>
        <a href="cart.php">Giỏ hàng <span id="cart-count">0</span></a>
      </div>
    </div>

    <div class="header-main container">
      <a class="logo" href="index.php">yessstyle</a>
      <nav class="nav-menu">
        <button class="hamburger" id="nav-toggle" aria-label="Mở menu"><i class="fas fa-bars"></i></button>
        <ul id="main-menu" class="menu-list">
          <!-- BEAUTY / WOMEN / MEN / LIFESTYLE (giữ nguyên) -->
          <li class="dropdown mega"><button class="dropdown-toggle">Mỹ phẩm</button></li>
          <li class="dropdown mega"><button class="dropdown-toggle">Nữ</button></li>
          <li class="dropdown mega"><button class="dropdown-toggle">Nam</button></li>
          <li class="dropdown mega"><button class="dropdown-toggle">Phong cách sống</button></li>

          <!-- SALE nổi bật -->
          <li><a class="nav-sale" href="sale.php" aria-current="page">SALE</a></li>

          <!-- CONTACT -->
          <li><a href="#" onclick="openModal('contactModal')">Liên hệ</a></li>
        </ul>
        <button class="search-btn" onclick="showSearchModal()" aria-label="Tìm kiếm"><i class="fas fa-search"></i></button>
      </nav>
    </div>
  </header>

  <!-- ================ SALE CONTENT (3 khối) ================ -->
  <main class="sale-wrap">
    <!-- Hàng trên: 2 gradient -->
    <div class="sale-row">
      <!-- Khối 1 -->
      <section class="sale-panel sale-gradient-1">
        <div class="head">
          <div class="ttl">FLASH SALES UP TO 35% OFF</div>
          <span class="badge" style="background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.45);border-radius:999px;padding:4px 8px;">Đếm ngược</span>
        </div>
        <div class="sale-grid">
          <div class="sale-item">Fashion</div>
          <div class="sale-item">Fashion</div>
          <div class="sale-item">Fashion</div>
          <div class="sale-item">Fashion</div>
          <div class="sale-item">Fashion</div>
          <div class="sale-item">Fashion</div>
          <div class="sale-item">Fashion</div>
          <div class="sale-item">Fashion</div>
        </div>
        <div class="sale-cta"><a class="btn-primary" href="#">MORE FASHION</a></div>
      </section>

      <!-- Khối 2 -->
      <section class="sale-panel sale-gradient-2">
        <div class="head">
          <div class="ttl">FLASH SALES UP TO 50% OFF</div>
          <span class="badge" style="background:rgba(255,255,255,.2);border:1px solid rgba(255,255,255,.45);border-radius:999px;padding:4px 8px;">Đếm ngược</span>
        </div>
        <div class="sale-grid">
          <div class="sale-item">Beauty</div>
          <div class="sale-item">Beauty</div>
          <div class="sale-item">Beauty</div>
          <div class="sale-item">Beauty</div>
          <div class="sale-item">Beauty</div>
          <div class="sale-item">Beauty</div>
          <div class="sale-item">Beauty</div>
          <div class="sale-item">Beauty</div>
        </div>
        <div class="sale-cta"><a class="btn-primary" href="#">MORE BEAUTY</a></div>
      </section>
    </div>

    <!-- Hàng dưới: 1 khối đỏ (Clearance) -->
    <section class="sale-red">
      <div class="head">
        <div class="ttl">CLEARANCE UP TO 60% OFF</div>
      </div>
      <div class="sale-grid" style="grid-template-columns: repeat(4,1fr);">
        <div class="sale-item">More Fashion</div>
        <div class="sale-item">More Beauty</div>
        <div class="sale-item">More Men's</div>
        <div class="sale-item">More Lifestyle</div>
      </div>
      <div class="sale-cta" style="margin-top:12px;">
        <a class="btn-ghost" href="#">Xem thêm</a>
      </div>
    </section>
  </main>

  <!-- ================ FOOTER (giữ nguyên) ================ -->
  <footer class="site-footer">
    <div class="footer-main container">
      <div class="footer-brand-large"><p>YesStyle</p></div>
      <div class="footer-links-group">
        <a href="#" onclick="openModal('contactModal')">Liên hệ</a>
        <a href="#">Điều khoản</a>
        <a href="#">Quyền riêng tư</a>
      </div>
      <div class="footer-copyright-group">
        <p>&copy; 2025 YesStyle. Bảo lưu mọi quyền.</p>
      </div>
    </div>
  </footer>

  <!-- Shared modals + JS (tùy dự án của bạn) -->
  <div id="contactModal" class="modal"><div class="modal-content"><span class="close" onclick="closeModal('contactModal')">&times;</span><h2>Liên hệ</h2></div></div>
  <div id="searchModal" class="modal"><div class="modal-content"><span class="close" onclick="closeModal('searchModal')">&times;</span><h2>Tìm kiếm</h2><input id="search-input" placeholder="Nhập từ khoá rồi Enter..." /></div></div>

  <script src="JS/QA.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', ()=>{ updateCartCount && updateCartCount(); });
  </script>
</body>
</html>

