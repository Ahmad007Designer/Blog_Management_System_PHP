<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/externalcss/index.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap-icons/bootstrap-icons.css') ?>">
</head>
<link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
<title>Blogify</title>
<body class="d-flex flex-column min-vh-100">
  
<?php $session = session(); ?>
 <nav class="navbar navbar-light fixed-top"
     style="background: rgba(0, 128, 128, 1); color: white; padding: 0.50rem 1rem; font-size: 1.25rem; font-weight: bold;">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand text-white fw-bolder" href="<?=base_url('posts/list')?>">
      <img src="<?= base_url('assets/images/blog.png') ?>" alt="" width="30" height="30"
           class="d-inline-block align-text-top">
      Blogify
    </a>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="position-relative">
        <button id="userBtn" class="btn text-white fw-bold" style="background: rgba(240, 131, 6);">
          <?= esc(session()->get('name')) ?> <i class="bi bi-chevron-down"></i>
        </button>

        <div id="userPanel" class="card shadow position-absolute end-0 mt-2" style="width: 250px; display: none; z-index: 1000;">
          <div class="card-body p-3">
            <h6 class="mb-1"><?= esc(session()->get('name')) ?></h6>
            <h6 class="text-muted mb-2" style="font-size: 0.75rem;"><?= esc(session()->get('email')) ?></h6>

            <a href="<?= base_url('posts/my-posts') ?>" class="btn btn-sm w-100 mb-2" style="background: teal; color: white;">
              <i class="bi bi-journal-text me-1"></i> My Posts
            </a>
            <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-danger w-100">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</nav>
  <main class="flex-grow-1 mt-5 pt-4 container">
    <?= view('partials/alerts') ?>
