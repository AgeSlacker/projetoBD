<?php
session_start();
require "force_login.php";
require "connect.php";


//echo print_r($_POST, true);

if (!empty($_GET["nome"]) && !empty($_GET["tid"])) {
    $nome = mysqli_real_escape_string($conn, $_GET["nome"]);
    $tid = mysqli_real_escape_string($conn, $_GET["tid"]);
    $permitir_gerir = false;
    $modo_gestor = false;

    // verificar se o utilizador é gestor
    $sql = "SELECT pessoa_cc FROM equipa where equipa.nome = '$nome'";
    $result = $conn->query($sql);
    if (!$result) {
        // TODO database check
        echo mysqli_error($conn);
    }
    $gestor_equipa_cc = $result->fetch_assoc()["pessoa_cc"];
    if ($_SESSION["cc"] == $gestor_equipa_cc) {
        // este user é o gestor da equipa;
        $permitir_gerir = true;
    }

    // Verificar se o modo gestor está ativado
    if ($permitir_gerir && isset($_POST["modo_gestor"])) {
        $modo_gestor = true;
    }

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
    //echo print_r($result, true);
    $capitao = $result["pnome"] . " " . $result["sobrenome"];
    $composicao = $result["composicao"];
    // Ir buscar os jogadores da equipa
    $sql = "SELECT titular, posicao as pos, suplenteguardaredes as sup, ordem, nome, cc
            FROM posjogadorequipa LEFT JOIN pessoa ON pessoa.cc = pessoa_cc
            WHERE equipa_nome = '$nome'";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
    }
    $jogadores = $result;

    if (isset($_POST["guardar"])) {
        $n = mysqli_num_rows($result);
        for ($i = 0; $i < $n; $i++) {
            $upTit = isset($_POST["isTit$i"]) ? 1 : 0;
            $cc = mysqli_real_escape_string($conn, $_POST["cc$i"]);
            $ord = mysqli_real_escape_string($conn, $_POST["ord$i"]);
            $upSup = isset($_POST["isSup$i"]) ? 1 : 0;
            $upPos = mysqli_real_escape_string($conn, $_POST["newPos$i"]);

            $sql = "UPDATE posjogadorequipa as p SET
                        titular = $upTit,
                        posicao = '$upPos',
                        suplenteguardaredes = $upSup
                        WHERE p.pessoa_cc = $cc
                        ";
            //echo $sql;
            $result = $conn->query($sql);
            if (!$result) {
                mysqli_error($conn);
            }
        }
        // Renovar os jogadores
        $sql = "SELECT titular, posicao as pos, suplenteguardaredes as sup, ordem, nome, cc
        FROM posjogadorequipa LEFT JOIN pessoa ON pessoa.cc = pessoa_cc
        WHERE equipa_nome = '$nome'";
        $result = $conn->query($sql);
        if (!$result) {
            echo mysqli_error($conn);
        }
        $jogadores = $result;
    }
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

<body style="overflow-x: hidden;">
    <?php require "top_navbar.php" ?>
    <h1><?php echo $nome; ?></h1>
    <p class="text-center"><?php echo "Capitão: $capitao Composição: $composicao"; ?></p>
    <?php
    if ($modo_gestor) {
        echo "<form method='post'>
        <button class='btn btn-primary' type='submit' name='guardar'>Guardar</button>";
    } else if ($permitir_gerir) {
        echo "<form method='post'>
        <button class='btn btn-primary' type='submit' name='modo_gestor'>Gerir equipa</button>
        </form>
        ";
    }

    ?>
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
                if ($modo_gestor) {
                    // Modo gestor, pode alterar a composicao da equipa
                    $num = 0;
                    while ($jogador = $jogadores->fetch_assoc()) {
                        $tit = ($jogador["titular"] == 1) ? "checked" : "";
                        $sup = ($jogador["sup"] == 1) ? "checked" : "";
                        $nome_jogador = $jogador["nome"];
                        $ord = $jogador["ordem"];
                        $cc = $jogador["cc"];
                        $pos = $jogador["pos"];
                        echo "
                        <tr> 
                            <td><input type='checkbox' $tit name='isTit$num'/></td>
                            <input hidden value=$ord name='ord$num'/>
                            <td>$ord</td>
                            <td>
                                <select class='form-control' name='newPos$num'>
                                    <optgroup label='Nova posição'>
                                    <option style='color:green'>$pos</option>
                                    <option>Avançado</option>
                                    <option>Médio</option>
                                    <option>Defesa</option>
                                    <option>Guarda-Redes</option>
                                    </optgroup>
                                </select>
                            </td>
                            <input hidden value='$cc' name='cc$num'/>
                            <td>$nome_jogador</td>
                            <td><input type='checkbox' $sup name='isSup$num'/></td>
                        </tr>";
                        $num++;
                    }
                } else {
                    // Modo user normal
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
                }
                ?>
            </tbody>
        </table>
        <?php if (mysqli_num_rows($jogadores) == 0) {
            echo "<tr><td>Ainda não há jogadores nesta equipa</td></tr>";
        } ?>
    </div>
    <?php
    if ($modo_gestor) {
        echo "</form>";
    }
    ?>
    <?php require "footer.php" ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>