<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/externalcss/index.css') ?>">
</head>

<body>
    <?php $session = session(); ?>
    <nav class="navbar navbar-light fixed-top"
        style="background: rgba(0, 128, 128, 1); color: white; padding: 0.50rem 1rem; font-size: 1.25rem; font-weight: bold;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-white fw-bolder" href="#">
                <img src="<?= base_url('assets/images/blog.png') ?>" alt="" width="30" height="30"
                    class="d-inline-block align-text-top">
                Blogify
            </a>

            <?php if ($session->get('isLoggedIn')): ?>
                <div class="d-flex align-items-center text-white gap-3">
                    <span>Hello, <?= esc($session->get('name')) ?></span>
                    <a href="<?= base_url('logout') ?>" class="btn" style="background: rgba(240, 131, 6); color: white; padding: 0.40rem 1rem; font-size: 1 rem; font-weight: bold; border: none; border-radius: 0.3rem;">Logout</a>
                </div>
         
            <?php endif; ?>
        </div>
    </nav>

    <?= view('partials/alerts') ?>
