<?php
    if(!isset($_SESSION))
        session_start();
    
    $_SESSION['baseUrl'] =  'http://' . $_SERVER['SERVER_NAME'] . '/Mobcar/';
    $baseurl = $_SESSION['baseUrl'];

    if (!isset($active))
        $active = '';

    if (!(isset($_SESSION['logged']) && $_SESSION['logged'] == 1))
        header('Location: ' . $baseurl . 'login.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title><?= isset($title) ? $title : 'Mobcar' ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= $baseurl ?>css/style.css">
        <link rel="icon" type="image/x-icon" href="<?= $baseurl ?>assets/favicon.ico">
    </head>
    <body>
        <header class="container-lg">
            <nav class="navbar navbar-expand-lg">
                <a href="<?= $baseurl ?>" class="nav-brand col-md-1 col-2">
                    <img src="<?= $baseurl ?>/assets/brand.png" alt="Logo Mobcar" id="headerBrand" class="w-100">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav container-fluid d-flex justify-content-end">
                        <li class="nav-item">
                            <a href="<?= $baseurl ?>" class="nav-link <?= $active == 'home' ? 'active' : '' ?> d-flex justify-content-end">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link <?= $active == 'signup' ? 'active' : '' ?> d-flex justify-content-end">Sign-up</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link <?= $active == 'login' ? 'active' : '' ?> d-flex justify-content-end">Log-in</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>