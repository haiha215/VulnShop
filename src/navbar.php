<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand text-danger fw-bold" href="index.php">💀 VulnShop Lab</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">1. SQL Injection</a></li>
        <li class="nav-item"><a class="nav-link" href="search.php">2. Reflected XSS</a></li>
        <li class="nav-item"><a class="nav-link" href="product.php">3. Stored XSS</a></li>
        <li class="nav-item"><a class="nav-link" href="order.php">4. IDOR</a></li>
        <li class="nav-item"><a class="nav-link" href="profile.php">5. File Upload</a></li>
        <li class="nav-item"><a class="nav-link" href="help.php?page=intro.php">6. LFI</a></li>
        <li class="nav-item"><a class="nav-link" href="promo.php">7. Object Injection</a></li>
        
        <?php if(isset($_SESSION['user_id'])): ?>
            <li class="nav-item"><a class="nav-link text-warning" href="#">User: <?php echo $_SESSION['username'] ?? 'User'; ?></a></li>
            <li class="nav-item"><a class="nav-link btn btn-sm btn-outline-light text-white ms-2" href="logout.php">Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>