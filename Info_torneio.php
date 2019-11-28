<?php
session_start();
require_once "connect.php";

if (isset($_GET["id"])) {
    // ir buscar os jogos planeados
    $id = $_GET["id"];
    $sql = "SELECT slot_hora_inicio, equipa_nome , equipa_nome1 FROM jogo WHERE slot_torneio_id = $id";
    $jogosPlaneados = $conn->query($sql);

    $sql = "SELECT e.nome, p.nome as capnome, p.sobrenome, count(pos.pessoa_cc) as num_jogadores
            FROM pessoa as p, equipa as e 
            LEFT JOIN posjogadorequipa as pos ON e.nome = pos.equipa_nome
            WHERE e.torneio_id = $id
            AND e.pessoa_cc = p.cc
            GROUP BY e.nome";


    echo $sql;
    $equipasTorneio = $conn->query($sql);
};

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>

<body>
    <?php require "top_navbar.php" ?>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <p class="text-center">Jogos planeados</p>
                <div class="table-responsive text-center">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Dia e Hora</th>
                                <th>Equipa A</th>
                                <th>Equipa B</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $jogosPlaneados->fetch_assoc()) {
                                $equipaA = $row["equipa_nome"];
                                $equipaB = $row["equipa_nome1"];
                                $hora = $row["slot_hora_inicio"];
                                echo "<tr>
                                <td>$hora</td>
                                <td>$equipaA</td>
                                <td>$equipaB</td>
                                </tr>";
                            }
                            ?>
                            <tr>
                                <td>Cell 1</td>
                                <td>Cell 2</td>
                                <td>Cell 3</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col">
                <p class="text-center">Jogos passados</p>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Equipa</th>
                                <th>J</th>
                                <th>V</th>
                                <th>SV</th>
                                <th>GS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cell 1</td>
                                <td>Cell 2</td>
                                <td>Cell 3</td>
                                <td>Cell 4</td>
                                <td>Cell 5</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-center">Equipas</p>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Equipa</th>
                                <th>Vagas</th>
                                <th>Captain</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $equipasTorneio->fetch_assoc()) {
                                $nome = $row["nome"];
                                echo "<tr>
                                <td>" . $row["nome"] . "</td>
                                <td>" . (14 - $row["num_jogadores"]) . "</td>
                                <td>" . $row["capnome"] . " " . $row["sobrenome"] . "</td>
                                <td><a href='' class='btn btn-secondary btn-sm' role='button'>Info&nbsp;<i class='fa fa-long-arrow-right'></i></a></td>
                                <td><a href='Inscricao_equipa.php?nome=$nome' class='btn btn-secondary btn-sm' role='button'>Inscrever</a></td>
                                </tr>";
                            }
                            ?>

                            <tr>
                                <td><img>Cell 1</td>
                                <td>Cell 2</td>
                                <td>Cell 3</td>
                                <td><button class="btn btn-secondary btn-sm" type="button">Info&nbsp;<i class="fa fa-long-arrow-right"></i></button></td>
                                <td><button class="btn btn-secondary btn-sm" type="button">Inscrever</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center"><button class="btn btn-primary" type="button" style="margin: 10px;">Inscrever na Reserva</button>
        <a class="btn btn-primary" role="button" style="margin: 10px;" href="Criar_nova_equipa.php?id=<?php echo $id ?>">Criar nova equipa</a>
    </div>
    <div class="footer-dark" style="background-color: rgb(0,0,0);">
        <?php require "footer.php" ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <script>


    </script>
</body>

</html>