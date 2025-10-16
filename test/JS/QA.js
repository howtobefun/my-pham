/* =========================================================
   QA.js — Tương tác lõi cho demo YesStyle (VI)
   - Cart, Data demo, Grids, Slider, Detail page
   - Countdown THEO NGÀY (đến 23:59:59 hôm nay, tự reset mỗi ngày)
   - Nút "Xem chi tiết" trên mọi card
   - Customer Picks: LOAD MORE
   - Việt hoá toàn bộ text UI
   ========================================================= */

/* ===========================
   1) Cart (lưu localStorage)
   =========================== */
let cart = JSON.parse(localStorage.getItem('yessstyle_cart') || '[]');

function saveCart() {
  localStorage.setItem('yessstyle_cart', JSON.stringify(cart));
}
function updateCartCount() {
  const el = document.getElementById('cart-count');
  if (el) el.textContent = cart.reduce((s, i) => s + (i.quantity || 0), 0);
}
function addToCartById(id) {
  const p = productIndex[id] || { id, name: id, brand: 'Thương hiệu', price: 25, image: `images/anh/${id}.jpg` };
  addToCart(p);
}
function addToCart(product) {
  const i = cart.findIndex(x => x.id === product.id);
  if (i >= 0) cart[i].quantity = (cart[i].quantity || 1) + 1;
  else cart.push({ ...product, quantity: 1 });
  saveCart(); updateCartCount();
  alert('Đã thêm vào giỏ hàng!');
}
function showCartModal() {
  const box = document.getElementById('cart-items');
  if (box) {
    box.innerHTML = cart.length
      ? cart.map(i => `<div>${escapeHtml(i.name)} ×${i.quantity} — $${(i.price * i.quantity).toFixed(2)}</div>`).join('')
      : '<p>Giỏ hàng trống.</p>';
  }
  openModal('cartModal');
}

/* ===========================
   2) Dữ liệu DEMO
   - Mỗi item: id, name, brand, price, image, sub
   =========================== */
const data = {
  beauty: {
    all: [
      { id: 'rg2', name: 'Torriden Dive-In Mask', brand: 'Torriden', price: 3.50, image: 'images/anh/rg2.jpg', sub: 'skincare' },
      { id: 'rg3', name: "I'm from Fig Scrub Mask", brand: "I'm From", price: 32.00, image: 'images/anh/rg3.jpg', sub: 'skincare' },
      { id: 'rg1', name: 'La Mer Treatment Lotion', brand: 'La Mer', price: 175.00, image: 'images/anh/rg1.jpg', sub: 'skincare' },
      { id: 'sp5', name: 'Velvet Lip Tint', brand: 'Rom&nd', price: 12.00, image: 'images/anh/sp5.jpg', sub: 'makeup' }
    ],
    skincare: null, makeup: null,
    bodycare: [], suncare: [], haircare: []
  },
  women: {
    all: [
      { id: 'weekly7',  name: 'Denim Collar Blouse Set', brand: 'Chuu',       price: 45.00, image: 'images/anh/weekly7.jpg',  sub: 'tops' },
      { id: 'weekly8',  name: 'Puff Sleeve Knit Top',    brand: 'STYLENANDA', price: 38.00, image: 'images/anh/weekly8.jpg',  sub: 'tops' },
      { id: 'weekly11', name: 'Turtleneck & Vest Set',   brand: 'YesStyle',   price: 52.00, image: 'images/anh/weekly11.jpg', sub: 'dresses' }
    ],
    tops: null, dresses: null, jeans: [], skirts: []
  },
  men: {
    all: [
      { id: 'weekly1', name: 'Brown Knit Polo',         brand: 'Ben-Haru', price: 35.00, image: 'images/anh/weekly1.jpg', sub: 'shirts' },
      { id: 'men1',    name: 'Black Wide-Leg Trousers', brand: 'Yin-Yang',  price: 55.00, image: 'images/anh/men1.jpg',    sub: 'pants'  },
      { id: 'men2',    name: 'Minimalist Windbreaker',  brand: 'Gen-Z',     price: 68.00, image: 'images/anh/men2.jpg',    sub: 'shirts' }
    ],
    shirts: null, pants: null, jackets: [], shorts: []
  },
  lifestyle: {
    all: [
      { id: 'sp2', name: 'Canvas Eco Tote Bag', brand: 'Evergreen', price: 15.00, image: 'images/anh/sp2.jpg', sub: 'fashion' }
    ],
    decor: [], wellness: [], fitness: [], fashion: null
  }
};

