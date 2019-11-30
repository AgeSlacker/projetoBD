<?php
session_start();

require "force_login.php";
require_once "connect.php";

if (isset($_GET['torneioid'])) {
    $torneioid = $_GET['torneioid'];
}


if (isset($_POST['criar'])) {

    //criação dos jogos
    $sql = "SELECT DISTINCT GREATEST( b.nome, a.nome) as first, LEAST( b.nome, a.nome) as second 
    FROM equipa a, equipa b 
    WHERE a.nome <> b.nome 
    AND a.aceite = 1 
    AND b.aceite = 1 
    ORDER BY first";
    if (!($jogos = $conn->query($sql))) {
        echo mysqli_error($conn);
    }
    $Njogos = $jogos->num_rows;

    $sql = "SELECT count(*) as num
    FROM slot
    WHERE torneio_id = 1";
    if (!($Nslots = $conn->query($sql))) {
        echo mysqli_error($conn);
    }
    $Nslots = $Nslots->fetch_assoc();
    $Nslots = $Nslots["num"];



    if ($Nslots >= $Njogos) {
        //update do estado do torneio
        $sql = "UPDATE torneio
            SET iniciado = 1
            WHERE id = $torneioid";
        if (!$conn->query($sql)) {
            echo mysqli_error($conn);
        }
        $sql = "INSERT INTO jogo (id, golosa1, golosb1, golosa2, golosb2, slot_hora_inicio, slot_torneio_id, equipa_nome, equipa_nome1, campo_nome) VALUES";
        $first = false;
        while ($row = $jogos->fetch_assoc()) {
            if ($first) {
                $sql = $sql . ",";
            } else {
                $first = true;
            }
            $sql = $sql . "('1', NULL, NULL, NULL, NULL, '15:00:00', '2', 'Equipa B', 'ADAWED', 'Campo de Coimbra')";
        }
    }
}



if (isset($_POST['aceitar'])) {
    $nomeaceite = $_POST['aceitar'];
    $sql = "UPDATE equipa
           SET aceite = 1
           WHERE equipa.nome = '$nomeaceite'";
    if (!$conn->query($sql)) {
        echo mysqli_error($conn);
    }
}

if (isset($_POST['deleteslot'])) {
    $horaexcluir = $_POST['deleteslot'];
    $sql = "DELETE FROM slot
           WHERE hora_inicio = '$horaexcluir'
           AND slot.torneio_id = '$torneioid'";
    if (!$conn->query($sql)) {
        echo mysqli_error($conn);
    }
}


if (isset($_POST['excluir'])) {
    $nomeexcluir = $_POST['excluir'];
    $sql = "DELETE FROM equipa
           WHERE equipa.nome = '$nomeexcluir'";
    if (!$conn->query($sql)) {
        echo mysqli_error($conn);
    }
}

if (isset($_POST['retirar'])) {
    $nomeretirar = $_POST['retirar'];
    $sql = "UPDATE equipa
           SET aceite = 0
           WHERE equipa.nome = '$nomeretirar'";
    if (!$conn->query($sql)) {
        echo mysqli_error($conn);
    }
}



$sql = "SELECT equipa.nome as enome, pessoa.nome pnome
          FROM equipa, pessoa
          WHERE equipa.torneio_id = $torneioid
            AND equipa.pessoa_cc = pessoa.cc
            AND equipa.aceite <> 1
          ORDER BY equipa.nome";
$list_pendentes = $conn->query($sql);

$sql = "SELECT equipa.nome as enome, pessoa.nome as pnome
          FROM equipa, pessoa
          WHERE equipa.torneio_id = $torneioid
            AND equipa.pessoa_cc = pessoa.cc
            AND equipa.aceite = 1
          ORDER BY equipa.nome";
$list_confirmadas = $conn->query($sql);
// 'Sem Campo' as semcampo
$sql = "SELECT hora_inicio ,data, 'Sem campo' as semcampo
          FROM slot
          WHERE slot.torneio_id = $torneioid ";
$list_slots = $conn->query($sql);

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gerenciar Torneios</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
        }
    </style>
    <link rel="icon" href="assets/images/icon.ico" type="image/gif">
