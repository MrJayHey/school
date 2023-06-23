<header class="p-3 text-bg-dark">
    <div class="container" bis_skin_checked="1">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start" bis_skin_checked="1">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php" class="nav-link px-10 text-white outline-dark">Главная</a></li>
          <li><a href="journal.php" class="nav-link px-10 text-white outline-dark">Дневник</a></li>
          <li><a href="#" class="nav-link px-10 text-white outline-dark">Награды</a></li>
          <li><a href="about.php" class="nav-link px-10 text-white outline-dark">О школе</a></li>
        </ul>
        <div class="text-end" bis_skin_checked="1">
          <?php if($_COOKIE['teacher']=='' && $_COOKIE['student']==''):
          ?> 
          <button type="button" class="btn btn-outline-light me-2" onclick="document.location='auth.php'">Войти</button>
          <?php else: ?>
          <button type="button" class="btn btn-outline-light me-2" onclick="document.location='disauth.php'">Выйти</button>
          <?php endif ?>
        </div>
      </div>
    </div>
  </header>