/* Tự build các mảng con từ all theo key 'sub' */
Object.keys(data).forEach(cat => {
  const all = data[cat].all || [];
  Object.keys(data[cat]).forEach(sub => {
    if (sub !== 'all' && data[cat][sub] === null) {
      data[cat][sub] = all.filter(i => i.sub === sub);
    }
  });
});

/* Lập chỉ mục sản phẩm theo id để truy cập nhanh */
const productIndex = {};
Object.values(data).forEach(cat => (cat.all || []).forEach(p => { productIndex[p.id] = p; }));

/* ===========================
   3) Khởi động
   =========================== */
document.addEventListener('DOMContentLoaded', () => {
  setupCommonListeners();
  setupMobileMenu();
  updateCartCount();

  if (document.getElementById('featured-products')) { loadGrid('beauty'); setupHeroSlider(); }
  if (location.pathname.includes('category.php')) { renderCategoryPage(); }
  if (location.pathname.includes('detail.html')) { loadProductDetail(); }

  // Countdown THEO NGÀY — nếu index.php không tự nhúng, gọi ở đây (safe)
  startDailyCountdown();

  // Customer Picks — nút LOAD MORE
  initCustomerPicksLoadMore();
});

/* ===========================
   3.1) Fetch từ API (MySQL)
   =========================== */
async function fetchJson(url){
  const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
  if (!res.ok) throw new Error('HTTP '+res.status);
  return await res.json();
}
async function apiGetProducts(category, sub){
  const qs = new URLSearchParams();
  if (category) qs.set('category', category);
  if (sub) qs.set('sub', sub);
  const url = 'api/products.php' + (qs.toString() ? ('?'+qs.toString()) : '');
  try {
    const j = await fetchJson(url);
    return Array.isArray(j.items) ? j.items : [];
  } catch(e){
    return null; // báo hiệu fallback demo
  }
}
async function apiGetProductById(id){
  const url = 'api/products.php?id=' + encodeURIComponent(id);
  try {
    const j = await fetchJson(url);
    return j && j.item ? j.item : null;
  } catch(e){
    return null;
  }
}

/* ===========================
   4) Modal / Search / Form
   =========================== */
function openModal(id){ const m=document.getElementById(id); if(m) m.style.display='block'; }
function closeModal(id){ const m=document.getElementById(id); if(m) m.style.display='none'; }
window.addEventListener('click',e=>{ if(e.target?.classList?.contains('modal')) e.target.style.display='none'; });

function setupCommonListeners() {
  const f = document.getElementById('contact-form');
  if (f) f.addEventListener('submit', e => { e.preventDefault(); alert('Đã gửi liên hệ!'); closeModal('contactModal'); });

  const s = document.getElementById('search-input');
  if (s) s.addEventListener('keyup', e => { if (e.key === 'Enter') alert('Tìm kiếm: ' + e.target.value); });
}
function showSearchModal(){ openModal('searchModal'); }

/* ===========================
   5) Menu di động (map tiếng Việt → key nội bộ)
   =========================== */
const CAT_KEY_MAP = {
  'mỹ phẩm': 'beauty',
  'làm đẹp': 'beauty',
  'nữ': 'women',
  'nữ giới': 'women',
  'women': 'women',
  'nam': 'men',
  'men': 'men',
  'đời sống': 'lifestyle',
  'lifestyle': 'lifestyle'
};

