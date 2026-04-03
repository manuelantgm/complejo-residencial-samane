<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
        <link rel="apple-touch-icon" sizes="180x180" href="<?= media();?>/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?= media();?>/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?= media();?>/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?= media();?>/img/favicon/site.webmanifest">
        <link rel="mask-icon" href="<?= media();?>/img/favicon/safari-pinned-tab.svg" color="#55aa4f">
        <link rel="stylesheet" href="<?= media(); ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/plugins/toastr/toastr.min.css">
        <link rel="stylesheet" href="<?= media(); ?>/dist/css/login.css">
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="<?= media(); ?>/plugins/fontawesome-6.5.1/css/all.min.css">
        <title><?= $data['page_tag'];?></title>  
    </head>
    <body>
        <div class="l-form">
            <div class="shape1"></div>
            <div class="shape2"></div>

            <div class="form">
                <img src="<?= media(); ?>/img/logo.svg" alt="" class="form__img">

                <form action="" class="form__content" name="formLogin" id="formLogin">
                    <h1 class="form__title">Bienvenido(a)</h1>

                    <div class="form__div form__div-one">
                        <div class="form__icon">
                            <i class='bx bx-user-circle'></i>
                        </div>

                        <div class="form__div-input">
                            <label for="txtEmail" class="form__label">Nombre de usuario</label>
                            <input type="text" class="form__input" id="txtEmail" name="txtEmail" autocomplet="off"/>
                        </div>
                    </div>

                    <div class="form__div">
                        <div class="form__icon">
                            <i class='bx bx-lock' ></i>
                        </div>

                        <div class="form__div-input">
                            <label for="loginPass" class="form__label">Contraseña</label>
                            <i class="fa-solid fa-eye-slash login__eye" id="login-eye"></i>
                            <input type="password" class="form__input" id="loginPass" name="txtPassword" autocomplet="off" />
                        </div>
                        <div class="loader" id="loader"><i class="fa fa-sync fa-spin"></i></div>
                    </div>
                    <a href="#" class="form__forgot">¿Has olvidado tu contraseña?</a>

                    <button type="submit" class="form__button"><i class="fa-solid fa-right-to-bracket"></i> Entrar</button>

                    <div class="form__social">
                        <span class="form__social-text">Inicia sesión con</span>
                        <a href="#" class="form__social-icon" id="btnFacebook"><i class='bx bxl-facebook' ></i></a>
                        <a href="#" class="form__social-icon" id="btnGoogle"><i class='bx bxl-google' ></i></a>
                        <a href="#" class="form__social-icon" id="btnInstagram"><i class='bx bxl-instagram'></i></a>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-toast" id="list-toast"></div>
        <script>
          const base_url = "<?= base_url(); ?>";
        </script>
        <!-- jQuery -->
        <script src="<?= media();?>/plugins/jquery/jquery.min.js"></script>
        <!-- SWEETALERT2 -->
        <script src="<?= media();?>/plugins/sweetalert2/sweetalert2.min.js"></script>
        <!-- ===== TOASTR ===== -->
        <script src="<?= media();?>/plugins/toastr/toastr.min.js"></script>
        <!-- ===== MAIN JS ===== -->
        <script src="<?= media();?>/fnts/fnts_login.js"></script>
    </body>
</html>