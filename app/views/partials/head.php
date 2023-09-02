<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $title ?> - LightEdit</title>
  <link rel="stylesheet" href="/assets/css/bs.css">
  <link rel="stylesheet" href="/assets/icons/font/bootstrap-icons.css?v=<?= time() ?>">
  <link rel="stylesheet" href="/assets/css/dash.css?v=<?= time() ?>">
  <link rel="stylesheet" href="/assets/css/datatables.css?v=<?= time() ?>">
  <script>
    function confirm_action(message, event) {
      if (!confirm(message)) {
        event.preventDefault();
      }
    }
  </script>
</head>
<body class="dashboard-container">
<header>
  <?php if (flash->has()): ?>
    <div class="toast-container m-3 position-fixed end-0">
      <?php foreach (flash->display() as $f): ?>
        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true"
             data-delay="5000">
          <div class="toast-header">
            <i class="bi bi-bell me-2"></i>
            <strong class="me-auto"><?= $f['title'] ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Kapat"></button>
          </div>
          <div class="toast-body">
            <?= $f['message'] ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <aside class="sidebar" id="ld_sidebar">
    <div class="sidebar-top">
      <span class="h2 md" href="/dashboard"><b>Light</b><i class="h4">Edit</i> <i class="bi bi-wind"></i></span>
      <span class="h2 ms" href="/dashboard"><b>L</b><i class="h4">D</i> <i class="bi bi-wind"></i></span>
      <button class="d-md-none btn hover rounded" id="ld_sidebar_close">
        <i class="bi bi-arrow-left"></i>
      </button>
    </div>
    <div class="sidebar-body">
      <a href="/dashboard"<?= $page === "dashboard" ? ' class="active"' : '' ?>>
        <i class="bi bi-house"></i>
        Dashboard
      </a>
      <a href="/dashboard/account"<?= $page === "account" ? ' class="active"' : '' ?>>
        <i class="bi bi-bank"></i>
        Accounts
      </a>
      <a href="/dashboard/settings"<?= $page === "settings" ? ' class="active"' : '' ?>>
        <i class="bi bi-gear"></i>
        Settings
      </a>
      <a href="/signout">
        <i class="bi bi-box-arrow-left"></i>
        Sign Out
      </a>
    </div>
  </aside>
</header>
<main>
  <div class="d-flex justify-content-between align-items-center ld_dashboard_navigation">
    <ul class="d-flex align-items-center p-0">
      <li class="d-md-none">
        <button class="btn rounded hover" id="ld_sidebar_open"><i class="bi bi-list"></i></button>
      </li>
      <li class="d-none d-md-block">
        <h1><?= $title ?></h1>
        <small>Welcome to Light<i>Edit</i>, <?= active()->name ?></small>
      </li>
    </ul>
    <div>
      <ul class="d-flex align-items-center gap-3">
        <li>
          <span class="d-none d-md-block" id="ft_date">00/00/00</span>
          <span class="d-none d-md-block" id="ft_clock">00.00</span>
        </li>
        <li class="hover" id="ld_fullscreen">
          <button class="btn rounded"><i class="bi bi-fullscreen"></i></button>
        </li>
        <li class="hover" id="ld_toggle_theme">
          <button class="btn rounded"><i class="bi bi-moon"></i></button>
        </li>
        <li class="dropdown profile-dropdown">
                    <span class="btn rounded dropdown-toggle" type="button" data-bs-toggle="dropdown"
                          aria-expanded="false">
                        <i class="bi bi-person"></i>
                        <span><?= active()->name ?></span>
                    </span>
          <ul class="dropdown-menu border-0 shadow-lg rounded">
            <li class="dropdown-item text-center disabled d-flex align-items-center m-4">
              <span class="me-2 rounded-circle">
                <i style="font-size: 54px" class="bi bi-person"></i>
              </span>
              <div>
                <h4><?= active()->name ?></h4>
                <div class="text-muted">Rank here...</div>
              </div>
            </li>
            <li><a class="dropdown-item" href="/dashboard/account/update">Account Settings</a></li>
            <li><a class="dropdown-item" href="/signout">Sign Out</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