function setupMobileMenu(){
  const toggle = document.getElementById('nav-toggle');
  const menu = document.getElementById('main-menu');
  if (toggle && menu) toggle.addEventListener('click', ()=> menu.classList.toggle('active'));

  // Ở mobile: nhấn nút tiêu đề mega => nhảy tới "all" của mục đó (map sang key nội bộ)
  document.querySelectorAll('.dropdown-toggle').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      if (window.innerWidth <= 768) {
        const raw = (btn.textContent||'').trim().toLowerCase();
        const cat = CAT_KEY_MAP[raw] || raw; // fallback
        if (cat) location.href = `category.php?category=${encodeURIComponent(cat)}&sub=all`;
      }
    });
  });
}

/* ===========================
   6) Card & Grid
   =========================== */
const CAT_LABEL_VI = {
  beauty: 'Mỹ phẩm',
  women: 'Nữ',
  men: 'Nam',
  lifestyle: 'Đời sống'
};
const SUB_LABEL_VI = {
  all: 'Tất cả',
  skincare: 'Chăm sóc da',
  makeup: 'Trang điểm',
  tops: 'Áo',
  dresses: 'Đầm',
  shirts: 'Áo',
  pants: 'Quần',
  fashion: 'Thời trang'
};

function renderCard(p){
  // onerror: dùng SVG trống (không chữ tiếng Anh)
  const fallbackPlain = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjNmNGY2Ii8+PC9zdmc+';
  return `
    <div class="product-card" onclick="window.location.href='detail.html?img=${encodeURIComponent(p.id)}'">
      <div class="product-img">
        <img src="${p.image}" alt="${escapeHtml(p.name)}"
             onerror="this.src='${fallbackPlain}';">
      </div>
      <h3 class="product-title">${escapeHtml(p.name)}</h3>
      <p class="product-brand">${escapeHtml(p.brand)}</p>
      <p class="price">$${Number(p.price).toFixed(2)}</p>
      <p class="stock" style="color:#6b7280;font-size:.9rem;">${typeof p.stock==='number' ? ('Còn hàng: '+p.stock) : ''}</p>
      <div style="display:flex; gap:8px; margin-top:8px;">
        <button class="btn-primary" onclick="event.stopPropagation(); addToCartById('${escapeAttr(p.id)}')" ${p.stock===0?'disabled':''}>${p.stock===0?'Hết hàng':'Thêm vào giỏ'}</button>
        <a class="btn-ghost" href="detail.html?img=${encodeURIComponent(p.id)}" onclick="event.stopPropagation();">Xem chi tiết</a>
      </div>
    </div>`;
}
async function loadGrid(category){
  const grid = document.getElementById('featured-products');
  if (!grid) return;
  // Thử lấy từ API, nếu lỗi thì dùng demo data
  let products = await apiGetProducts(category, 'all');
  if (!products || !products.length) products = data[category]?.all || [];
  grid.innerHTML = products.map(renderCard).join('');
  const title = document.getElementById('products-title');
  if (title) {
    const vi = CAT_LABEL_VI[category] || category;
    title.textContent = `Sản phẩm ${vi}`;
  }
}

/* ===========================
   7) Category — Phân trang
   =========================== */
