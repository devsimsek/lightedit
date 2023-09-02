<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>LightDash - Sign In</title>
  <link rel="stylesheet" href="/assets/css/bs.css">
  <link rel="stylesheet" href="/assets/icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/assets/css/app.css">
  <style>
    html,
    body {
      height: 100%;
    }

    main {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .form-signin {
      max-width: 330px;
      padding: 1rem;
      margin: auto;
    }

    .form-signin .form-floating:focus-within {
      z-index: 2;
    }

    .form-signin .form-contents div:first-child input {
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 0;
    }

    .form-signin .form-contents div:last-child input {
      border-top: none;
      border-top-left-radius: 0;
      border-top-right-radius: 0;
    }

    .form-signin .form-contents div:not(:first-child):not(:last-child) input {
      border-top: none;
      border-radius: 0;
    }
  </style>
</head>
<body>
<canvas class="ld_background"></canvas>
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
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">Light<i>Dash</i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#ld_navigation" aria-controls="ld_navigation"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="ld_navigation">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Home</a>
          </li>
        </ul>
        <ul class="navbar-nav gap-2">
          <li class="nav-item dropdown">
            <a class="nav-link btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
               aria-expanded="false">
              Pages
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Privacy Policy</a></li>
              <li><a class="dropdown-item" href="#">Terms Of Service</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <button class="btn" id="ld_toggle_theme">
              <i class="bi bi-sun"></i>
            </button>
          </li>
          <li class="nav-item">
            <a href="/signin" class="btn nav-link"><i class="bi bi-box-arrow-in-right"></i> Sign
              In</a>
          </li>
          <li class="nav-item">
            <a href="/signup" class="btn nav-link"><i class="bi bi-person-plus"></i> Sign Up</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<main>
  <div class="card form-signin w-100 m-auto rounded">
    <form class="p-2" method="post" action="/callback">
      <span class="mb-4">Welcome to Light<i>Dash</i></span>
      <h1 class="h3 mb-3 fw-normal">Welcome back<span id="name"></span>, <br>Sign in to continue</h1>

      <div class="form-contents">
        <div class="form-floating">
          <input autofocus type="email" name="email" class="form-control" id="floatingInput"
                 placeholder="name@example.com" required>
          <label for="floatingInput">Email address</label>
        </div>
        <div class="form-floating">
          <input minlength="8" maxlength="16" type="password" name="password" class="form-control" id="floatingPassword"
                 placeholder="Password" required>
          <label for="floatingPassword">Password</label>
        </div>
      </div>
      <div class="form-check text-start my-3">
        <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
        <label class="form-check-label" for="flexCheckDefault">
          Remember me
        </label>
      </div>
      <input type="text" class="d-none" hidden="" name="signin" value="">
      <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
      <div class="d-flex align-items-center pt-2">
        <div class="flex-grow-1">
          <hr class="border-primary">
        </div>
        <span class="text-muted mx-2">Or sign in using</span>
        <div class="flex-grow-1">
          <hr class="border-primary">
        </div>
      </div>
      <a class="btn btn-outline-danger w-100 py-2 my-2"><i class="bi bi-google"></i> Google</a>
      <div class="d-flex align-items-center pt-2">
        <div class="flex-grow-1">
          <hr class="border-primary">
        </div>
        <span class="text-muted mx-2">Don't have an account?</span>
        <div class="flex-grow-1">
          <hr class="border-primary">
        </div>
      </div>
      <a href="/signup" class="btn btn-outline-success w-100 py-2 my-2">Sign Up Now</a>
    </form>
  </div>
</main>
<script src="/assets/js/bs.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>
