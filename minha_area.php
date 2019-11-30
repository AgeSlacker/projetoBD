<?php
session_start();
require_once "connect.php";
require_once "force_login.php";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Minha Área</title>
</head>

<body style="overflow-x: hidden;">
    <?php require "top_navbar.php" ?>
    <div class="row" style="height: 6%;background-color:black;">
        <div class="col-md-4">
            <ul class="nav nav-tabs" style="width: 100%;color: rgb(255,255,255);">
                <li class="nav-item" style="width: 100%;color: rgb(255,255,255);background-color: #000000;"><a class="nav-link active d-xl-flex justify-content-xl-center align-items-xl-center" href="Meu_perfil.php" style="color: rgb(255,255,255);background-color: rgb(0,0,0);">Perfil</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="nav nav-tabs" style="width: 100%;">
                <li class="nav-item" style="width: 100%;"><a class="nav-link active d-xl-flex justify-content-xl-center align-items-xl-center" href="Meus_jogos.php" style="background-color: rgb(0,0,0);color: rgb(255,255,255);">Jogos</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="nav nav-tabs" style="width: 100%;">
                <li class="nav-item" style="width: 100%;"><a class="nav-link active d-xl-flex justify-content-xl-center align-items-xl-center" href="Minhas_equipas.php" style="background-color: rgb(0,0,0);color: rgb(255,255,255);">Equipas</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h1 class="text-center" style="margin-top:20px;">Minha Área -- <?php
                                                                            $cc = $_SESSION["cc"];
                                                                            $pesquisa = "SELECT nome
                                                                            FROM pessoa
                                                                            WHERE cc = '$cc'";
                                                                            if ($result = $conn->query($pesquisa)) {

                                                                                $row = $result->fetch_assoc();
                                                                                $nomelog = $row["nome"];

                                                                                echo $nomelog;
                                                                            }
                                                                            ?> </h1>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row" style="margin-bottom: 5%;margin-top: 5%;width: 1134px;height: 210px;">
                <div class="col-4 col-sm-4 col-md-4 offset-md-2 offset-lg-3 offset-xl-4" style="background-color: #dedede;">
                    <h2 class="text-center">Estatísticas</h2>
                    <p style="margin-top: 26px;">Torneios Participados: <?php $cc = $_SESSION["cc"];
                                                                        $pesquisa = "SELECT *
														FROM posjogadorequipa as p, jogo
														WHERE (p.equipa_nome = jogo.equipa_nome OR p.equipa_nome = jogo.equipa_nome1)
														AND p.pessoa_cc = '$cc'
														GROUP BY slot_torneio_id";
                                                                        if ($result = $conn->query($pesquisa)) {
                                                                            $count_torn = $result->num_rows;
                                                                            echo $count_torn;
                                                                        } else {
                                                                            echo "error in sql syntax";
                                                                        }

                                                                        ?></p>
                    <p>Jogos Participados: <?php $cc = $_SESSION["cc"];
                                            $pesquisa = "SELECT *
														FROM posjogadorequipa as p, jogo
														WHERE (p.equipa_nome = jogo.equipa_nome OR p.equipa_nome = jogo.equipa_nome1)
														AND p.pessoa_cc = '$cc'";
                                            if ($result = $conn->query($pesquisa)) {
                                                $count_jog = $result->num_rows;
                                                echo $count_jog;
                                            } else {
                                                echo "error in sql syntax";
                                            }
                                            ?></p>
                    <p>Golos Marcados: <?php $cc = $_SESSION["cc"];

                                        $pesquisa = "SELECT *
														FROM golos
														WHERE pessoa_cc = '$cc' AND valido = 1";

                                        if ($result = $conn->query($pesquisa)) {
                                            $count_golos = $result->num_rows;
                                            echo $count_golos;
                                        } else {
                                            echo "error in sql syntax";
                                        }
                                        ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php require "footer.php"; ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>