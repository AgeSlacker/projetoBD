<?php
session_start();
require_once "connect.php";


function exit_to_list_torneios()
{
    header("Location: listar_torneios.php");
    exit();
}

$jogadores;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Inscrever o jogador na equipa
    if (!empty($_POST["titularSelect"])) {

        echo '<pre>' . print_r($_POST, TRUE) . '</pre>';

        $cc = $_SESSION["cc"];
        $equipaNome = $_POST["equipaNome"]; // TODO check if set
        $gr = (isset($_POST["podeGuardaRedes"]) && $_POST["podeGuardaRedes"] == "on") ? 1 : 0;
        $pos = $_POST["titularSelect"];
        // TODO check if exists, titular, check saldo ?
        $sql = "INSERT INTO posjogadorequipa (titular, posicao, suplenteguardaredes, convocavel, ordem, equipa_nome, pessoa_cc) 
            VALUES (0, '$pos', $gr, 1, 3, '$equipaNome', $cc);";
        echo $sql;
        if (!$conn->query($sql)) {
            echo mysqli_error($conn);
        }
    }
}

if (isset($_GET["nome"])) {
    // verificar se a equipa existe;
    $nome = mysqli_real_escape_string($conn, $_GET["nome"]);
    $equipa = $conn->query("SELECT nome FROM equipa WHERE nome = '$nome'");
    if (mysqli_num_rows($equipa) == 0) {
        // esta equipa nao existe
        exit_to_list_torneios();
    }
    $sql = "SELECT titular, posicao as pos, suplenteguardaredes as sup, ordem, nome
            FROM posjogadorequipa LEFT JOIN pessoa ON pessoa.cc = pessoa_cc
            WHERE equipa_nome = '$nome'";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
    }
    $jogadores = $result;
} else {
    exit_to_list_torneios();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <?php require "top_navbar.php" ?>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="jumbotron">
                        <h1>Inscrição na equipa A</h1>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group text-left"><label>Posição Titular</label>
                                        <input hidden value="<?php echo $_GET["nome"] ?>" name="equipaNome">
                                        <select class="form-control form-control-sm" style="max-width: 200px;" id="titularSelect" name="titularSelect">
                                            <optgroup label="Escolha uma posiçao">
                                                <option selected="">Avançado</option>
                                                <option>Médio</option>
                                                <option>Defesa</option>
                                                <option>Guarda Redes</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="serverAns" style="align-items: center; display: flex;">
                                    <p>TEST</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="formCheck-1" name="podeGuardaRedes"><label class="form-check-label" for="formCheck-1">Pode substituir Guarda redes</label></div>
                            </div>
                            <div class="form-group text-center"><button class="btn btn-dark" type="button" style="margin-right: 25px;width: 100px;">Cancelar</button><button class="btn btn-primary" type="submit" style="width: 100px;">Submeter</button></div>
                        </form>
                        <p>Composição da equipa (4-3-3)</p>
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
                    </div>
                </div>
                <div class="col-md-6 align-self-center"><img class="img-fluid" src="assets/img/5ddfa9e4f142c.png"></div>
            </div>
        </div>
        <?php require "footer.php" ?>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>


<script>
    $(document).ready(function() {
        $("#titularSelect").change(function() {
            $("#serverAns").load("get_team_slots.php", {
                position: $("#titularSelect").val(),
                equipa: <?php echo '"' . $_GET["nome"] . '"' ?>
            });
        });
    });
</script>

</html>