async function renderCategoryPage(){
  const params = new URLSearchParams(location.search);
  const category = (params.get('category') || 'beauty').toLowerCase();
  const sub = (params.get('sub') || 'all').toLowerCase();

  const grid = document.getElementById('category-products');
  const title = document.getElementById('category-title');
  if (!grid) return;

  let list = await apiGetProducts(category, sub);
  if (!list || !list.length) list = (data[category]?.[sub]) || (data[category]?.all) || [];

  const PAGE_SIZE = 8, PAGES = 5, NEED = PAGE_SIZE * PAGES;
  if (list.length < NEED && list.length > 0) {
    const base = [...list];
    while (list.length < NEED) {
      list = list.concat(base.map((x, i) => ({ ...x, id: `${x.id}_${list.length+i}` })));
    }
    list = list.slice(0, NEED);
  }

  if (title) {
    const catVi = CAT_LABEL_VI[category] || category;
    const subVi = SUB_LABEL_VI[sub] || sub;
    title.textContent = sub !== 'all' ? `${catVi} / ${subVi}` : `${catVi}`;
  }

  let currentPage = 1;
  const totalPages = Math.max(1, Math.ceil(list.length / PAGE_SIZE));

  function renderPage(page){
    currentPage = Math.min(Math.max(1, page), totalPages);
    const start = (currentPage - 1) * PAGE_SIZE;
    const items = list.slice(start, start + PAGE_SIZE);
    grid.innerHTML = items.map(renderCard).join('') + renderPager();
    attachPagerEvents();
  }

  function renderPager(){
    return `
      <div style="display:flex;justify-content:center;gap:8px;margin-top:18px;">
        <button class="btn-primary" data-page="first" ${currentPage===1?'disabled':''} title="Trang đầu">&laquo;</button>
        <button class="btn-primary" data-page="prev"  ${currentPage===1?'disabled':''} title="Trang trước">&lsaquo;</button>
        <span style="align-self:center;padding:0 6px;">${currentPage}/${totalPages}</span>
        <button class="btn-primary" data-page="next"  ${currentPage===totalPages?'disabled':''} title="Trang sau">&rsaquo;</button>
        <button class="btn-primary" data-page="last"  ${currentPage===totalPages?'disabled':''} title="Trang cuối">&raquo;</button>
      </div>`;
  }

  function attachPagerEvents(){
    const box = grid.parentElement || document;
    box.querySelectorAll('[data-page]').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const act = btn.getAttribute('data-page');
        if (act==='first') renderPage(1);
        if (act==='prev')  renderPage(currentPage-1);
        if (act==='next')  renderPage(currentPage+1);
        if (act==='last')  renderPage(totalPages);
      });
    });
  }

  renderPage(1);
}

/* ===========================
   8) Detail — 2 tầng + Similar
   =========================== */
