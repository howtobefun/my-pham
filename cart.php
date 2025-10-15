<?php /* cart.php — Giỏ hàng (frontend, localStorage) */ ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giỏ hàng - YesStyle</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="CSS/style.css">
  <style>
    /* ===== Cart page local styles (có thể chuyển sang CSS/style.css khi muốn) ===== */
    .cart-wrap{ max-width:1040px; margin:24px auto 48px; padding:0 24px; }
    .cart-title{ font-size:1.6rem; font-weight:900; margin:8px 0 14px; color:#111827; }
    .cart-header{
      background:#fff; border:1px solid var(--line); border-radius:14px; padding:16px;
      box-shadow: var(--shadow-1); margin-bottom:16px;
    }
    .cart-empty{
      text-align:center; color:#374151; padding:20px 10px; border:1px dashed var(--line);
      border-radius:12px; background:#fbfdff;
    }
    .cart-actions-top{ display:flex; gap:10px; flex-wrap:wrap; }
    .btn-outline{
      background:#fff; color:#111827; border:1px solid var(--line);
      border-radius:10px; padding:10px 14px; font-weight:800; cursor:pointer;
    }
    .cart-grid{
      display:grid; grid-template-columns: 1fr 320px; gap:16px;
    }
    .cart-list{
      background:#fff; border:1px solid var(--line); border-radius:14px; box-shadow: var(--shadow-1);
    }
    .cart-row{
      display:grid; grid-template-columns: 88px 1fr 120px 100px 28px;
      gap:12px; padding:12px; align-items:center; border-bottom:1px solid var(--line);
    }
    .cart-row:last-child{ border-bottom:none; }
    .cart-thumb{ width:88px; height:88px; border-radius:12px; overflow:hidden; background:#f3f4f6; border:1px solid var(--line); }
    .cart-thumb img{ width:100%; height:100%; object-fit:cover; }
    .cart-info .name{ font-weight:800; margin-bottom:4px; }
    .cart-info .brand{ color:var(--muted); font-size:.9rem; }
    .cart-price, .cart-sub{ font-weight:900; text-align:right; }
    .qty-input{
      display:flex; align-items:center; gap:6px; justify-content:flex-end;
    }
    .qty-input input{
      width:56px; padding:8px; text-align:center; border:1px solid var(--line); border-radius:10px;
    }
    .remove-btn{
      background:none; border:none; color:#ef4444; cursor:pointer; font-size:18px;
    }

    .cart-summary{
      background:#fff; border:1px solid var(--line); border-radius:14px; box-shadow: var(--shadow-1);
      padding:14px;
    }
    .cart-summary h3{ font-size:1.1rem; font-weight:900; margin-bottom:10px; }
    .sum-row{ display:flex; justify-content:space-between; margin:6px 0; }
    .sum-row.total{ font-weight:900; font-size:1.1rem; padding-top:6px; border-top:1px dashed var(--line); }
    .sum-actions{ display:flex; flex-direction:column; gap:8px; margin-top:12px; }
    .note-mini{ font-size:.9rem; color:#6b7280; margin-top:6px; }

    /* Guarantee block */
    .guarantee{
      margin-top:18px; background:#ecfdf5; border:1px solid #bbf7d0; border-radius:14px; box-shadow: var(--shadow-1);
    }
    .guarantee h3{ text-align:center; font-size:1.15rem; font-weight:900; padding:14px 10px; color:#065f46; }
    .guarantee-grid{ display:grid; grid-template-columns: repeat(6, 1fr); gap:10px; padding:12px; }
    .g-card{
      background:#fff; border:1px solid var(--line); border-radius:12px; padding:12px; text-align:center;
    }
    .g-card .ic{ font-size:22px; margin-bottom:8px; }
    .g-card .ttl{ font-weight:800; margin-bottom:6px; }
    .g-card p{ color:#374151; font-size:.93rem; line-height:1.45; margin:0; }

    @media (max-width:1024px){
      .cart-grid{ grid-template-columns:1fr; }
      .guarantee-grid{ grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width:620px){
      .cart-row{ grid-template-columns: 72px 1fr 100px 88px 28px; }
      .cart-thumb{ width:72px; height:72px; }
      .guarantee-grid{ grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width:420px){
      .cart-row{ grid-template-columns: 72px 1fr 88px 72px 28px; gap:8px; }
      .qty-input input{ width:48px; }
    }
  </style>
</head>
<body class="theme-dark">

  <!-- ================= HEADER ================= -->
  <header class="site-header">
    <div class="top-bar container">
      <div class="regions">
        <select id="region" aria-label="Quốc gia/khu vực">
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
          <li class="dropdown mega">
            <button class="dropdown-toggle">Mỹ phẩm</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=beauty&sub=new">Hàng mới</a></li>
                  <li><a href="category.php?category=beauty&sub=instock">Có sẵn</a></li>
                  <li><a href="category.php?category=beauty&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=beauty&sub=flash">Ưu đãi chớp nhoáng</a></li>
                  <li><a href="category.php?category=beauty&sub=valuesets">Bộ quà tặng &amp; giá trị</a></li>
                  <li><a href="category.php?category=beauty&sub=clearance">Xả hàng</a></li>
                  <li><a href="category.php?category=beauty&sub=all">Tất cả mỹ phẩm</a></li>
                </ul>
              </div>
              <div class="mega-col">
                <h3 class="mega-title">Trang điểm</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=beauty&sub=cheeks">Má</a></li>
                  <li><a href="category.php?category=beauty&sub=eyes">Mắt</a></li>
                  <li><a href="category.php?category=beauty&sub=face">Khuôn mặt</a></li>
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
                  <li><a href="category.php?category=beauty&sub=hairtreat">Dưỡng/ủ tóc</a></li>
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

          <li class="dropdown mega">
            <button class="dropdown-toggle">Nữ</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=women&sub=new">Hàng mới</a></li>
                  <li><a href="category.php?category=women&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=women&sub=sale">Khuyến mãi</a></li>
                  <li><a href="category.php?category=women&sub=all">Tất cả nữ</a></li>
                </ul>
              </div>
              <div class="mega-col">
                <h3 class="mega-title">Quần áo</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=women&sub=activewear">Đồ tập</a></li>
                  <li><a href="category.php?category=women&sub=coats">Áo khoác</a></li>
                  <li><a href="category.php?category=women&sub=cosplay">Hóa trang</a></li>
                  <li><a href="category.php?category=women&sub=dancewear">Đồ khiêu vũ</a></li>
                  <li><a href="category.php?category=women&sub=dresses">Đầm</a></li>
                  <li><a href="category.php?category=women&sub=jeans">Quần jeans</a></li>
                  <li><a href="category.php?category=women&sub=jumpsuits">Jumpsuit</a></li>
                  <li><a href="category.php?category=women&sub=lingerie">Đồ lót</a></li>
                  <li><a href="category.php?category=women&sub=maternity">Đồ bầu</a></li>
                  <li><a href="category.php?category=women&sub=pajamas">Đồ ngủ</a></li>
                  <li><a href="category.php?category=women&sub=pants">Quần dài</a></li>
                  <li><a href="category.php?category=women&sub=shorts">Quần short</a></li>
                  <li><a href="category.php?category=women&sub=skirts">Chân váy</a></li>
                  <li><a href="category.php?category=women&sub=socks">Tất &amp; quần tất</a></li>
                  <li><a href="category.php?category=women&sub=swimwear">Đồ bơi</a></li>
                  <li><a href="category.php?category=women&sub=tops">Áo</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/women1.jpg" alt="Thời trang nữ"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjMzEzNDNhJy8+PC9zdmc+';">
                <p>Thời trang nữ</p>
              </div>
            </div>
          </li>

          <li class="dropdown mega">
            <button class="dropdown-toggle">Nam</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=men&sub=new">Hàng mới</a></li>
                  <li><a href="category.php?category=men&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=men&sub=sale">Khuyến mãi</a></li>
                  <li><a href="category.php?category=men&sub=all">Tất cả nam</a></li>
                </ul>
              </div>
              <div class="mega-col">
                <h3 class="mega-title">Quần áo</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=men&sub=cosplay">Hóa trang &amp; tiệc</a></li>
                  <li><a href="category.php?category=men&sub=outerwear">Áo khoác</a></li>
                  <li><a href="category.php?category=men&sub=pants">Quần dài</a></li>
                  <li><a href="category.php?category=men&sub=shorts">Quần short</a></li>
                  <li><a href="category.php?category=men&sub=sleepwear">Đồ ngủ</a></li>
                  <li><a href="category.php?category=men&sub=socks">Tất</a></li>
                  <li><a href="category.php?category=men&sub=sportswear">Đồ thể thao</a></li>
                  <li><a href="category.php?category=men&sub=suits">Vest/Com-lê</a></li>
                  <li><a href="category.php?category=men&sub=swimwear">Đồ bơi</a></li>
                  <li><a href="category.php?category=men&sub=tops">Áo</a></li>
                  <li><a href="category.php?category=men&sub=undergarments">Đồ lót</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/men1.jpg" alt="Thời trang nam"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjMzEzNDNhJy8+PC9zdmc+';">
                <p>Thời trang nam</p>
              </div>
            </div>
          </li>

          <li class="dropdown mega">
            <button class="dropdown-toggle">Đời sống</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=lifestyle&sub=new">Hàng mới</a></li>
                  <li><a href="category.php?category=lifestyle&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=lifestyle&sub=sale">Khuyến mãi</a></li>
                  <li><a href="category.php?category=lifestyle&sub=all">Tất cả đời sống</a></li>
                </ul>
              </div>

              <div class="mega-col">
                <h3 class="mega-title">Đời sống</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=lifestyle&sub=arts">Thủ công &amp; nghệ thuật</a></li>
                  <li><a href="category.php?category=lifestyle&sub=electronics">Phụ kiện điện tử</a></li>
                  <li><a href="category.php?category=lifestyle&sub=gadgets">Đồ chơi &amp; tiện ích</a></li>
                  <li><a href="category.php?category=lifestyle&sub=homeware">Đồ gia dụng</a></li>
                  <li><a href="category.php?category=lifestyle&sub=devices">Thiết bị đời sống</a></li>
                  <li><a href="category.php?category=lifestyle&sub=spiritual">Sản phẩm tâm linh</a></li>
                  <li><a href="category.php?category=lifestyle&sub=outdoor">Đồ ngoài trời</a></li>
                  <li><a href="category.php?category=lifestyle&sub=pet">Phụ kiện thú cưng</a></li>
                  <li><a href="category.php?category=lifestyle&sub=sports">Phụ kiện thể thao</a></li>
                  <li><a href="category.php?category=lifestyle&sub=stationery">Văn phòng phẩm</a></li>
                  <li><a href="category.php?category=lifestyle&sub=travel">Đồ du lịch</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/health1.jpg" alt="Sống khỏe"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjMzEzNDNhJy8+PC9zdmc+';">
                <p>Sống khỏe</p>
              </div>
            </div>
          </li>

          <li><a href="#" onclick="openModal('contactModal')">Liên hệ</a></li>
        </ul>
        <button class="search-btn" onclick="showSearchModal()" aria-label="Tìm kiếm"><i class="fas fa-search"></i></button>
      </nav>
    </div>
  </header>

  <!-- ================= MAIN ================= -->
  <main class="cart-wrap">
    <p style="margin: 8px 0 10px; color: var(--muted);">
      <a href="index.php">Trang chủ</a> / <span>Giỏ hàng</span>
    </p>

    <h1 class="cart-title">Giỏ hàng</h1>

    <div class="cart-header">
      <div id="cart-empty" class="cart-empty" style="display:none;">
        Giỏ hàng của bạn đang trống.<br/>
        <div class="cart-actions-top" style="justify-content:center; margin-top:10px;">
          <button class="btn-primary" onclick="openModal('authModal')">Đăng nhập</button>
          <a class="btn-outline" href="index.php">Tiếp tục mua sắm</a>
        </div>
      </div>

      <div id="cart-has-items">
        <div class="cart-actions-top">
          <a class="btn-outline" href="index.php"><i class="fa-solid fa-arrow-left-long"></i> Tiếp tục mua sắm</a>
          <button class="btn-outline" id="btn-clear"><i class="fa-regular fa-trash-can"></i> Xóa giỏ hàng</button>
        </div>
      </div>
    </div>

    <div id="cart-content" class="cart-grid" style="display:none;">
      <div class="cart-list" id="cart-list"></div>

      <aside class="cart-summary" id="cart-summary">
        <h3>Tóm tắt đơn hàng</h3>
        <div class="sum-row"><span>Số lượng</span><span id="sum-items">0</span></div>
        <div class="sum-row"><span>Tạm tính</span><span id="sum-subtotal">$0.00</span></div>
        <div class="sum-row"><span>Vận chuyển</span><span>Tính ở bước thanh toán</span></div>
        <div class="sum-row total"><span>Tổng</span><span id="sum-total">$0.00</span></div>
        <div class="sum-actions">
          <button class="btn-primary" id="btn-checkout">Thanh toán</button>
          <a class="btn-ghost" href="index.php">Tiếp tục mua sắm</a>
        </div>
        <div class="note-mini">* Thuế & phí vận chuyển (nếu có) hiển thị ở bước thanh toán.</div>
      </aside>
    </div>

    <!-- Guarantee block -->
    <section class="guarantee">
      <h3>Hài lòng 100% được đảm bảo</h3>
      <div class="guarantee-grid">
        <div class="g-card"><div class="ic">↩️</div><div class="ttl">Đổi/Trả</div><p>Đổi/Trả trong 14 ngày kể từ khi nhận.</p></div>
        <div class="g-card"><div class="ic">💳</div><div class="ttl">Hoàn tiền</div><p>Hoàn tiền nhanh nếu đơn bị huỷ theo chính sách.</p></div>
        <div class="g-card"><div class="ic">🚚</div><div class="ttl">Vận chuyển</div><p>Hoàn phí nếu không nhận được hàng.</p></div>
        <div class="g-card"><div class="ic">✅</div><div class="ttl">Chất lượng</div><p>Hàng chính hãng, kiểm duyệt chất lượng.</p></div>
        <div class="g-card"><div class="ic">💬</div><div class="ttl">CSKH</div><p>Hỗ trợ nhanh chóng, tận tâm.</p></div>
        <div class="g-card"><div class="ic">🧾</div><div class="ttl">Phí thông quan</div><p>Hỗ trợ hoàn phí thông quan theo điều kiện.</p></div>
      </div>
    </section>
  </main>

  <!-- ================= MODALS ================= -->
  <div id="contactModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('contactModal')">&times;</span>
      <h2>Liên hệ</h2>
      <form id="contact-form">
        <div class="form-group"><input placeholder="Họ tên" required></div>
        <div class="form-group"><input type="email" placeholder="Email" required></div>
        <div class="form-group"><textarea placeholder="Nội dung" required></textarea></div>
        <button type="submit" class="btn-primary">Gửi</button>
      </form>
    </div>
  </div>

  <div id="searchModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('searchModal')">&times;</span>
      <h2>Tìm kiếm</h2>
      <input id="search-input" placeholder="Tìm kiếm..." />
      <div id="search-results"></div>
    </div>
  </div>

  <div id="authModal" class="modal">
    <div class="modal-content" style="max-width:540px">
      <span class="close" onclick="closeModal('authModal')">&times;</span>
      <div style="display:flex;gap:8px;margin-bottom:16px;">
        <button id="tab-signin" class="btn-primary" style="padding:8px 14px;">Thành viên</button>
        <button id="tab-register" class="btn-primary" style="padding:8px 14px;opacity:.8;">Mới</button>
      </div>

      <div id="pane-signin">
        <h3 style="margin-bottom:10px;">Đăng nhập</h3>
        <div class="form-group"><input type="email" placeholder="Địa chỉ email"></div>
        <div class="form-group"><input type="password" placeholder="Mật khẩu"></div>
        <button class="btn-primary" style="width:100%;">Đăng nhập</button>
      </div>

      <div id="pane-register" style="display:none;">
        <h3 style="margin-bottom:10px;">Đăng ký</h3>
        <div class="form-group"><input type="email" placeholder="Địa chỉ email"></div>
        <div class="form-group"><input type="password" placeholder="Mật khẩu"></div>
        <button class="btn-primary" style="width:100%;">Đăng ký</button>
      </div>
    </div>
  </div>

  <!-- ================= FOOTER ================= -->
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
        <p>&copy; 2025 YesStyle. Bảo lưu mọi quyền.</p>
      </div>
    </div>
  </footer>

  <!-- ================= SCRIPTS ================= -->
  <script src="JS/QA.js"></script>
  <script>
    // Util: định dạng tiền
    const money = n => '$' + Number(n || 0).toFixed(2);

    // Render 1 dòng
    function rowHTML(i){
      const id = i.id;
      const name = (i.name||id);
      const brand = (i.brand||'');
      const price = Number(i.price||0);
      const qty = Number(i.quantity||1);
      const sub = price * qty;
      const img = i.image || `images/anh/${id}.jpg`;
      return `
        <div class="cart-row" data-id="${id}">
          <div class="cart-thumb"><img src="${img}" alt="${name}"></div>
          <div class="cart-info">
            <div class="name">${escapeHtml(name)}</div>
            <div class="brand">${escapeHtml(brand)}</div>
          </div>
          <div class="cart-price">${money(price)}</div>
          <div class="qty-input">
            <input type="number" min="1" value="${qty}" inputmode="numeric" />
          </div>
          <button class="remove-btn" title="Xóa"><i class="fa-regular fa-trash-can"></i></button>
        </div>`;
    }

    function computeTotals(list){
      let items = 0, subtotal = 0;
      list.forEach(i => { items += Number(i.quantity||0); subtotal += Number(i.price||0) * Number(i.quantity||0); });
      return { items, subtotal, total: subtotal };
    }

    function renderCart(){
      // 'cart' & helpers đến từ QA.js (đã load)
      // dự phòng: nếu cart chưa có, đọc từ localStorage
      if (typeof cart === 'undefined') {
        window.cart = JSON.parse(localStorage.getItem('yessstyle_cart')||'[]');
      }

      updateCartCount && updateCartCount();

      const emptyBox = document.getElementById('cart-empty');
      const grid = document.getElementById('cart-content');
      const listBox = document.getElementById('cart-list');
      const sumItems = document.getElementById('sum-items');
      const sumSubtotal = document.getElementById('sum-subtotal');
      const sumTotal = document.getElementById('sum-total');

      if (!cart.length){
        emptyBox.style.display = 'block';
        grid.style.display = 'none';
        return;
      }
      emptyBox.style.display = 'none';
      grid.style.display = '';

      listBox.innerHTML = cart.map(rowHTML).join('');

      // bind thay đổi số lượng + xóa
      listBox.querySelectorAll('.cart-row').forEach(row=>{
        const id = row.getAttribute('data-id');
        const input = row.querySelector('input[type="number"]');
        const btnDel = row.querySelector('.remove-btn');

        input.addEventListener('change', ()=>{
          let v = Math.max(1, parseInt(input.value||'1', 10));
          input.value = v;
          const idx = cart.findIndex(x=>String(x.id)===String(id));
          if (idx>=0){ cart[idx].quantity = v; saveCart(); }
          updateSummary();
          updateCartCount && updateCartCount();
        });

        btnDel.addEventListener('click', ()=>{
          const idx = cart.findIndex(x=>String(x.id)===String(id));
          if (idx>=0){ cart.splice(idx,1); saveCart(); }
          if (!cart.length){ renderCart(); return; }
          row.remove();
          updateSummary();
          updateCartCount && updateCartCount();
        });
      });

      updateSummary();

      function updateSummary(){
        const t = computeTotals(cart);
        sumItems.textContent = t.items;
        sumSubtotal.textContent = money(t.subtotal);
        sumTotal.textContent = money(t.total);
      }
    }

    // Nút: xóa toàn bộ / thanh toán
    document.getElementById('btn-clear').addEventListener('click', ()=>{
      if (!cart.length) return;
      if (confirm('Xóa toàn bộ sản phẩm trong giỏ?')){
        cart.splice(0, cart.length);
        saveCart(); renderCart(); updateCartCount && updateCartCount();
      }
    });
    document.getElementById('btn-checkout').addEventListener('click', ()=>{
      const t = JSON.parse(localStorage.getItem('yessstyle_cart')||'[]');
      if (!t.length){ alert('Giỏ hàng đang trống.'); return; }
      alert('Chỉ là bản demo thanh toán. Tích hợp cổng thanh toán sau nhé!');
    });

    // helpers nhỏ (fallback)
    function escapeHtml(s){ return String(s).replace(/[&<>"']/g, m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }

    // init
    document.addEventListener('DOMContentLoaded', ()=>{
      updateCartCount && updateCartCount();
      renderCart();

      // tabs đăng nhập/đăng ký
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
