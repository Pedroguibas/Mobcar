<?php
session_start();
$_SESSION['baseUrl'] =  'http://' . $_SERVER['SERVER_NAME'] . '/Mobcar/';
    $baseurl = $_SESSION['baseUrl'];

if (isset($_SESSION['logged']) && $_SESSION['logged'] == 1)
    header('Location: ' . $baseurl . 'index.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Mobcar - Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="<?= $baseurl ?>css/style.css">
        <link rel="icon" type="image/x-icon" href="<?= $baseurl ?>assets/favicon.ico">
    </head>
    <body>
        <main id="loginMain" class="row m-0">
            <aside id="loginBannerContainer" class="col-md-6">

            </aside>
            <section id="loginFormContainer" class="d-flex flex-column align-items-center justify-content-center col-md-6 col-12">
                <div id="login_signup_selector" class="left d-flex col-10">
                    <button id="loginSelectorBtn" class="col-6">Log-in</button>
                    <button id="signupSelectorBtn" class="col-6">Sign-up</button>
                </div>
            </section>
        </main>
    </body>
</html>