async function loadProductDetail(){
  const params = new URLSearchParams(location.search);
  const imgId = params.get('img');
  const box = document.getElementById('detail-content');
  if (!imgId || !box) return;

  let found = await apiGetProductById(imgId);
  if (!found) {
    found = productIndex[imgId] || {
      id: imgId, name: imgId, brand: 'Thương hiệu', price: 25.00, image: `images/anh/${imgId}.jpg`, sub: 'all'
    };
  }

  let currentCategory = null;
  for (const catKey of Object.keys(data)) {
    const arr = data[catKey]?.all || [];
    if (arr.some(p => p.id === found.id)) { currentCategory = catKey; break; }
  }

  const fallbackPlain = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjQwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZjNmNGY2Ii8+PC9zdmc+';

  function renderSummary(){
    box.className = 'detail-card detail-summary';
    box.innerHTML = `
      <div class="detail-img" id="detail-clickable">
        <img src="${found.image}" alt="${escapeHtml(found.name)}"
             onerror="this.src='${fallbackPlain}';">
      </div>
      <div class="detail-info">
        <h2 class="detail-title">${escapeHtml(found.name)}</h2>
        <p class="detail-brand">${escapeHtml(found.brand)}</p>
        <p class="detail-price">$${Number(found.price).toFixed(2)}</p>
        <p class="detail-stock">${typeof found.stock==='number' ? ('Tồn kho: '+found.stock) : ''}</p>
        <p class="detail-desc">Mô tả ngắn gọn về sản phẩm <b>${escapeHtml(found.id)}</b>. Chất liệu cao cấp, thiết kế hiện đại, phù hợp sử dụng hằng ngày.</p>
        <div class="detail-actions">
          <button class="btn-primary" onclick="addToCartById('${escapeAttr(found.id)}')" ${found.stock===0?'disabled':''}>${found.stock===0?'Hết hàng':'Thêm vào giỏ'}</button>
          <a class="detail-more" id="btn-more">Xem chi tiết <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    `;
    const clickable = document.getElementById('detail-clickable');
    const btnMore = document.getElementById('btn-more');
    if (clickable) clickable.addEventListener('click', renderExpanded);
    if (btnMore) btnMore.addEventListener('click', renderExpanded);
  }

  function infoBlock(title, body, open=false){
    return `
      <div class="info-block ${open ? 'is-open' : ''}">
        <div class="info-head">${escapeHtml(title)} <i class="fas fa-chevron-down"></i></div>
        <div class="info-body">${body}</div>
      </div>`;
  }

  function buildSimilarGrid(){
    let pool = [];
    if (currentCategory && data[currentCategory]?.all?.length){
      pool = data[currentCategory].all.filter(p => p.id !== found.id);
    }
    if (!pool.length){
      Object.values(data).forEach(cat => (cat.all||[]).forEach(p => { if (p.id !== found.id) pool.push(p); }));
    }
    const items = pool.slice(0, 12);
    return `
      <section class="similar-wrap">
        <h3 class="similar-title">Sản phẩm tương tự</h3>
        <div class="similar-grid">
          ${items.map(p=>`
            <div class="similar-card" onclick="location.href='detail.html?img=${encodeURIComponent(p.id)}'">
              <div class="similar-thumb"><img src="${p.image}" alt="${escapeHtml(p.name)}"></div>
              <div class="similar-meta">
                <div class="brand">${escapeHtml(p.brand||'')}</div>
                <div class="name">${escapeHtml(p.name)}</div>
                <div class="price">$${Number(p.price).toFixed(2)}</div>
              </div>
            </div>
          `).join('')}
        </div>
      </section>`;
  }

  function renderExpanded(){
    box.className = 'detail-expanded';
    box.innerHTML = `
      <div class="panel">
        <div class="detail-img">
          <img src="${found.image}" alt="${escapeHtml(found.name)}"
               onerror="this.src='${fallbackPlain}';">
        </div>
        <h2 class="title-xl">${escapeHtml(found.name)}</h2>
        <div class="badges">
          <span class="badge">Hàng mới</span>
          <span class="badge">Bán chạy</span>
          <span class="badge">Chính hãng</span>
        </div>
        <p class="detail-brand">${escapeHtml(found.brand)}</p>
        <p class="detail-price">$${Number(found.price).toFixed(2)}</p>
        <p class="detail-stock">${typeof found.stock==='number' ? ('Tồn kho: '+found.stock) : ''}</p>
        <div class="progress mt-8" title="Đã bán 78%"><span style="width:78%"></span></div>
        ${infoBlock('Ghi chú của biên tập', `<p>Sản phẩm có kết cấu nhẹ, thấm nhanh, phù hợp cho những ai yêu thích cảm giác thoáng da khi dưỡng.</p>`, true)}
        ${infoBlock('Tính năng nổi bật', `<ul><li>Đã được kiểm nghiệm da liễu – Dermatologically tested.</li><li>Chất liệu bền</li><li>Dễ bảo quản</li></ul>`)}
        ${infoBlock('Thành phần / Chất liệu', `<p>Cấp nước sâu, giữ ẩm suốt nhiều giờ.Dạng kem mềm mịn, không gây nhờn dính.</p>`)}
        ${infoBlock('Chi tiết & Bảo quản', `<p>HDSD: Theo hướng dẫn. Tránh xa tầm tay trẻ em.</p><div class="note mt-8">Bảo quản nơi khô ráo, thoáng mát, tránh ánh nắng trực tiếp.</div>`)}
      </div>
      <div class="panel">
        ${infoBlock('Vận chuyển & Đổi trả', `<ul><li>Giao hàng tiêu chuẩn: 3–7 ngày</li><li>Đổi/trả trong 14 ngày</li></ul>`, true)}
        ${infoBlock('Câu hỏi thường gặp', `<p>Sản phẩm này có phù hợp với da nhạy cảm không? Mỹ phẩm có chứa paraben, cồn hay hương liệu không?</p>`)}
      </div>
    ` + buildSimilarGrid();
    box.querySelectorAll('.info-block .info-head').forEach(head=>{
      head.addEventListener('click', ()=> head.parentElement.classList.toggle('is-open'));
    });
  }
  renderSummary();
}

