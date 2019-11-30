<?php
session_start();
require "force_login.php";
require "connect.php";

if (!empty($_GET["nome"]) && !empty($_GET["tid"])) {
    $nome = $_GET["nome"];
    $tid = $_GET["tid"];

    // buscar o capitão e composicao
    $sql = "SELECT pessoa.nome as pnome, sobrenome, composicao 
            FROM pessoa, equipa 
            WHERE equipa.nome = '$nome'
            AND cc = pessoa_cc";

    $result = $conn->query($sql);
    if (!$result) {
        // TODO erro mysql
        echo mysqli_error($conn);
    }
    $result = $result->fetch_assoc();
    echo print_r($result, true);
    $capitao = $result["pnome"] . " " . $result["sobrenome"];
    $composicao = $result["composicao"];
    // Ir buscar os jogadores da equipa
    $sql = "SELECT titular, posicao as pos, suplenteguardaredes as sup, ordem, nome
            FROM posjogadorequipa LEFT JOIN pessoa ON pessoa.cc = pessoa_cc
            WHERE equipa_nome = '$nome'";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
    }
    $jogadores = $result;
} else {
    header("Location: listar_torneios.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>info_equipa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php require "top_navbar.php" ?>
    <h1><?php echo $nome; ?></h1>
    <p class="text-center"><?php echo "Capitão: $capitao Composição: $composicao"; ?></p>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Titular</th>
                    <th>Ordem</th>
                    <th>Posição</th>
                    <th>Nome</th>
                    <th>Guarda-Redes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($jogador = $jogadores->fetch_assoc()) {
                    $tit = ($jogador["titular"] == 1) ? "SIM" : "NÃO";
                    $sup = ($jogador["sup"] == 1) ? "SIM" : "NÃO";
                    echo "
                                        <tr>
                                            <td>$tit</td>
                                            <td>" . $jogador["ordem"] . "</td>
                                            <td>" . $jogador["pos"] . "</td>
                                            <td>" . $jogador["nome"] . "</td>
                                            <td>$sup</td>
                                        </tr>
                                        ";
                }
                ?>
            </tbody>
        </table>
        <?php if (mysqli_num_rows($jogadores) == 0) {
            echo "<tr><td>Ainda não há jogadores nesta equipa</td></tr>";
        } ?>
    </div>
    <?php require "footer.php" ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>