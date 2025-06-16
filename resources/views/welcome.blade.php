<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UMKM Nusantara – Login</title>

  <!-- Bootstrap 5.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --brand-cream: #f0d9b5;
      --brand-brown-dark: #b48c5e;
      --cream-bg: #f6efe7;
      --nav-height: 72px;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--cream-bg);
    }

    /* ====== Hero ====== */
    .hero {
      background: url('https://images.unsplash.com/photo-1616125162686-770bf85622b9?q=80&w=1920&auto=format&fit=crop') center/cover no-repeat;
      min-height: 100vh;
      position: relative;
      color: #fff;
    }
    .hero::after {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, .55);
    }
    .hero-content {
      position: relative;
      z-index: 2;
    }

    /* ====== Section Centering ====== */
    .section-center {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    #login { background: var(--cream-bg); }
    #features { background: #fff; }
    #contact { background: var(--cream-bg); }

    /* ====== Components ====== */
    .login-card {
      border-radius: 1rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .1);
    }
    .brand-color {
      color: var(--brand-brown-dark);
    }
    .btn-brand {
      background: var(--brand-cream);
      border: none;
      color: #5a3d31;
    }
    .btn-brand:hover {
      background: #e3c6a3;
      color: #000;
    }
    .text-brand {
      color: var(--brand-brown-dark);
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top" style="height: var(--nav-height);">
  <div class="container">
    <a class="navbar-brand fw-bold brand-color" href="#">UMKM Nusantara</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#login">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero d-flex align-items-center" id="home">
  <div class="container text-center hero-content">
    <h1 class="display-5 fw-semibold">Solusi Keuangan Digital untuk UMKM</h1>
    <p class="lead mb-4">Kelola arus kas, catat transaksi, dan pantau laporan keuangan bisnis Anda dengan mudah dan efisien.</p>
    <a href="#login" class="btn btn-lg btn-brand">Mulai Sekarang</a>
  </div>
</section>


<!-- Login Section -->
<section id="login" class="section-center">
  <div class="container d-flex justify-content-center">
    <div class="card login-card p-4 col-md-6 col-lg-4 align-self-center">
      <h3 class="text-center mb-4 brand-color">Login UMKM</h3>
      <form action="/login" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="nama@usaha.com" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="••••••" required>
        </div>
        <button type="submit" class="btn btn-brand w-100">Masuk</button>
        <div class="text-center mt-3">
          <small>Belum punya akun? <a href="/register" class="brand-color">Daftar di sini</a></small>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Features Section -->
<section id="features" class="section-center">
  <div class="container py-5 text-center">
    <div class="row mb-4">
      <div class="col">
        <h2 class="fw-bold">Fitur Unggulan</h2>
      </div>
    </div>
    <div class="row g-4">
      <!-- Analitik -->
      <div class="col-md-4">
        <div class="p-4 border rounded-3 h-100">
          <i class="fa-solid fa-chart-line fa-3x mb-3 text-brand"></i>
          <h5 class="fw-semibold">Analitik</h5>
          <p class="text-muted">Pantau laporan keuangan bisnis Anda.</p>
        </div>
      </div>
      <!-- Manajemen -->
      <div class="col-md-4">
        <div class="p-4 border rounded-3 h-100">
          <i class="fa-solid fa-cogs fa-3x mb-3 text-brand"></i>
          <h5 class="fw-semibold">Manajemen</h5>
          <p class="text-muted">Buat dan catat rekening keluar masuk di bisnis Anda.</p>
        </div>
      </div>
      <!-- Pegawai -->
      <div class="col-md-4">
        <div class="p-4 border rounded-3 h-100">
          <i class="fa-solid fa-users fa-3x mb-3 text-brand"></i>
          <h5 class="fw-semibold">Pegawai</h5>
          <p class="text-muted">Kelola pegawai Anda.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="section-center">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">Hubungi Kami</h2>
    <p class="text-muted mb-4">Punya pertanyaan atau butuh bantuan? Tim kami siap membantu Anda untuk mengembangkan bisnis kuliner.</p>
    <a href="umkm@gmail.com" class="btn btn-brand btn-lg">Email Kami</a>
  </div>
</section>

<!-- Footer -->
<footer class="bg-white py-4 border-top">
  <div class="container text-center">
    <small class="text-muted">&copy; 2025 UMKM Nusantara. All rights reserved.</small>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