/* ===========================
   9) Hero slider
   =========================== */
function setupHeroSlider(){
  const wrapper = document.querySelector('.slider-wrapper');
  const items = document.querySelectorAll('.slider-item');
  const prev = document.querySelector('.nav-prev');
  const next = document.querySelector('.nav-next');
  const dots = document.querySelector('.slider-dots');
  if (!wrapper || !items.length || !dots) return;

  let cur = 0, timer;
  const total = items.length;
  function buildDots(){
    dots.innerHTML = '';
    for (let i=0;i<total;i++){
      const d = document.createElement('span');
      d.className = 'dot' + (i===cur?' active':'');
      d.addEventListener('click', ()=>{ go(i); reset(); });
      dots.appendChild(d);
    }
  }
  function update(){
    wrapper.style.transform = `translateX(-${cur*100}%)`;
    dots.querySelectorAll('.dot').forEach((d,i)=> d.classList.toggle('active', i===cur));
  }
  function go(i){ if (i<0) cur = total-1; else if (i>=total) cur = 0; else cur = i; update(); }
  function nextSlide(){ go(cur+1); }
  function prevSlide(){ go(cur-1); }
  function start(){ timer = setInterval(nextSlide, 5000); }
  function reset(){ clearInterval(timer); start(); }

  buildDots(); update(); start();
  if (next) next.addEventListener('click', ()=>{ nextSlide(); reset(); });
  if (prev) prev.addEventListener('click', ()=>{ prevSlide(); reset(); });
}

/* ===========================
   10) Countdown THEO NGÀY
   =========================== */
function startDailyCountdown(){
  const bar = document.getElementById('promoRibbonDaily') || document.getElementById('promoRibbon');
  if (!bar) return;

  const slots = {
    d: bar.querySelector('[data-slot="days"]'),
    h: bar.querySelector('[data-slot="hours"]'),
    m: bar.querySelector('[data-slot="minutes"]'),
    s: bar.querySelector('[data-slot="seconds"]')
  };

  function getTodayEnd(){
    const now = new Date();
    return new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59, 999);
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
}

/* ===========================
   11) Customer Picks — LOAD MORE
   =========================== */
