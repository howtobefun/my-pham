<?php
// (Tuỳ chọn) bật session sau này: session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YesStyle - Trang chủ</title>

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Font: Pretendard (đẹp, tròn, hỗ trợ tiếng Việt) -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/variable/pretendardvariable.css">
  <!-- Fallback cho trình duyệt cũ -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard/dist/web/static/pretendard.css">

  <!-- CSS chính -->
  <link rel="stylesheet" href="CSS/style.css">

  <!-- Local styles giữ lại + làm nổi bật SALE -->
  <style>
    :root{
      --font-ui: "Pretendard Variable","Pretendard","Noto Sans KR",
                 ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Arial,"Helvetica Neue",sans-serif;
    }
    html{
      font-family: var(--font-ui) !important;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      letter-spacing: .2px;
    }
    :where(button,input,select,textarea){ font-family: inherit !important; }

    /* ===== NỔI BẬT MỤC SALE TRÊN NAV ===== */
    .nav-sale{
      display:inline-block;
      font-weight:900;
      color:#fff !important;
      background:#ef4444;                /* đỏ tươi */
      border:1px solid #ef4444;
      padding:8px 12px;
      border-radius:999px;
      box-shadow: 0 6px 20px rgba(239,68,68,.2);
      transition: transform .06s ease, box-shadow .2s ease, filter .2s ease;
    }
    .nav-sale:hover{
      transform: translateY(-1px);
      filter: brightness(1.02);
      box-shadow: 0 10px 28px rgba(239,68,68,.28);
    }

    /* ------ gradient wrappers (local styles m gửi) ------ */
    .gradient-box{ border-radius:14px; padding:16px; box-shadow: var(--shadow-1); border:1px solid rgba(255,255,255,.2); overflow:hidden; }
    .gradient-inner{ background: rgba(255,255,255,.10); border:1px solid rgba(255,255,255,.25); border-radius:12px; padding:12px; backdrop-filter: blur(2px); }
    .section-spacer{ margin-top:8px; }

    /* ------ NEW SECTIONS (tối thiểu) ------ */
    .editorial{ padding:28px 0; }
    .editorial-grid{ display:grid; grid-template-columns: repeat(3, 1fr); gap:14px; }
    .editorial-card{ background:#fff; border:1px solid var(--line); border-radius:14px; overflow:hidden; box-shadow: var(--shadow-1); transition: transform .12s ease, box-shadow .2s ease; }
    .editorial-card:hover{ transform: translateY(-2px); box-shadow: var(--shadow-2); }
    .editorial-thumb{ aspect-ratio:16/9; background:#f3f4f6; }
    .editorial-thumb img{ width:100%; height:100%; object-fit:cover; }
    .editorial-body{ padding:12px; }
    .editorial-title{ font-weight:900; margin-bottom:6px; }
    .editorial-link{ display:inline-block; margin-top:6px; color:#2563eb; font-weight:800; }

    .picks{ padding:28px 0; background:#f4fff0; border:1px solid var(--line); border-left:none; border-right:none; }
    .picks h2{ margin-top:14px; }
    .picks-grid{ display:grid; grid-template-columns: repeat(3, 1fr); gap:14px; }
    .pick-card{ background:#fff; border:1px solid var(--line); border-radius:14px; overflow:hidden; box-shadow: var(--shadow-1); transition: transform .12s, box-shadow .2s; }
    .pick-card:hover{ transform: translateY(-2px); box-shadow: var(--shadow-2); }
    .pick-thumb{ aspect-ratio:1/1; background:#f3f4f6; }
    .pick-thumb img{ width:100%; height:100%; object-fit:cover; }
    .pick-body{ padding:12px; }
    .stars{ color:#f59e0b; margin-bottom:6px; }
    .pick-title{ font-weight:800; margin-bottom:6px; }
    .pick-text{ color:#374151; font-size:.95rem; line-height:1.45; max-height:7.2em; overflow:hidden; }
    .load-more{ display:block; margin:16px auto 0; padding:8px 14px; border-radius:999px; background:#111; color:#fff; border:none; font-weight:800; cursor:pointer; }

    .sku-intro{ text-align:center; padding:32px 0; }
    .sku-intro p{ max-width:820px; margin:10px auto 0; color:#374151; }

    .link-cloud{ background:#fff; border:1px solid var(--line); border-radius:14px; padding:18px; box-shadow: var(--shadow-1); }
    .link-cloud-grid{ display:grid; grid-template-columns: repeat(5, 1fr); gap:18px; }
    .link-cloud ul{ list-style:none; }
    .link-cloud a{ color:#374151; font-size:.95rem; }
    .link-cloud a:hover{ text-decoration: underline; color:#111827; }

    /* ========= Recommended Categories ========= */
    .reco-cats{ margin-top:20px; background:#f6f7fb; border:1px solid var(--line); border-radius:14px; padding:18px; box-shadow:var(--shadow-1); }
    .reco-title{ text-align:center; font-weight:900; font-size:1.6rem; color:#111827; margin-bottom:12px; }
    .reco-grid{ display:grid; grid-template-columns: repeat(8, 1fr); gap:14px; align-items:start; }
    .reco-item{ text-align:center; }
    .reco-pic{ width:110px; height:110px; margin:0 auto 10px; border-radius:999px; overflow:hidden; border:1px solid var(--line); background: var(--ball, #f3f4f6); display:flex; align-items:center; justify-content:center; }
    .reco-pic img{ width:100%; height:100%; object-fit:cover; }
    .reco-name{ font-weight:700; font-size:.95rem; color:#111827; }

    @media (max-width:1200px){ .reco-grid{ grid-template-columns: repeat(6, 1fr); } }
    @media (max-width:1024px){
      .editorial-grid{ grid-template-columns: repeat(2,1fr); }
      .picks-grid{ grid-template-columns: repeat(2,1fr); }
      .link-cloud-grid{ grid-template-columns: repeat(3,1fr); }
      .reco-grid{ grid-template-columns: repeat(5, 1fr); }
    }
    @media (max-width:768px){
      .editorial-grid, .picks-grid{ grid-template-columns:1fr; }
      .link-cloud-grid{ grid-template-columns: repeat(2,1fr); }
      .reco-grid{ grid-template-columns: repeat(4, 1fr); }
    }
    @media (max-width:520px){
      .link-cloud-grid{ grid-template-columns:1fr; }
      .reco-grid{ grid-template-columns: repeat(2, 1fr); }
    }
    /* LƯU Ý: Hero banner gọn (biến --hero-h) đã nằm trong CSS/style.css */
  </style>
</head>
<body class="theme-dark">
  <!-- ================ HEADER ================ -->
  <header class="site-header">
    <div class="top-bar container">
      <div class="regions">
        <select id="region" aria-label="Quốc gia/khu vực">
          <option>Việt Nam</option>
          <option>English</option>
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
          <!-- ========= MỸ PHẨM ========= -->
          <li class="dropdown mega">
            <button class="dropdown-toggle">Mỹ phẩm</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=beauty&sub=new">Hàng mới về</a></li>
                  <li><a href="category.php?category=beauty&sub=instock">Sẵn hàng</a></li>
                  <li><a href="category.php?category=beauty&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=beauty&sub=flash">Flash Sale</a></li>
                  <li><a href="category.php?category=beauty&sub=valuesets">Bộ quà tặng</a></li>
                  <li><a href="category.php?category=beauty&sub=clearance">Xả kho</a></li>
                  <li><a href="category.php?category=beauty&sub=all">Tất cả mỹ phẩm</a></li>
                </ul>
              </div>

              <div class="mega-col">
                <h3 class="mega-title">Trang điểm</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=beauty&sub=cheeks">Má</a></li>
                  <li><a href="category.php?category=beauty&sub=eyes">Mắt</a></li>
                  <li><a href="category.php?category=beauty&sub=face">Nền</a></li>
                  <li><a href="category.php?category=beauty&sub=lips">Môi</a></li>
                </ul>

                <h3 class="mega-title" style="margin-top:14px;">Chăm sóc cơ thể</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=beauty&sub=bathshower">Tắm &amp; gội</a></li>
                  <li><a href="category.php?category=beauty&sub=bodymoist">Dưỡng thể</a></li>
                  <li><a href="category.php?category=beauty&sub=deodorants">Khử mùi</a></li>
                </ul>

                <h3 class="mega-title" style="margin-top:14px;">Chăm sóc tóc</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=beauty&sub=hairtreat">Ủ &amp; treatment</a></li>
                  <li><a href="category.php?category=beauty&sub=shampoos">Dầu gội</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/rg2.jpg" alt="Xu hướng làm đẹp"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjMzEzNDNhJy8+PC9zdmc+';">
                <p>Xu hướng làm đẹp</p>
              </div>
            </div>
          </li>

          <!-- ========= NỮ ========= -->
          <li class="dropdown mega">
            <button class="dropdown-toggle">Nữ</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=women&sub=new">Hàng mới về</a></li>
                  <li><a href="category.php?category=women&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=women&sub=sale">Khuyến mãi</a></li>
                  <li><a href="category.php?category=women&sub=all">Tất cả Nữ</a></li>
                </ul>
              </div>

              <div class="mega-col">
                <h3 class="mega-title">Quần áo</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=women&sub=activewear">Đồ thể thao</a></li>
                  <li><a href="category.php?category=women&sub=coats">Áo khoác</a></li>
                  <li><a href="category.php?category=women&sub=cosplay">Hoá trang</a></li>
                  <li><a href="category.php?category=women&sub=dancewear">Đồ nhảy</a></li>
                  <li><a href="category.php?category=women&sub=dresses">Váy đầm</a></li>
                  <li><a href="category.php?category=women&sub=jeans">Quần jeans</a></li>
                  <li><a href="category.php?category=women&sub=jumpsuits">Jumpsuit</a></li>
                  <li><a href="category.php?category=women&sub=lingerie">Đồ lót</a></li>
                  <li><a href="category.php?category=women&sub=maternity">Đồ bầu</a></li>
                  <li><a href="category.php?category=women&sub=pajamas">Đồ ngủ</a></li>
                  <li><a href="category.php?category=women&sub=pants">Quần dài</a></li>
                  <li><a href="category.php?category=women&sub=shorts">Quần short</a></li>
                  <li><a href="category.php?category=women&sub=skirts">Chân váy</a></li>
                  <li><a href="category.php?category=women&sub=socks">Tất/Vớ</a></li>
                  <li><a href="category.php?category=women&sub=swimwear">Đồ bơi</a></li>
                  <li><a href="category.php?category=women&sub=tops">Áo</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/women1.jpg" alt="Thời trang Nữ"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjMzEzNDNhJy8+PC9zdmc+';">
                <p>Thời trang Nữ</p>
              </div>
            </div>
          </li>

          <!-- ========= NAM ========= -->
          <li class="dropdown mega">
            <button class="dropdown-toggle">Nam</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=men&sub=new">Hàng mới về</a></li>
                  <li><a href="category.php?category=men&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=men&sub=sale">Khuyến mãi</a></li>
                  <li><a href="category.php?category=men&sub=all">Tất cả Nam</a></li>
                </ul>
              </div>

              <div class="mega-col">
                <h3 class="mega-title">Quần áo</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=men&sub=cosplay">Hoá trang/tiệc</a></li>
                  <li><a href="category.php?category=men&sub=outerwear">Áo khoác</a></li>
                  <li><a href="category.php?category=men&sub=pants">Quần dài</a></li>
                  <li><a href="category.php?category=men&sub=shorts">Quần short</a></li>
                  <li><a href="category.php?category=men&sub=sleepwear">Đồ ngủ</a></li>
                  <li><a href="category.php?category=men&sub=socks">Tất</a></li>
                  <li><a href="category.php?category=men&sub=sportswear">Đồ thể thao</a></li>
                  <li><a href="category.php?category=men&sub=suits">Suit/Vest</a></li>
                  <li><a href="category.php?category=men&sub=swimwear">Đồ bơi</a></li>
                  <li><a href="category.php?category=men&sub=tops">Áo</a></li>
                  <li><a href="category.php?category=men&sub=undergarments">Đồ lót</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/men1.jpg" alt="Thời trang Nam"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjMzEzNDNhJy8+PC9zdmc+';">
                <p>Thời trang Nam</p>
              </div>
            </div>
          </li>

          <!-- ========= PHONG CÁCH SỐNG ========= -->
          <li class="dropdown mega">
            <button class="dropdown-toggle">Phong cách sống</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=lifestyle&sub=new">Hàng mới về</a></li>
                  <li><a href="category.php?category=lifestyle&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=lifestyle&sub=sale">Khuyến mãi</a></li>
                  <li><a href="category.php?category=lifestyle&sub=all">Tất cả Lifestyle</a></li>
                </ul>
              </div>

              <div class="mega-col">
                <h3 class="mega-title">Danh mục</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=lifestyle&sub=arts">Thủ công &amp; DIY</a></li>
                  <li><a href="category.php?category=lifestyle&sub=electronics">Phụ kiện điện tử</a></li>
                  <li><a href="category.php?category=lifestyle&sub=gadgets">Đồ chơi &amp; gadget</a></li>
                  <li><a href="category.php?category=lifestyle&sub=homeware">Đồ gia dụng</a></li>
                  <li><a href="category.php?category=lifestyle&sub=devices">Thiết bị lifestyle</a></li>
                  <li><a href="category.php?category=lifestyle&sub=spiritual">Tâm linh &amp; phong thuỷ</a></li>
                  <li><a href="category.php?category=lifestyle&sub=outdoor">Đồ dã ngoại</a></li>
                  <li><a href="category.php?category=lifestyle&sub=pet">Thú cưng</a></li>
                  <li><a href="category.php?category=lifestyle&sub=sports">Phụ kiện thể thao</a></li>
                  <li><a href="category.php?category=lifestyle&sub=stationery">Văn phòng phẩm</a></li>
                  <li><a href="category.php?category=lifestyle&sub=travel">Đồ du lịch</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/health1.jpg" alt="Sống khỏe"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjMzEzNDNhJy8+PC9zdmc+';">
                <p>Sống khoẻ</p>
              </div>
            </div>
          </li>

          <!-- ========= SALE (nổi bật, mở trang riêng) ========= -->
          <li><a class="nav-sale" href="sale.php">SALE</a></li>

          <li><a href="#" onclick="openModal('contactModal')">Liên hệ</a></li>
        </ul>

        <button class="search-btn" onclick="showSearchModal()" aria-label="Tìm kiếm"><i class="fas fa-search"></i></button>
      </nav>
    </div>
  </header>

  <!-- ================ PROMO RIBBON ================ -->
  <div class="promo-ribbon" id="promoRibbonDaily">
    <div class="inner container">
      <span class="badge">Giảm 8% đơn từ US$ 79</span>
      <span class="badge">Giảm 10% đơn từ US$ 149</span>
      <span class="badge">Giảm 15% đơn từ US$ 199</span>
      <span>Nhập mã: <b>SPOOKY25</b></span>

      <div class="promo-timer" aria-label="Thời gian còn lại">
        <div class="slot" data-slot="days">00</div>:
        <div class="slot" data-slot="hours">00</div>:
        <div class="slot" data-slot="minutes">00</div>:
        <div class="slot" data-slot="seconds">00</div>
      </div>

      <a href="#" style="text-decoration:underline;color:#fff;">Xem chi tiết</a>
    </div>
  </div>

  <!-- ================ HERO SLIDER (gọn theo CSS/style.css) ================ -->
  <section class="hero-slider">
    <div class="slider-wrapper">
      <div class="slider-item active" style="background-image:url('images/anh/bg1.jpg')">
        <div class="container">
          <h1>Ưu đãi nóng trong tuần</h1>
          <p>Giảm đến 70% cho các sản phẩm hot!</p>
          <button class="btn-primary" onclick="location.href='category.php?category=beauty&sub=flash'">Mua ngay</button>
        </div>
      </div>
      <div class="slider-item" style="background-image:url('images/anh/bg2.jpg')">
        <div class="container">
          <h1>Hàng mới cập bến!</h1>
          <p>Khám phá xu hướng mới nhất.</p>
          <button class="btn-primary" onclick="location.href='category.php?category=beauty&sub=new'">Khám phá</button>
        </div>
      </div>
      <div class="slider-item" style="background-image:url('images/anh/bg3.jpg')">
        <div class="container">
          <h1>Ưu đãi giới hạn</h1>
          <p>Đừng bỏ lỡ những deal hấp dẫn.</p>
          <button class="btn-primary" onclick="location.href='category.php?category=women&sub=sale'">Săn sale</button>
        </div>
      </div>
    </div>

    <div class="slider-nav">
      <button class="nav-prev" aria-label="Slide trước"><i class="fas fa-chevron-left"></i></button>
      <button class="nav-next" aria-label="Slide sau"><i class="fas fa-chevron-right"></i></button>
    </div>
    <div class="slider-dots"></div>
  </section>

  <!-- ================ WEEKLY BRAND BLOWOUT (GRADIENT) ================ -->
  <section class="brands container">
    <h2>Giảm sâu theo thương hiệu</h2>
    <div class="gradient-box" style="background: linear-gradient(135deg, #FFE0B2, #FF9AA2);">
      <div class="gradient-inner section-spacer">
        <div class="weekly-grid">
          <a class="weekly-item" href="detail.html?img=weekly1"><img src="images/anh/weekly1.jpg" alt="Tuần 1"></a>
          <a class="weekly-item" href="detail.html?img=weekly2"><img src="images/anh/weekly2.jpg" alt="Tuần 2"></a>
          <a class="weekly-item" href="detail.html?img=weekly3"><img src="images/anh/weekly3.jpg" alt="Tuần 3"></a>
          <a class="weekly-item" href="detail.html?img=weekly4"><img src="images/anh/weekly4.jpg" alt="Tuần 4"></a>
          <a class="weekly-item" href="detail.html?img=weekly5"><img src="images/anh/weekly5.jpg" alt="Tuần 5"></a>
          <a class="weekly-item" href="detail.html?img=weekly6"><img src="images/anh/weekly6.jpg" alt="Tuần 6"></a>
        </div>
      </div>
    </div>
  </section>

  <!-- ================ SHOP BY CATEGORY (GRADIENT) ================ -->
  <section class="categories container">
    <h2>Mua sắm theo danh mục</h2>
    <div class="gradient-box" style="background: linear-gradient(135deg, #84FAB0, #8FD3F4);">
      <div class="gradient-inner section-spacer">
        <div class="cat-grid">
          <a href="category.php?category=beauty&sub=serum" class="cat-card">
            <div class="cat-img"><img src="images/anh/sp1.jpg" alt="Serum"></div>
            <h3>Serum</h3>
          </a>
          <a href="category.php?category=beauty&sub=haircare" class="cat-card">
            <div class="cat-img"><img src="images/anh/sp3.jpg" alt="Dưỡng tóc"></div>
            <h3>Dưỡng tóc</h3>
          </a>
          <a href="category.php?category=beauty&sub=skincare" class="cat-card">
            <div class="cat-img"><img src="images/anh/sp2.jpg" alt="Dưỡng da"></div>
            <h3>Dưỡng da</h3>
          </a>
          <a href="category.php?category=beauty&sub=makeup" class="cat-card">
            <div class="cat-img"><img src="images/anh/sp4.jpg" alt="Trang điểm"></div>
            <h3>Trang điểm</h3>
          </a>
        </div>
      </div>
    </div>
  </section>

 

  <!-- ================ FLASH SALES + RECOMMENDED CATEGORIES ================ -->
  <section class="container" style="margin-top:40px;">
    <div class="flash-box">
      <h3 class="title">Flash Sale đến 50%</h3>
      <div class="product-grid" style="grid-template-columns:repeat(4,1fr);gap:12px;">
        <a class="product-card" href="detail.html?img=rg2">
          <div class="product-img"><img src="images/anh/rg2.jpg" alt="Torriden Dive-In Mask"></div>
          <h3 class="product-title">Torriden Dive-In Mask</h3>
          <p class="price">$3.50</p>
          <div class="center" style="margin-top:6px;"><span class="btn-ghost">Xem chi tiết</span></div>
        </a>
        <a class="product-card" href="detail.html?img=rg3">
          <div class="product-img"><img src="images/anh/rg3.jpg" alt="I'm From Fig Scrub Mask"></div>
          <h3 class="product-title">I'm From Fig Scrub Mask</h3>
          <p class="price">$32.00</p>
          <div class="center" style="margin-top:6px;"><span class="btn-ghost">Xem chi tiết</span></div>
        </a>
        <a class="product-card" href="detail.html?img=rg1">
          <div class="product-img"><img src="images/anh/rg1.jpg" alt="La Mer Treatment Lotion"></div>
          <h3 class="product-title">La Mer Treatment Lotion</h3>
          <p class="price">$175.00</p>
          <div class="center" style="margin-top:6px;"><span class="btn-ghost">Xem chi tiết</span></div>
        </a>
        <a class="product-card" href="detail.html?img=sp5">
          <div class="product-img"><img src="images/anh/sp5.jpg" alt="Velvet Lip Tint"></div>
          <h3 class="product-title">Velvet Lip Tint</h3>
          <p class="price">$12.00</p>
          <div class="center" style="margin-top:6px;"><span class="btn-ghost">Xem chi tiết</span></div>
        </a>
      </div>
      <div style="text-align:center;margin-top:10px;">
        <button class="btn-primary" onclick="location.href='category.php?category=beauty&sub=flash'">XEM THÊM FLASH SALE</button>
      </div>
    </div>

    <!-- Danh mục gợi ý -->
    <div class="reco-cats" style="margin-top:20px;">
      <h3 class="reco-title">Danh mục gợi ý</h3>
      <div class="reco-grid">
        <a class="reco-item" href="category.php?category=beauty&sub=makeup">
          <div class="reco-pic" style="--ball:#ffe6ea"><img src="images/anh/danhmuc1.jpg" alt="Trang điểm"></div>
          <div class="reco-name">Trang điểm</div>
        </a>
        <a class="reco-item" href="category.php?category=beauty&sub=suncare">
          <div class="reco-pic" style="--ball:#eaf6ff"><img src="images/anh/danhmuc2.jpg" alt="Chống nắng"></div>
          <div class="reco-name">Chống nắng</div>
        </a>
        <a class="reco-item" href="category.php?category=beauty&sub=tools">
          <div class="reco-pic" style="--ball:#fff3db"><img src="images/anh/danhmuc3.jpg" alt="Dụng cụ &amp; cọ"></div>
          <div class="reco-name">Dụng cụ &amp; cọ</div>
        </a>
        <a class="reco-item" href="category.php?category=beauty&sub=masks">
          <div class="reco-pic" style="--ball:#ffe1ea"><img src="images/anh/danhmuc4.jpg" alt="Mặt nạ"></div>
          <div class="reco-name">Mặt nạ</div>
        </a>
        <a class="reco-item" href="category.php?category=beauty&sub=cleansers">
          <div class="reco-pic" style="--ball:#e7f5e7"><img src="images/anh/danhmuc5.jpg" alt="Sữa rửa mặt"></div>
          <div class="reco-name">Sữa rửa mặt</div>
        </a>
        <a class="reco-item" href="category.php?category=beauty&sub=handfoot">
          <div class="reco-pic" style="--ball:#f6eaff"><img src="images/anh/danhmuc6.jpg" alt="Chăm tay &amp; chân"></div>
          <div class="reco-name">Chăm tay &amp; chân</div>
        </a>
        <a class="reco-item" href="category.php?category=beauty&sub=haircare">
          <div class="reco-pic" style="--ball:#e8f7e8"><img src="images/anh/danhmuc7.jpg" alt="Chăm sóc tóc"></div>
          <div class="reco-name">Chăm sóc tóc</div>
        </a>
        <a class="reco-item" href="category.php?category=beauty&sub=moisturizers">
          <div class="reco-pic" style="--ball:#e9f5ff"><img src="images/anh/danhmuc8.jpg" alt="Kem dưỡng ẩm"></div>
          <div class="reco-name">Kem dưỡng ẩm</div>
        </a>
      </div>
    </div>
  </section>

  <!-- ==================== The Yesstylist ==================== -->
  <section id="ys-editorial" class="editorial container">
    <h2 style="text-align:left;margin:8px 0 14px;">Yesstylist Gợi ý</h2>
    <div class="editorial-grid">
      <a class="editorial-card" href="category.php?category=beauty&sub=skincare">
        <div class="editorial-thumb"><img src="images/anh/goiy1.jpg" alt="Chọn serum Anua"></div>
        <div class="editorial-body">
          <div class="editorial-title">Chọn serum Anua nào hợp với bạn?</div>
          <p class="editorial-excerpt">Hướng dẫn nhanh để chọn serum đúng mục tiêu da.</p>
          <span class="editorial-link">Đọc thêm</span>
        </div>
      </a>
      <a class="editorial-card" href="category.php?category=beauty&sub=all">
        <div class="editorial-thumb"><img src="images/anh/goiy2.jpg" alt="Chăm sóc bản thân"></div>
        <div class="editorial-body">
          <div class="editorial-title">F5 thói quen chăm sóc bản thân</div>
          <p class="editorial-excerpt">Làm mới routine với mẹo nhỏ và chọn lọc từ biên tập.</p>
          <span class="editorial-link">Đọc thêm</span>
        </div>
      </a>
      <a class="editorial-card" href="category.php?category=beauty&sub=makeup">
        <div class="editorial-thumb"><img src="images/anh/goiy3.jpg" alt="Sản phẩm tài trợ"></div>
        <div class="editorial-body">
          <div class="editorial-title">Sản phẩm nổi bật tháng này</div>
          <p class="editorial-excerpt">Khám phá item đang hot từ đối tác và thử ngay.</p>
          <span class="editorial-link">Đọc thêm</span>
        </div>
      </a>
    </div>
  </section>

  <!-- ==================== Khách chọn nhiều ==================== -->
  <section id="ys-picks" class="picks">
    <div class="container">
      <h2>Khách chọn nhiều</h2>
      <div class="picks-grid">
        <a class="pick-card" href="detail.html?img=rg3">
          <div class="pick-thumb"><img src="images/anh/khachchonnhieu1.jpg" alt="Fig Scrub Mask"></div>
          <div class="pick-body">
            <div class="stars">★★★★☆</div>
            <div class="pick-title">Fig Scrub Mask</div>
            <div class="pick-text">“Da mịn hơn sau vài lần. Mùi fig dễ chịu, hạt scrub mịn…”</div>
          </div>
        </a>
        <a class="pick-card" href="detail.html?img=rg2">
          <div class="pick-thumb"><img src="images/anh/khachchonnhieu2.jpg" alt="Dive-In Sheet Mask"></div>
          <div class="pick-body">
            <div class="stars">★★★★☆</div>
            <div class="pick-title">Dive-In Sheet Mask</div>
            <div class="pick-text">“Cấp ẩm nhanh, đắp xong da căng và dịu ngay. Giá ổn.”</div>
          </div>
        </a>
        <a class="pick-card" href="detail.html?img=rg1">
          <div class="pick-thumb"><img src="images/anh/khachchonnhieu3.jpg" alt="La Mer Treatment Lotion"></div>
          <div class="pick-body">
            <div class="stars">★★★★★</div>
            <div class="pick-title">La Mer Treatment Lotion</div>
            <div class="pick-text">“Đắt nhưng đáng, thấm nhanh, nâng tông da rõ.”</div>
          </div>
        </a>
        <a class="pick-card" href="detail.html?img=sp5">
          <div class="pick-thumb"><img src="images/anh/khachchonnhieu4.jpg" alt="Velvet Lip Tint"></div>
          <div class="pick-body">
            <div class="stars">★★★★☆</div>
            <div class="pick-title">Maybelline Fit Me Matte</div>
            <div class="pick-text">“Màu chuẩn, giữ ẩm, không khô môi. Bao bì xinh.”</div>
          </div>
        </a>
        <a class="pick-card" href="detail.html?img=weekly1">
          <div class="pick-thumb"><img src="images/anh/khachchonnhieu5.jpg" alt="Brown Knit Polo"></div>
          <div class="pick-body">
            <div class="stars">★★★★★</div>
            <div class="pick-title">Innisfree My Real Squeeze Mask</div>
            <div class="pick-text">“Kết cấu nhẹ như không, thấm nhanh, không bết dính. Dưỡng ẩm tốt, phù hợp cho cả da nhạy cảm. Bao bì tối giản nhưng vẫn nổi bật nét hiện đại.”</div>
          </div>
        </a>
        <a class="pick-card" href="detail.html?img=weekly7">
          <div class="pick-thumb"><img src="images/anh/khachchonnhieu6.jpg" alt="Denim Collar Blouse"></div>
          <div class="pick-body">
            <div class="stars">★★★★☆</div>
            <div class="pick-title">MAC Matte Lipstick</div>
            <div class="pick-text">“Che phủ ổn, không dày mặt, tiệp da tự nhiên. Kiềm dầu tốt nhưng vẫn giữ được độ ẩm cho da. Thiết kế dạng pump tiện lợi, dễ kiểm soát lượng dùng.”</div>
          </div>
        </a>
      </div>
      <button id="picks-load-more" class="load-more">TẢI THÊM</button>
    </div>
  </section>

  <!-- ==================== Giới thiệu dòng chăm da ==================== -->
  <section id="ys-sku-intro" class="sku-intro container">
    <h2>Sản phẩm chăm sóc da</h2>
    <p>
      Bộ sưu tập mỹ phẩm chuẩn chỉnh, khám phá K-beauty &amp; J-beauty cho mọi quy trình: serum, toner,
      kem dưỡng, sữa rửa mặt, kem chống nắng… Duyệt nhanh best-sellers và brand indie kèm đánh giá thật
      từ cộng đồng YesStyle toàn cầu.
    </p>
  </section>

  <!-- ==================== Bạn có thể quan tâm ==================== -->
  <section id="ys-interest" class="container" style="margin-bottom:40px;">
    <div class="link-cloud">
      <h3 class="interest-title" style="text-align:center;margin-bottom:12px;color:#111827;">Bạn có thể quan tâm</h3>
      <div class="link-cloud-grid">
        <ul>
          <li><a href="category.php?category=beauty&sub=kbeauty">K-Beauty</a></li>
          <li><a href="category.php?category=beauty&sub=vitc">Serum Vitamin C</a></li>
          <li><a href="category.php?category=beauty&sub=hyaluronic">Hyaluronic Acid</a></li>
          <li><a href="category.php?category=beauty&sub=sunscreen">Kem chống nắng</a></li>
          <li><a href="category.php?category=beauty&sub=dryskinserum">Serum cho da khô</a></li>
        </ul>
        <ul>
          <li><a href="category.php?category=beauty&sub=jbeauty">J-Beauty</a></li>
          <li><a href="category.php?category=beauty&sub=kface">Mặt nạ Hàn Quốc</a></li>
          <li><a href="category.php?category=beauty&sub=niacinamide">Niacinamide</a></li>
          <li><a href="category.php?category=beauty&sub=bestsunscreen">Kem chống nắng cho mặt</a></li>
          <li><a href="category.php?category=beauty&sub=toners">Toner cho da dầu</a></li>
        </ul>
        <ul>
          <li><a href="category.php?category=beauty&sub=chinmakeup">Trang điểm Trung</a></li>
          <li><a href="category.php?category=beauty&sub=moisturizers">Kem dưỡng ẩm Hàn</a></li>
          <li><a href="category.php?category=beauty&sub=beta">Beta Hydroxy Acid</a></li>
          <li><a href="category.php?category=beauty&sub=mineral">Chống nắng khoáng</a></li>
          <li><a href="category.php?category=beauty&sub=sensitive">Dưỡng ẩm cho da nhạy cảm</a></li>
        </ul>
        <ul>
          <li><a href="category.php?category=beauty&sub=kskincare">Chăm sóc da Hàn</a></li>
          <li><a href="category.php?category=beauty&sub=kbb">Kem nền/BB Hàn</a></li>
          <li><a href="category.php?category=beauty&sub=probiotic">Dưỡng da Probiotic</a></li>
          <li><a href="category.php?category=beauty&sub=spf">Dưỡng ẩm có SPF</a></li>
          <li><a href="category.php?category=beauty&sub=cleansers">Sữa rửa mặt</a></li>
        </ul>
        <ul>
          <li><a href="category.php?category=beauty&sub=tools">Dụng cụ &amp; cọ</a></li>
          <li><a href="category.php?category=beauty&sub=haircare">Chăm sóc tóc</a></li>
          <li><a href="category.php?category=beauty&sub=moisturizers">Kem dưỡng ẩm</a></li>
          <li><a href="category.php?category=beauty&sub=suncare">Chăm sóc chống nắng</a></li>
          <li><a href="category.php?category=beauty&sub=cleanser">Rửa mặt</a></li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ================ FOOTER ================ -->
  <footer class="site-footer">
    <div class="footer-main container">
      <div class="footer-brand-large">
        <p>YesStyle</p>
      </div>
      <div class="footer-links-group">
        <a href="#" onclick="openModal('contactModal')">Liên hệ</a>
        <a href="#">Điều khoản</a>
        <a href="#">Quyền riêng tư</a>
      </div>
      <div class="footer-copyright-group">
        <p>&copy; 2025 YesStyle. Đã đăng ký bản quyền.</p>
      </div>
    </div>
  </footer>

  <!-- ================ MODALS DÙNG CHUNG ================ -->
  <!-- Cart -->
  <div id="cartModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('cartModal')">&times;</span>
      <h2>Giỏ hàng</h2>
      <div id="cart-items"></div>
    </div>
  </div>

  <!-- Contact -->
  <div id="contactModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('contactModal')">&times;</span>
      <h2>Liên hệ</h2>
      <form id="contact-form">
        <div class="form-group"><input placeholder="Tên của bạn" required></div>
        <div class="form-group"><input type="email" placeholder="Email" required></div>
        <div class="form-group"><textarea placeholder="Nội dung" required></textarea></div>
        <button type="submit" class="btn-primary">Gửi</button>
      </form>
    </div>
  </div>

  <!-- Search -->
  <div id="searchModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('searchModal')">&times;</span>
      <h2>Tìm kiếm</h2>
      <input id="search-input" placeholder="Nhập từ khoá rồi Enter..." />
      <div id="search-results"></div>
    </div>
  </div>

  <!-- Auth -->
  <div id="authModal" class="modal">
    <div class="modal-content" style="max-width:540px">
      <span class="close" onclick="closeModal('authModal')">&times;</span>
      <div style="display:flex;gap:8px;margin-bottom:16px;">
        <button id="tab-signin" class="btn-primary" style="padding:8px 14px;">Thành viên</button>
        <button id="tab-register" class="btn-primary" style="padding:8px 14px;opacity:.8;">Người mới</button>
      </div>

      <div id="pane-signin">
        <h3 style="margin-bottom:10px;">Đăng nhập</h3>
        <div class="form-group"><input type="email" placeholder="Email"></div>
        <div class="form-group"><input type="password" placeholder="Mật khẩu"></div>
        <button class="btn-primary" style="width:100%;">ĐĂNG NHẬP</button>
      </div>

      <div id="pane-register" style="display:none;">
        <h3 style="margin-bottom:10px;">Đăng ký</h3>
        <div class="form-group"><input type="email" placeholder="Email"></div>
        <div class="form-group"><input type="password" placeholder="Mật khẩu"></div>
        <button class="btn-primary" style="width:100%;">ĐĂNG KÝ</button>
      </div>
    </div>
  </div>

  <!-- ================ SCRIPTS ================ -->
  <script src="JS/QA.js"></script>
  <script>
    // Đếm ngược THEO NGÀY (đến 23:59:59 hôm nay, tự reset mỗi ngày)
    (function startDailyCountdown(){
      const bar = document.getElementById('promoRibbonDaily');
      if (!bar) return;

      const slots = {
        d: bar.querySelector('[data-slot="days"]'),
        h: bar.querySelector('[data-slot="hours"]'),
        m: bar.querySelector('[data-slot="minutes"]'),
        s: bar.querySelector('[data-slot="seconds"]')
      };

      function getTodayEnd(){
        const now = new Date();
        const end = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59, 999);
        return end;
      }

      function update(){
        const end = getTodayEnd();
        let diff = end.getTime() - Date.now();
        if (diff < 0) diff = 0;

        const days  = Math.floor(diff / 86400000);
        const hours = Math.floor((diff % 86400000) / 3600000);
        const mins  = Math.floor((diff % 3600000) / 60000);
        const secs  = Math.floor((diff % 60000) / 1000);

        if (slots.d) slots.d.textContent = String(days).padStart(2,'0');
        if (slots.h) slots.h.textContent = String(hours).padStart(2,'0');
        if (slots.m) slots.m.textContent = String(mins).padStart(2,'0');
        if (slots.s) slots.s.textContent = String(secs).padStart(2,'0');
      }

      update();
      setInterval(update, 1000);
    })();

    // Khởi tạo slider + lưới sản phẩm mặc định + tab đăng nhập/đăng ký
    document.addEventListener('DOMContentLoaded', () => {
      updateCartCount && updateCartCount();
      loadGrid && loadGrid('beauty');           // lưới sản phẩm mặc định
      setupHeroSlider && setupHeroSlider();     // slider (trong QA.js)

      // Tab chuyển Thành viên/Người mới
      const si = document.getElementById('tab-signin');
      const rg = document.getElementById('tab-register');
      const ps = document.getElementById('pane-signin');
      const pr = document.getElementById('pane-register');
      if (si && rg) {
        si.addEventListener('click', () => { ps.style.display='block'; pr.style.display='none'; si.style.opacity=1; rg.style.opacity=.8; });
        rg.addEventListener('click', () => { ps.style.display='none'; pr.style.display='block'; si.style.opacity=.8; rg.style.opacity=1; });
      }
    });
  </script>
</body>
</html>
