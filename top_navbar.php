<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css" integrity="test">
<link rel="stylesheet" href="assets/css/Navigation-Clean.css">
<link rel="stylesheet" href="assets/css/Simple-Slider.css">
<link rel="stylesheet" href="assets/css/Footer-Dark.css">
<link rel="stylesheet" href="assets/fonts/ionicons.min.css">
<link rel="stylesheet" href="assets/css/styles.css">
<nav class="navbar navbar-light navbar-expand-md navigation-clean" style="background-color: rgb(0,0,0);">
    <div class="container-fluid"><a class="navbar-brand" href="index.php" style="color: rgb(255,255,255);">DBola</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item" role="presentation"><a class="nav-link" href="#" style="color: rgb(255,255,255);">Quero Jogar</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="listar_torneios.php" style="color: rgb(255,255,255);">Lista Torneios</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#" style="color: rgb(255,255,255);">Criar Torneio</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#" style="color: rgb(255,255,255);">Sobre/Ajuda</a></li>
                <?php

                if (isset($_SESSION["logged"]) && $_SESSION["logged"] == true) {
                    echo '<li class="nav-item" role="presentation"><a class="nav-link" href="logout.php" style="color: rgb(255,255,255);">Logout</a></li>';
                } else {
                    echo
                        '<li class="nav-item" role="presentation"><a class="nav-link" href="login.php" style="color: rgb(255,255,255);">Login</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="register.php" style="color: rgb(255,255,255);">Registrar</a></li>';
                }

                ?>
            </ul>
        </div>
    </div>
</nav>