const picksData = [
  {id:'p1',  href:'detail.html?img=weekly8',  img:'images/anh/weekly8.jpg',  stars:4, title:'Áo len tay phồng',              text:'“Áo ôm vừa phải, chất knit mịn tay. Dễ phối đồ hằng ngày.”'},
  {id:'p2',  href:'detail.html?img=men2',     img:'images/anh/men2.jpg',     stars:5, title:'Áo gió tối giản',                text:'“Chống gió tốt, nhẹ, form gọn. Đi mưa nhẹ vẫn ổn.”'},
  {id:'p3',  href:'detail.html?img=men1',     img:'images/anh/men1.jpg',     stars:4, title:'Quần ống rộng',                  text:'“Ống rộng tôn dáng, vải dày dặn. Mặc công sở ok.”'},
  {id:'p4',  href:'detail.html?img=sp2',      img:'images/anh/sp2.jpg',      stars:4, title:'Túi tote vải',                   text:'“Túi to, đựng được nhiều, hình in xinh. Giá mềm.”'},
  {id:'p5',  href:'detail.html?img=weekly11', img:'images/anh/weekly11.jpg', stars:5, title:'Set cổ lọ & áo len gile',        text:'“Set tiện, mix & match nhanh. Lên ảnh rất đẹp.”'},
  {id:'p6',  href:'detail.html?img=weekly5',  img:'images/anh/weekly5.jpg',  stars:4, title:'Glowy Makeup Picks',            text:'“Combo make up glowy đúng trend, hợp đi chơi tối.”'},
  {id:'p7',  href:'detail.html?img=rg2',      img:'images/anh/rg2.jpg',      stars:5, title:'Mặt nạ giấy cấp ẩm',            text:'“Cấp ẩm đỉnh, da mát mịn ngay sau khi đắp.”'},
  {id:'p8',  href:'detail.html?img=rg3',      img:'images/anh/rg3.jpg',      stars:4, title:'Mặt nạ tẩy tế bào chết sung',   text:'“Hạt scrub mịn, không rát, da sáng nhẹ.”'},
  {id:'p9',  href:'detail.html?img=sp5',      img:'images/anh/sp5.jpg',      stars:4, title:'Son tint lì mượt',              text:'“Màu đẹp, không lem, apply mượt.”'},
  {id:'p10', href:'detail.html?img=weekly1',  img:'images/anh/weekly1.jpg',  stars:5, title:'Áo polo len nâu',               text:'“Chất len dày, cổ áo đứng form.”'},
  {id:'p11', href:'detail.html?img=weekly7',  img:'images/anh/weekly7.jpg',  stars:4, title:'Áo blouse cổ denim',            text:'“Chất denim dày, lên dáng xịn.”'},
  {id:'p12', href:'detail.html?img=weekly6',  img:'images/anh/weekly6.jpg',  stars:5, title:'Serum line gợi ý',              text:'“Da ẩm căng, hợp da nhạy cảm.”'},
];

function initCustomerPicksLoadMore(){
  const wrap = document.querySelector('#ys-picks .picks-grid');
  const btn  = document.getElementById('picks-load-more');
  if (!wrap || !btn) return;

  let cursor = 0;
  const STEP = 6;

  function starStr(n){
    const full = '★'.repeat(n);
    const empty = '☆'.repeat(5-n);
    return full + empty;
  }

  function cardHTML(item){
    return `
      <a class="pick-card" href="${item.href}">
        <div class="pick-thumb"><img src="${item.img}" alt=""></div>
        <div class="pick-body">
          <div class="stars">${starStr(item.stars)}</div>
          <div class="pick-title">${escapeHtml(item.title)}</div>
          <div class="pick-text">${escapeHtml(item.text)}</div>
        </div>
      </a>`;
  }

  function loadMore(){
    const slice = picksData.slice(cursor, cursor + STEP);
    cursor += slice.length;
    wrap.insertAdjacentHTML('beforeend', slice.map(cardHTML).join(''));
    if (cursor >= picksData.length) btn.style.display = 'none';
  }

  btn.addEventListener('click', loadMore);
}

/* ===========================
   12) Helpers
   =========================== */
function capitalize(s){ s=String(s||''); return s.charAt(0).toUpperCase()+s.slice(1); }
function escapeHtml(s){ return String(s).replace(/[&<>"']/g, m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }
function escapeAttr(s){ return String(s).replace(/'/g,'&#39;'); }

/* ===========================
   13) Auth & Checkout (API)
   =========================== */
async function apiRegister(email, password){
  const res = await fetch('api/auth.php?action=register', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ email, password }) });
  return res.ok;
}
async function apiLogin(email, password){
  const res = await fetch('api/auth.php?action=login', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ email, password }) });
  return res.ok;
}
async function apiLogout(){
  await fetch('api/auth.php?action=logout', { method:'POST' });
}
async function apiMe(){
  const r = await fetch('api/auth.php?action=me');
  if (!r.ok) return null;
  const j = await r.json();
  return j.user || null;
}
async function apiCheckout(items){
  const r = await fetch('api/checkout.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ items }) });
  if (!r.ok) throw new Error('Checkout failed');
  return await r.json();
}
