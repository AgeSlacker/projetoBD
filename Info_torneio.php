<?php
session_start();
require_once "connect.php";

if (isset($_GET["id"])) {
    // ir buscar os jogos planeados
    $id = $_GET["id"];
    $sql = "SELECT slot_hora_inicio, equipa_nome , equipa_nome1 
            FROM jogo 
            WHERE slot_torneio_id = $id";
    $jogosPlaneados = $conn->query($sql);

    // ir buscar o numero de vagas por cada equipa
    $sql = "SELECT e.nome, p.nome AS capnome, p.sobrenome, count(pos.pessoa_cc) AS num_jogadores
            FROM pessoa AS p, equipa AS e 
            LEFT JOIN posjogadorequipa AS pos ON e.nome = pos.equipa_nome
            WHERE e.torneio_id = $id
            AND e.pessoa_cc = p.cc
            GROUP BY e.nome";
    $equipasTorneio = $conn->query($sql);

    // ir buscar os jogos passados e criar a tabela de resultados

    /*$sql = "SELECT
	            nome,
                COUNT(jogo.id) as jogos
            FROM
                equipa LEFT JOIN jogo
                ON jogo.equipa_nome = equipa.nome 
                OR jogo.equipa_nome1 = equipa.nome
                WHERE jogo.slot_torneio_id = 0
            GROUP BY nome
            ORDER BY nome";*/
    $sql = "SELECT nome,
        COALESCE(SUM(jogos),0) as jogos,
        COALESCE(SUM(vitorias),0) as vitorias,
        COALESCE(SUM(empates),0) as empates,
        COALESCE((SUM(vitorias) * 3 + SUM(empates) * 1),0) as pontos,
        COALESCE(SUM(golosMarcados),0) as golosMarcados,
        COALESCE(SUM(golosSofridos),0) as golosSofridos
    FROM (SELECT
        nome,
        COUNT(jogo.golosa1) as jogos,
        SUM(jogo.golosa1 > jogo.golosb1) as vitorias,
        SUM(jogo.golosa1 = jogo.golosb2) as empates,
        SUM(jogo.golosa1) as golosMarcados,
        SUM(jogo.golosb1) as golosSofridos
    FROM
        equipa LEFT JOIN jogo
        ON jogo.equipa_nome = equipa.nome 
        WHERE jogo.slot_torneio_id = $id
    GROUP BY nome
    UNION
    SELECT
        nome,
        COUNT(jogo.golosa1) as jogos,
        SUM(jogo.golosa1 < jogo.golosb1) as vitorias,
        SUM(jogo.golosa1 = jogo.golosb2) as empates,
        SUM(jogo.golosb1) as golosMarcados,
        SUM(jogo.golosa1) as golosSofridos
    FROM
        equipa LEFT JOIN jogo
        ON jogo.equipa_nome1 = equipa.nome 
        WHERE jogo.slot_torneio_id = $id
          GROUP BY nome
    ) as temp
    GROUP BY nome  
    ORDER BY `pontos`  DESC";

    $resultados = $conn->query($sql);
    if (!$resultados) {
        echo "<pre> ERRO <br> " . mysqli_error($conn) . "</pre>";
    }
} else {
    header("Location: listar_torneios.php");
    exit();
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
    <link rel="icon" href="assets/images/icon.ico" type="image/gif">
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
                                <td><a href='Info_equipa.php?nome=$nome&tid=$id' class='btn btn-secondary btn-sm' role='button'>Info&nbsp;<i class='fa fa-long-arrow-right'></i></a></td>
                                <td><a href='Inscricao_equipa.php?nome=$nome&tid=$id' class='btn btn-secondary btn-sm' role='button'>Inscrever</a></td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="text-center">Tabela de resultados</p>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Equipa</th>
                                <th>Jogos</th>
                                <th>Vitorias</th>
                                <th>Empates</th>
                                <th>Derrotas</th>
                                <th>Pontos</th>
                                <th>GM</th>
                                <th>GS</th>
                                <th>DG</th>
                                <th>Posição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // preencher os resultados das equipas
                            $pos = 0;
                            while ($equipa = $resultados->fetch_assoc()) {
                                $pos++;
                                $nome = $equipa["nome"];
                                $jogos = $equipa["jogos"];
                                $vitorias = $equipa["vitorias"];
                                $empates = $equipa["empates"];
                                $derrotas = $jogos - $vitorias - $empates;
                                $pontos = $equipa["pontos"];
                                $gm = $equipa["golosMarcados"];
                                $gs = $equipa["golosSofridos"];
                                $dg = $gm - $gs;
                                echo "<tr>
                                    <td>$nome</td>
                                    <td>$jogos</td>
                                    <td>$vitorias</td>
                                    <td>$empates</td>
                                    <td>$derrotas</td>
                                    <td>$pontos</td>
                                    <td>$gm</td>
                                    <td>$gs</td>
                                    <td>$dg</td>
                                    <td>$pos</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center"><button class="btn btn-dark" type="button" style="margin: 10px;">Inscrever na Reserva</button>
        <a class="btn btn-dark" role="button" style="margin: 10px;" href="Criar_nova_equipa.php?id=<?php echo $id ?>">Criar nova equipa</a>
        <?php
        if (isset($_SESSION["cc"])) {
            $tid = $_GET["id"];
            $sql = "SELECT torneio_id
                    FROM torneio_gestor LEFT JOIN torneio on torneio_id = id
                    WHERE pessoa_cc = " . $_SESSION['cc'] . "
                    AND torneio_id = $tid";
            if (!$torn = $conn->query($sql)) {
                echo mysqli_error($conn);
            }
            $torn = $torn->fetch_assoc();
            $sql = "SELECT iniciado FROM torneio WHERE torneio.id = $tid";
            if (!$iniciado = $conn->query($sql)) {
                echo mysqli_error($conn);
            }
            $iniciado = $iniciado->fetch_assoc();

            if ($torn = $tid && $iniciado["iniciado"] != 1) {
                echo "<a class='btn btn-dark' role='button' style='margin: 10px;' href='GerenciarTorneios.php?torneioid=" . $tid . "'>Gerenciar Torneio</a>";
            }
        }
        ?>
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