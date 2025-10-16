<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danh mục - YesStyle</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

  <!-- ================ HEADER ================ -->
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
          <!-- ========= MỸ PHẨM ========= -->
          <li class="dropdown mega">
            <button class="dropdown-toggle" data-cat="beauty">Mỹ phẩm</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu ở đây</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=beauty&sub=new">Hàng mới</a></li>
                  <li><a href="category.php?category=beauty&sub=instock">Sẵn hàng</a></li>
                  <li><a href="category.php?category=beauty&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=beauty&sub=flash">Giảm chớp nhoáng</a></li>
                  <li><a href="category.php?category=beauty&sub=valuesets">Bộ quà tặng &amp; ưu đãi</a></li>
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
                  <li><a href="category.php?category=beauty&sub=hairtreat">Ủ &amp; phục hồi tóc</a></li>
                  <li><a href="category.php?category=beauty&sub=shampoos">Dầu gội</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/rg2.jpg" alt="Xu hướng làm đẹp"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjZjNmNGY2Jy8+PC9zdmc+';">
                <p>Xu hướng làm đẹp</p>
              </div>
            </div>
          </li>

          <!-- ========= NỮ ========= -->
          <li class="dropdown mega">
            <button class="dropdown-toggle" data-cat="women">Nữ</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu ở đây</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=women&sub=new">Hàng mới</a></li>
                  <li><a href="category.php?category=women&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=women&sub=sale">Giảm giá</a></li>
                  <li><a href="category.php?category=women&sub=all">Tất cả cho Nữ</a></li>
                </ul>
              </div>

              <div class="mega-col">
                <h3 class="mega-title">Trang phục</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=women&sub=activewear">Đồ thể thao</a></li>
                  <li><a href="category.php?category=women&sub=coats">Áo khoác</a></li>
                  <li><a href="category.php?category=women&sub=cosplay">Cosplay / Hoá trang</a></li>
                  <li><a href="category.php?category=women&sub=dancewear">Đồ khiêu vũ</a></li>
                  <li><a href="category.php?category=women&sub=dresses">Đầm/Váy liền</a></li>
                  <li><a href="category.php?category=women&sub=jeans">Quần jeans</a></li>
                  <li><a href="category.php?category=women&sub=jumpsuits">Jumpsuit</a></li>
                  <li><a href="category.php?category=women&sub=lingerie">Đồ lót</a></li>
                  <li><a href="category.php?category=women&sub=maternity">Đồ bầu</a></li>
                  <li><a href="category.php?category=women&sub=pajamas">Đồ ngủ</a></li>
                  <li><a href="category.php?category=women&sub=pants">Quần dài</a></li>
                  <li><a href="category.php?category=women&sub=shorts">Quần short</a></li>
                  <li><a href="category.php?category=women&sub=skirts">Chân váy</a></li>
                  <li><a href="category.php?category=women&sub=socks">Vớ &amp; tất</a></li>
                  <li><a href="category.php?category=women&sub=swimwear">Đồ bơi</a></li>
                  <li><a href="category.php?category=women&sub=tops">Áo</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/women1.jpg" alt="Thời trang nữ"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjZjNmNGY2Jy8+PC9zdmc+';">
                <p>Thời trang nữ</p>
              </div>
            </div>
          </li>

          <!-- ========= NAM ========= -->
          <li class="dropdown mega">
            <button class="dropdown-toggle" data-cat="men">Nam</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu ở đây</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=men&sub=new">Hàng mới</a></li>
                  <li><a href="category.php?category=men&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=men&sub=sale">Giảm giá</a></li>
                  <li><a href="category.php?category=men&sub=all">Tất cả cho Nam</a></li>
                </ul>
              </div>

              <div class="mega-col">
                <h3 class="mega-title">Trang phục</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=men&sub=cosplay">Cosplay &amp; hoá trang</a></li>
                  <li><a href="category.php?category=men&sub=outerwear">Áo khoác</a></li>
                  <li><a href="category.php?category=men&sub=pants">Quần dài</a></li>
                  <li><a href="category.php?category=men&sub=shorts">Quần short</a></li>
                  <li><a href="category.php?category=men&sub=sleepwear">Đồ ngủ</a></li>
                  <li><a href="category.php?category=men&sub=socks">Vớ</a></li>
                  <li><a href="category.php?category=men&sub=sportswear">Đồ thể thao</a></li>
                  <li><a href="category.php?category=men&sub=suits">Suit</a></li>
                  <li><a href="category.php?category=men&sub=swimwear">Đồ bơi</a></li>
                  <li><a href="category.php?category=men&sub=tops">Áo</a></li>
                  <li><a href="category.php?category=men&sub=undergarments">Đồ lót</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/men1.jpg" alt="Thời trang nam"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjZjNmNGY2Jy8+PC9zdmc+';">
                <p>Thời trang nam</p>
              </div>
            </div>
          </li>

          <!-- ========= PHONG CÁCH SỐNG ========= -->
          <li class="dropdown mega">
            <button class="dropdown-toggle" data-cat="lifestyle">Phong cách sống</button>
            <div class="mega-panel">
              <div class="mega-col">
                <h3 class="mega-title">Bắt đầu ở đây</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=lifestyle&sub=new">Hàng mới</a></li>
                  <li><a href="category.php?category=lifestyle&sub=bestsellers">Bán chạy</a></li>
                  <li><a href="category.php?category=lifestyle&sub=sale">Giảm giá</a></li>
                  <li><a href="category.php?category=lifestyle&sub=all">Tất cả Phong cách sống</a></li>
                </ul>
              </div>

              <div class="mega-col">
                <h3 class="mega-title">Danh mục</h3>
                <ul class="mega-links">
                  <li><a href="category.php?category=lifestyle&sub=arts">Thủ công &amp; mỹ nghệ</a></li>
                  <li><a href="category.php?category=lifestyle&sub=electronics">Phụ kiện điện tử</a></li>
                  <li><a href="category.php?category=lifestyle&sub=gadgets">Gadgets &amp; đồ chơi</a></li>
                  <li><a href="category.php?category=lifestyle&sub=homeware">Đồ gia dụng</a></li>
                  <li><a href="category.php?category=lifestyle&sub=devices">Thiết bị phong cách sống</a></li>
                  <li><a href="category.php?category=lifestyle&sub=spiritual">Sản phẩm tâm linh</a></li>
                  <li><a href="category.php?category=lifestyle&sub=outdoor">Đồ dã ngoại</a></li>
                  <li><a href="category.php?category=lifestyle&sub=pet">Phụ kiện thú cưng</a></li>
                  <li><a href="category.php?category=lifestyle&sub=sports">Phụ kiện thể thao</a></li>
                  <li><a href="category.php?category=lifestyle&sub=stationery">Văn phòng phẩm</a></li>
                  <li><a href="category.php?category=lifestyle&sub=travel">Đồ du lịch</a></li>
                </ul>
              </div>

              <div class="mega-col mega-media">
                <img src="images/anh/health1.jpg" alt="Sống khoẻ"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0nMTAwJyBoZWlnaHQ9JzEwMCcgeG1sbnM9J2h0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnJz48cmVjdCB3aWR0aD0nMTAwJScgaGVpZ2h0PScxMDAlJyBmaWxsPScjZjNmNGY2Jy8+PC9zdmc+';">
                <p>Sống khoẻ</p>
              </div>
            </div>
          </li>

          <li><a href="#" onclick="openModal('contactModal')">Liên hệ</a></li>
        </ul>

        <button class="search-btn" onclick="showSearchModal()" aria-label="Tìm kiếm">
          <i class="fas fa-search"></i>
        </button>
      </nav>
    </div>
  </header>

  <!-- ================ CATEGORY CONTENT ================ -->
  <main class="container" style="padding:40px 0;">
    <h2 id="category-title">Danh mục</h2>
    <div class="product-grid" id="category-products">
      <p>Đang tải sản phẩm...</p>
    </div>
  </main>

  <!-- ================ MODALS TÁI SỬ DỤNG ================ -->
  <div id="contactModal" class="modal" aria-hidden="true">
    <div class="modal-content">
      <span class="close" onclick="closeModal('contactModal')" aria-label="Đóng">&times;</span>
      <h2>Liên hệ</h2>
      <form id="contact-form">
        <div class="form-group"><input placeholder="Tên của bạn" required></div>
        <div class="form-group"><input type="email" placeholder="Email" required></div>
        <div class="form-group"><textarea placeholder="Nội dung" required></textarea></div>
        <button type="submit" class="btn-primary">Gửi</button>
      </form>
    </div>
  </div>

  <div id="searchModal" class="modal" aria-hidden="true">
    <div class="modal-content">
      <span class="close" onclick="closeModal('searchModal')" aria-label="Đóng">&times;</span>
      <h2>Tìm kiếm</h2>
      <input id="search-input" placeholder="Nhập từ khoá rồi Enter..." />
      <div id="search-results"></div>
    </div>
  </div>

  <div id="authModal" class="modal" aria-hidden="true">
    <div class="modal-content" style="max-width:540px">
      <span class="close" onclick="closeModal('authModal')" aria-label="Đóng">&times;</span>
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
    // Khởi tạo nhỏ cho tab đăng nhập/đăng ký trong modal
    document.addEventListener('DOMContentLoaded', () => {
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