</head>

<body style="overflow-x:hidden;padding: 0px;">
    <?php require "top_navbar.php" ?>
    <div>
        <div class="container" style="width: 100%;max-width: 100%;min-width: 30%;">
            <div class="row">
                <div class="col-md-12" style="margin: 0px;">
                    <h1 style="font-size: 33px;margin-top:10px;font-style: normal;font-weight: normal;">Gerenciamento de Torneio</h1>
                </div>
            </div>
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-4">
                    <div style="background-color: #000000;width: 100%;height: 41px;">
                        <p class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="color: rgb(255,255,255);padding: 5px;">Equipes Pendentes</p>
                    </div>
                    <div class="table-responsive border rounded-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Equipe</th>
                                    <th>Capitão</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $list_pendentes->fetch_assoc()) {
                                    echo "<tr><td>" . $row["enome"] . "</td>" .
                                        "<td>" . $row["pnome"] . "</td>" .
                                        "<td>
            <form method='post'>
                <div class='row' style='width: 100%;'>
                    <div class='col' style='width: 100%;'><button type='submit' name='aceitar' value = '" . $row["enome"] . "' class='btn btn-primary btn-sm border-dark' style='height: 26px;font-size: 14px;background-color: rgb(0,0,0);'>Aceitar</button></div>
                </div>
                <div class='row' style='width: 100%;'>
                    <div class='col' style='width: 100%;'><button type='submit' name='excluir' value = '" . $row["enome"] . "' class='btn btn-primary btn-sm text-center border-white' type='button' style='height: 26px;background-color: #a3081a;'>Excluir</button></div>
                </div>
            </form>
          </td>
      </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="background-color: #000000;width: 100%;height: 41px;">
                        <p class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="color: rgb(255,255,255);padding: 5px;">Equipes Já Inscritas</p>
                    </div>
                    <div class="table-responsive border rounded-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Equipe</th>
                                    <th>Capitão</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $list_confirmadas->fetch_assoc()) {
                                    echo "<tr><td>" . $row["enome"] . "</td>" .
                                        "<td>" . $row["pnome"] . "</td>" .
                                        "<td>
    <form method='post'>
      <div class='row' style='width: 100%;'>
          <div class='col' style='width: 100%;'><button type='submit' name='retirar' value = '" . $row["enome"] . "' class='btn btn-primary btn-sm text-center border-white' type='button' style='height: 26px;background-color: #a3081a;'>Retirar</button></div>
      </div>
    </form>
  </td>
</tr>";
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="background-color: #000000;width: 100%;height: 41px;">
                        <p class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="color: rgb(255,255,255);padding: 5px;">Jogos</p>
                    </div>
                    <div class="table-responsive border rounded-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Dia&nbsp;</th>
                                    <th>Campo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    while ($row = $list_slots->fetch_assoc()) {
                                        echo "<tr><td>" . $row["data"] . "</td>" .
                                            "<td>" . $row["semcampo"] . "</td>" .
                                            "<td>
        <form method='post'>
          <div class='row' style='width: 100%;'>
              <div class='col' style='width: 100%;'><button type='submit' name='deleteslot' value = '" . $row["hora_inicio"] . "' class='btn btn-primary btn-sm text-center border-white' type='button' style='height: 26px;background-color: #a3081a;'>Excluir</button></div>
          </div>
        </form>
    </td>
</tr>";
                                    }
                                    ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 60px;">
        <div class="col text-center"><button class="btn btn-primary border-white" type="button" name="criar" style="background-color: #000000;width: 315px;height: 60px;font-size: 33px;margin-top: 0px;">Iniciar Torneio</button></div>
    </div>
    <div class="row" style="margin-top: 27px; margin-bottom:20px;">
        <div class="col"><button class="btn btn-primary btn-lg border-white" type="button" style="width: 170px;margin-left: 53px;min-width: -8px;max-width: -10px;background-color: #a3081a;">Deletar Torneio</button></div>
    </div>
    <div class="footer-dark" style="background-color: rgb(0,0,0);">
        <?php require "footer.php" ?>
    </div>
</body>

</html>