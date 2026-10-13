<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Desa Sukamaju</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600;12..96,800&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --ground:#f3f6ee; --ink:#14261b; --muted:#34483a;
  --green:#2f6b3f; --forest:#1f4a2e; --mint:#e3ecd9; --gold:#f0b93a;
}
*{box-sizing:border-box}
html{scroll-behavior:smooth}
body{margin:0;background:var(--ground);color:var(--ink);font-family:'Plus Jakarta Sans',system-ui,sans-serif;line-height:1.6}
img{display:block;max-width:100%}
a{color:inherit;text-decoration:none}
h1,h2,h3{font-family:'Bricolage Grotesque',sans-serif;font-weight:800;margin:0}
.wrap{max-width:1200px;margin:0 auto;padding:0 24px}
.eyebrow{margin:0 0 12px;font-size:14px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--green)}
.section{padding:104px 0}
.section h2{font-size:clamp(30px,4vw,44px);line-height:1.1;letter-spacing:-.01em;margin-bottom:48px;max-width:680px}
.btn{display:inline-flex;align-items:center;min-height:48px;padding:0 28px;border-radius:999px;font-weight:600}
.btn-gold{background:var(--gold);color:var(--ink)}
.btn-line{border:2px solid #fff;color:#fff}

/* NAV */
.nav{position:fixed;top:0;left:0;right:0;z-index:50;transition:background .3s,box-shadow .3s;color:#fff}
.nav.solid{background:rgba(20,38,27,.95);box-shadow:0 2px 16px rgba(0,0,0,.2)}
.nav .wrap{display:flex;align-items:center;justify-content:space-between;min-height:76px}
.logo{display:flex;align-items:center;gap:12px;font-family:'Bricolage Grotesque',sans-serif;font-weight:800;font-size:22px}
.menu{display:flex;align-items:center;gap:28px;font-size:15px;font-weight:500}
.menu a:hover{color:var(--gold)}
.menu .btn{min-height:44px;padding:0 20px}
.menu .btn:hover{color:var(--ink);background:#ffd36b}
.burger{display:none;background:none;border:0;color:#fff;padding:10px;cursor:pointer}

/* HERO */
.hero{position:relative;min-height:100vh;min-height:100svh;display:flex;align-items:flex-end;background:var(--forest);color:#fff;overflow:hidden}
.hero>img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.hero::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,30,18,.72),rgba(10,30,18,.45) 45%,rgba(10,30,18,.85))}
.hero .wrap{position:relative;z-index:2;padding-top:140px;padding-bottom:96px}
.hero .eyebrow{color:var(--gold)}
.hero h1{max-width:820px;font-size:clamp(40px,7vw,76px);line-height:1.04;letter-spacing:-.02em}
.hero p.lead{margin:24px 0 0;max-width:600px;font-size:18px;color:#e8efe3}
.hero .cta{margin-top:36px;display:flex;flex-wrap:wrap;gap:14px}

/* PROFIL */
.profil{display:flex;flex-wrap:wrap;gap:56px;align-items:center}
.profil>*{flex:1 1 420px;min-width:0}
.profil img{width:100%;height:480px;object-fit:cover;border-radius:24px;background:#cfdcc6}
.profil p{font-size:17px;color:var(--muted);margin:0 0 16px}
.vm{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px;margin-top:28px}
.vm div{padding:20px;background:var(--mint);border-radius:16px}
.vm b{font-family:'Bricolage Grotesque',sans-serif;font-size:20px;color:var(--forest)}
.vm span{display:block;margin-top:6px;font-size:15px;color:var(--muted)}

/* POTENSI */
.dark{background:var(--forest);color:#fff}
.dark .eyebrow{color:var(--gold)}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px}
.card{background:#fff;color:var(--ink);border-radius:20px;overflow:hidden;transition:transform .25s}
.card:hover{transform:translateY(-6px)}
.card img{width:100%;height:220px;object-fit:cover;background:#cfdcc6}
.card div{padding:24px}
.card h3{font-size:22px;margin-bottom:8px}
.card p{margin:0;font-size:15px;color:var(--muted)}

/* WISATA */
.tour{position:relative;display:block;height:420px;border-radius:24px;overflow:hidden;background:var(--forest);color:#fff}
.tour img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;transition:transform .5s}
.tour:hover img{transform:scale(1.06)}
.tour::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 40%,rgba(10,30,18,.88))}
.tour div{position:absolute;left:0;bottom:0;z-index:2;padding:28px}
.tour h3{font-size:26px;margin-bottom:6px}
.tour p{margin:0;font-size:15px;color:#e8efe3}

/* LAYANAN */
.mint{background:var(--mint)}
.grid.sm{grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px}
.service{padding:28px;background:#fff;border-radius:20px}
.service svg{stroke:var(--green)}
.service h3{font-size:20px;margin:16px 0 8px}
.service p{margin:0;font-size:15px;color:var(--muted)}

/* GALERI */
.gallery{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px}
.gallery img{width:100%;height:280px;object-fit:cover;border-radius:16px;background:#cfdcc6;cursor:zoom-in;transition:transform .25s}
.gallery img:hover{transform:scale(1.02)}
.lightbox{position:fixed;inset:0;z-index:100;background:rgba(10,20,14,.92);display:none;align-items:center;justify-content:center;padding:24px;cursor:zoom-out}
.lightbox.open{display:flex}
.lightbox img{max-height:90vh;max-width:100%;border-radius:12px}

/* KONTAK */
.contact{background:#14261b;color:#fff}
.contact .top{padding:88px 24px;display:flex;flex-wrap:wrap;gap:48px}
.contact .top>*{flex:1 1 380px;min-width:0}
.contact .eyebrow{color:var(--gold)}
.contact h2{margin-bottom:16px}
.contact .info{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:24px}
.contact .info b{display:block;margin-bottom:6px;font-size:13px;letter-spacing:.1em;text-transform:uppercase;color:var(--gold)}
.contact .info span,.contact .desc{color:#cfdcc6}
.foot{border-top:1px solid #2c4636;padding:24px;display:flex;flex-wrap:wrap;justify-content:space-between;gap:8px;font-size:14px;color:#a9bba6}

/* REVEAL */
.reveal{opacity:0;transform:translateY(24px);transition:opacity .7s,transform .7s}
.reveal.in{opacity:1;transform:none}

@media (max-width:820px){
  .burger{display:block}
  .menu{position:absolute;top:100%;left:0;right:0;flex-direction:column;align-items:stretch;gap:0;padding:8px 24px 24px;background:rgba(20,38,27,.98);display:none}
  .menu.open{display:flex}
  .menu a{padding:14px 0}
  .menu .btn{justify-content:center;margin-top:8px}
  .section{padding:72px 0}
  .profil img{height:320px}
}
@media (prefers-reduced-motion:reduce){
  html{scroll-behavior:auto}
  .reveal{opacity:1;transform:none;transition:none}
}
</style>
</head>
<body>

<nav class="nav" id="nav">
  <div class="wrap">
    <a class="logo" href="#">
      <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#f0b93a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 20h18"/><path d="M5 20V10l7-6 7 6v10"/><path d="M10 20v-6h4v6"/></svg>
      Desa Sukamaju
    </a>
    <button class="burger" id="burger" aria-label="Buka menu" aria-expanded="false">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
    <div class="menu" id="menu">
      <a href="#profil">Profil</a>
      <a href="#potensi">Potensi</a>
      <a href="#wisata">Wisata</a>
      <a href="#layanan">Layanan</a>
      <a href="#galeri">Galeri</a>
      <a href="#kontak" class="btn btn-gold">Hubungi Kami</a>
    </div>
  </div>
</nav>

<header class="hero">
  <img src="https://unsplash.com/photos/WClKJ2cW99Y/download?force=true&w=1800" alt="Hamparan sawah hijau di desa">
  <div class="wrap">
    <p class="eyebrow">Website Resmi Pemerintah Desa</p>
    <h1>Selamat datang di Desa Sukamaju</h1>
    <p class="lead">Hamparan sawah, udara sejuk pegunungan, dan warga yang ramah. Kenali desa kami, nikmati wisatanya, dan urus layanan administrasi dengan lebih mudah.</p>
    <div class="cta">
      <a href="#profil" class="btn btn-gold">Jelajahi Desa</a>
      <a href="#layanan" class="btn btn-line">Layanan Warga</a>
    </div>
  </div>
</header>

<section class="section" id="profil">
  <div class="wrap profil">
    <img class="reveal" src="https://unsplash.com/photos/I-8e7wx2hao/download?force=true&w=1200" alt="Petani menanam padi di sawah">
    <div class="reveal">
      <p class="eyebrow">Profil Desa</p>
      <h2 style="margin-bottom:20px">Desa yang tumbuh dari gotong royong</h2>
      <p>Desa Sukamaju berada di kawasan lereng yang subur, dikelilingi persawahan dan perkebunan. Kehidupan warga bertumpu pada pertanian, kerajinan, dan semangat kebersamaan yang diwariskan lintas generasi.</p>
      <p>Melalui website ini, pemerintah desa membuka informasi seluas-luasnya: dari profil, potensi, hingga layanan untuk warga.</p>
      <div class="vm">
        <div><b>Visi</b><span>Desa mandiri, sejahtera, dan lestari.</span></div>
        <div><b>Misi</b><span>Pelayanan terbuka, ekonomi warga kuat.</span></div>
      </div>
    </div>
  </div>
</section>

<section class="section dark" id="potensi">
  <div class="wrap">
    <p class="eyebrow">Potensi Desa</p>
    <h2>Kekayaan yang kami jaga dan kembangkan</h2>
    <div class="grid">
      <article class="card reveal">
        <img src="https://unsplash.com/photos/tyVcPQfncrg/download?force=true&w=900" alt="Hasil panen beras">
        <div><h3>Pertanian padi</h3><p>Lahan sawah produktif dengan pola tanam yang dikelola kelompok tani desa.</p></div>
      </article>
      <article class="card reveal">
        <img src="https://unsplash.com/photos/nxctPDCIzzg/download?force=true&w=900" alt="Kebun teh saat matahari terbit">
        <div><h3>Perkebunan</h3><p>Kebun teh dan komoditas dataran tinggi yang menopang ekonomi keluarga.</p></div>
      </article>
      <article class="card reveal">
        <img src="https://unsplash.com/photos/AWoa-3sqjwA/download?force=true&w=900" alt="Pedagang di pasar tradisional">
        <div><h3>UMKM &amp; pasar</h3><p>Pelaku usaha kecil, kuliner, dan kerajinan yang dipasarkan lewat pasar desa.</p></div>
      </article>
    </div>
  </div>
</section>

<section class="section" id="wisata">
  <div class="wrap">
    <p class="eyebrow">Wisata Desa</p>
    <h2>Tiga alasan untuk berkunjung</h2>
    <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(300px,1fr))">
      <a href="#kontak" class="tour reveal">
        <img src="https://unsplash.com/photos/PumTPwDUW6E/download?force=true&w=1000" alt="Air terjun di tengah hutan">
        <div><h3>Air terjun</h3><p>Aliran jernih di tengah hutan, cocok untuk trekking ringan.</p></div>
      </a>
      <a href="#kontak" class="tour reveal">
        <img src="https://unsplash.com/photos/V8_5LeatPdE/download?force=true&w=1000" alt="Sawah berundak dari udara">
        <div><h3>Sawah berundak</h3><p>Spot foto dan jalur jalan pagi dengan pemandangan terasering.</p></div>
      </a>
      <a href="#kontak" class="tour reveal">
        <img src="https://unsplash.com/photos/FXYOC87BRxM/download?force=true&w=1000" alt="Kebun teh dari udara">
        <div><h3>Kebun teh</h3><p>Hamparan hijau yang sejuk, dengan agenda petik teh bersama warga.</p></div>
      </a>
    </div>
  </div>
</section>

<section class="section mint" id="layanan">
  <div class="wrap">
    <p class="eyebrow">Layanan Warga</p>
    <h2>Urus kebutuhan administrasi tanpa ribet</h2>
    <div class="grid sm">
      <div class="service reveal">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h6"/></svg>
        <h3>Surat keterangan</h3><p>Pengantar, domisili, usaha, dan surat lain yang dibutuhkan warga.</p>
      </div>
      <div class="service reveal">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7"/><path d="M18 14.5a6.5 6.5 0 0 1 3.5 5.5"/></svg>
        <h3>Data kependudukan</h3><p>Pencatatan kelahiran, kepindahan, dan pembaruan data keluarga.</p>
      </div>
      <div class="service reveal">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-11.6 7.1L4 20l1-4.6A8 8 0 1 1 21 12z"/><path d="M9 11h6M9 14h4"/></svg>
        <h3>Pengaduan warga</h3><p>Sampaikan keluhan atau saran langsung kepada perangkat desa.</p>
      </div>
      <div class="service reveal">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></svg>
        <h3>Transparansi anggaran</h3><p>Laporan APBDes dan realisasi kegiatan yang bisa dibaca semua warga.</p>
      </div>
    </div>
  </div>
</section>

<section class="section" id="galeri">
  <div class="wrap">
    <p class="eyebrow">Galeri</p>
    <h2>Sekilas kehidupan di desa</h2>
    <div class="gallery">
      <img src="https://unsplash.com/photos/hpm2mVWHXx8/download?force=true&w=1000" alt="Sawah hijau dan pepohonan">
      <img src="https://unsplash.com/photos/KpcT-RxCaiU/download?force=true&w=1000" alt="Pedagang perempuan di pasar">
      <img src="https://unsplash.com/photos/V4lhI5KCLnM/download?force=true&w=1000" alt="Petani bertopi di sawah">
      <img src="https://unsplash.com/photos/86Q3JdQMnnk/download?force=true&w=1000" alt="Air terjun dan pepohonan">
      <img src="https://unsplash.com/photos/abPYsX0X36M/download?force=true&w=1000" alt="Air terjun bertingkat">
      <img src="https://unsplash.com/photos/nxctPDCIzzg/download?force=true&w=1000" alt="Kebun teh berkabut">
    </div>
  </div>
</section>

<footer class="contact" id="kontak">
  <div class="wrap top">
    <div>
      <p class="eyebrow">Kontak</p>
      <h2>Datang dan sapa kami</h2>
      <p class="desc" style="max-width:460px;font-size:17px;margin:0">Kantor desa terbuka untuk warga dan tamu. Hubungi kami untuk layanan, kunjungan wisata, atau kerja sama.</p>
    </div>
    <div class="info">
      <div><b>Alamat</b><span>[Alamat kantor desa]<br>[Kecamatan, Kabupaten]</span></div>
      <div><b>Jam layanan</b><span>Senin – Jumat<br>08.00 – 15.00 WIB</span></div>
      <div><b>Telepon / WhatsApp</b><span>[Nomor telepon]</span></div>
      <div><b>Email</b><span>[email desa]</span></div>
    </div>
  </div>
  <div class="wrap foot">
    <span>© <span id="year">2026</span> Pemerintah Desa Sukamaju</span>
    <span>Foto: Unsplash</span>
  </div>
</footer>

<div class="lightbox" id="lightbox" role="dialog" aria-label="Pratinjau foto"><img src="" alt=""></div>

<script>
(function () {
  var nav = document.getElementById('nav');
  var menu = document.getElementById('menu');
  var burger = document.getElementById('burger');

  // Navbar jadi solid saat di-scroll
  function onScroll() { nav.classList.toggle('solid', window.scrollY > 60); }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  // Menu mobile
  burger.addEventListener('click', function () {
    var open = menu.classList.toggle('open');
    burger.setAttribute('aria-expanded', open);
  });
  menu.addEventListener('click', function (e) {
    if (e.target.tagName === 'A') {
      menu.classList.remove('open');
      burger.setAttribute('aria-expanded', 'false');
    }
  });

  // Animasi muncul saat di-scroll
  var items = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
      });
    }, { threshold: 0.15 });
    items.forEach(function (el) { io.observe(el); });
  } else {
    items.forEach(function (el) { el.classList.add('in'); });
  }

  // Lightbox galeri
  var lb = document.getElementById('lightbox');
  var lbImg = lb.querySelector('img');
  document.querySelectorAll('.gallery img').forEach(function (img) {
    img.addEventListener('click', function () {
      lbImg.src = img.src.replace('w=1000', 'w=1800');
      lbImg.alt = img.alt;
      lb.classList.add('open');
    });
  });
  lb.addEventListener('click', function () { lb.classList.remove('open'); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') lb.classList.remove('open');
  });

  // Tahun otomatis
  document.getElementById('year').textContent = new Date().getFullYear();
})();
</script>
</body>
</html>