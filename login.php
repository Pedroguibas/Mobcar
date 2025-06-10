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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= $baseurl ?>css/style.css">
        <link rel="icon" type="image/x-icon" href="<?= $baseurl ?>assets/favicon.ico">
    </head>
    <body>
        <main id="loginMain" class="row m-0">
            <aside id="loginBannerContainer" class="col-lg-6">
                <img src="assets/brand-white.png" alt="Logo Mobcar Branca" class="col-md-3 col-4">
            </aside>
            <section id="loginFormContainer" class="d-flex flex-column align-items-center col-12 col-lg-6">
                <header id="loginFormHeader" class="d-flex align-items-center gap-2 col-10 mt-5">
                    <div id="loginFormHeaderBrand" class="col-2">
                        <img src="assets/logo.png" alt="Logo Mobcar" class="w-100">
                    </div>
                    <h1>MOBCAR</h1>
                </header>
                <div id="login_signup_selector" class="left d-flex col-10 mb-5">
                    <button tabindex="-1" id="loginSelectorBtn" class="col-6">Entrar</button>
                    <button tabindex="-1" id="signupSelectorBtn" class="col-6">Registrar</button>
                </div>
                <div id="loginForm" class="col-10">
                    <form action="<?= $baseurl ?>forms/auth.php" method="POST" class="d-flex flex-column align-items-center col-12">
                        <div class="form-group col-10 mb-5">
                            <input type="email" class="form-control mb-4" name="email" id="loginEmailInput" placeholder="E-mail">
                        </div>
                        <div class="form-group col-10 mb-5">
                            <input type="password" class="form-control" name="password" id="loginPasswordInput" placeholder="senha">
                            <span class="invalid-feedback mt-1">E-mail ou senha inválidos.</span>
                        </div>
                        <div id="submitBtnContainer" class="d-flex justify-content-between col-10">
                            <a href="#">Esqueceu sua senha?</a>
                            <button class="btn btn-primary col-3 col-md-4 col-lg-3 p-2">Log-in</button>
                        </div>
                    </form>
                </div>
                <div id="signupForm" class="d-none col-10 pb-5">
                    <form action="<?= $baseurl ?>forms/userSignup.php" method="POST" class="d-flex flex-column align-items-center col-12">
                        <div class="form-group col-10 mb-5">
                            <input type="email" class="form-control" name="email" id="signupEmailInput" placeholder="Email" required>
                        </div>
                        <div class="form-group col-10 mb-5">
                            <input type="text" class="form-control" name="name" id="signupNameInput" placeholder="Nome Completo" required>
                        </div>
                        <div class="form-group col-10 mb-5">
                            <input type="text" class="form-control" name="cnh" id="signupCnhInput" maxlength="11" placeholder="Carteira Nacional de habilitação" required>
                        </div>
                        <div class="form-group col-10 mb-5">
                            <input type="text" class="form-control" name="cep" id="signupCepInput" maxlength="9" placeholder="CEP" required>
                            <span class="invalid-feedback">CEP inválido.</span>
                            <div class="d-flex justify-content-center">
                                <div id="searchingCpfSpinner" class="spinner-border mt-3" style="display: none;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-10 mb-5">
                            <input type="text" tabindex="-1" class="form-control disabled mb-5" name="state" id="signupStateInput" placeholder="Estado" readonly required>
                            <input type="text" tabindex="-1" class="form-control disabled mb-5" name="city" id="signupCityInput" placeholder="Cidade" readonly required>
                            <input type="text" tabindex="-1" class="form-control disabled mb-5" name="street" id="signupStreetInput" placeholder="Rua" readonly required>
                            <input type="text" class="form-control" name="houseNumber" id="signupNumberInput" placeholder="Número" required>
                        </div>
                        <div class="form-group col-10 mb-4">
                            <input type="password" class="form-control" name="password" id="signupPasswordInput" placeholder="Senha" required>
                        </div>
                        <div id="passwordRequirementsContainer">
                            <span id="passwordRequirementsTitle" class="mb-3">Sua senha deve conter ao menos:</span>
                            <ul id="passwordRequirementsList" class="mb-4">
                                <li class="passwordRequirement">Uma letra maiúscula</li>
                                <li class="passwordRequirement">Uma letra minúscula</li>
                                <li class="passwordRequirement">Um número</li>
                                <li class="passwordRequirement">Um caractere especial (@$!%*#?&+-)</li>
                            </ul>
                        </div>
                        <div class="form-group col-10 mb-5">
                            <input type="password" class="form-control" id="signupPasswordConfirmationInput" placeholder="Senha" required>
                            <span class="invalid-feedback">As senhas não conferem.</span>
                        </div>
                        <div class="d-flex justify-content-end col-10">
                            <button class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
        <script src="javascript/login.js"></script>
    </body>
</html>