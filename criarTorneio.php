<?php
session_start();

require "force_login.php";
require_once "connect.php";

echo "<pre>" . print_r($_POST, true) . "</pre>";

if (isset($_POST['cancelar'])) {
    //header('Location: index.php');
}

if (isset($_POST['criar'])) {
    if (isset($_POST['range']) && !empty($_POST['range'])) {
        $iniciostr = substr($_POST['range'], 0, 10);
        $fimstr = substr($_POST['range'], 14, 24);
        $inicio = new DateTime($iniciostr);
        $fim = new DateTime($fimstr);
        $fim = $fim->modify(' +1 day');
        $intervalo = new DateInterval('P1D');
        $datas = new DatePeriod($inicio, $intervalo, $fim);

        $test = $inicio->format('w');

        $seg = (isset($_POST['seg'])) ? true : false;
        $ter = (isset($_POST['ter'])) ? true : false;
        $qua = (isset($_POST['qua'])) ? true : false;
        $qui = (isset($_POST['qui'])) ? true : false;
        $sex = (isset($_POST['sex'])) ? true : false;
        $sab = (isset($_POST['sab'])) ? true : false;
        $dom = (isset($_POST['dom'])) ? true : false;
        $diasemana = [$dom, $seg, $ter, $qua, $qui, $sex, $sab];

        $horseg = (!empty($_POST['horseg'])) ? $_POST['horseg'] : -1;
        $horter = (!empty($_POST['horter'])) ? $_POST['horter'] : -1;
        $horqua = (!empty($_POST['horqua'])) ? $_POST['horqua'] : -1;
        $horqui = (!empty($_POST['horqui'])) ? $_POST['horqui'] : -1;
        $horsex = (!empty($_POST['horsex'])) ? $_POST['horsex'] : -1;
        $horsab = (!empty($_POST['horsab'])) ? $_POST['horsab'] : -1;
        $hordom = (!empty($_POST['hordom'])) ? $_POST['hordom'] : -1;
        $horarios = [$hordom, $horseg, $horter, $horqua, $horqui, $horsex, $horsab];
        $precheck = 1;
        for ($i = 0; $i < 7; $i++) {
            if ($diasemana[$i] && $horarios[$i] == -1) {
                echo "VAI APRENDER A PREENCHER DIREITO";
                $precheck = 0;
            }
        }

        $cidade = (!empty($_POST['cidade'])) ? $_POST['cidade'] : "Sem Cidade Definida";

        if ($precheck == 1) {
            $sql = "INSERT INTO torneio (iniciado, inicio, fim, cidade) VALUES (0, '$iniciostr', '$fimstr', '$cidade')";
            if (!$conn->query($sql)) {
                echo mysqli_error($conn);
            }
            $idtorneio = $conn->insert_id;
            $sql = "INSERT INTO slot (hora_inicio, hora_fim, data, torneio_id) VALUES";
            $first = false;
            foreach ($datas as $dia) {
                if ($diasemana[$dia->format('w')]) {
                    if ($first) {
                        $sql = $sql . ",";
                    } else {
                        $first = true;
                    }
                    $hourinit = $horarios[$dia->format('w')];
                    $diaformat = $dia->format("Y-m-d");
                    $sql = $sql . "('$hourinit', '', '$diaformat', $idtorneio)";
                }
            }
            echo "<pre>$sql</pre>";
            if (!$conn->query($sql)) {
                echo mysqli_error($conn);
            }
        }


        echo print_r($diasemana, true);
        echo "<p>" . print_r($horarios, true) . "</p>";

        echo "<p> primeiro dia selecionado : " . $test . "</p>";
    }
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>criarTorneio</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/airbnb.css">
    <link rel="stylesheet" href="assets/css/backgroundflatpickrselect.css">
    <link rel="icon" href="assets/images/icon.ico" type="image/gif">
</head>

<body style="overflow-x:hidden; user-select: none;">
    <?php require "top_navbar.php" ?>
    <form method="post">
        <div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div style="margin-top: 0px;margin-bottom: 78px;height: 80px;padding-top: 29px;width: 100%;">
                            <h1 class="text-center" style="margin-top: 0px;margin-bottom: 0px;">Criação de Torneio</h1>
                        </div>
                    </div>
                    <div class="col">
                        <div></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-3">
                                <div class="text-center" style="margin-top: 30px;"><i class="fa fa-calendar" style="font-size: 73px;"></i>
                                    <p>Defina o inicio e fim do torneio</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="datePicker">
                                    <input id="input" class="input-date" name="range" type="text" placeholder="Select Date..." style="visibility:hidden;" data-input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-3 text-center">
                                <div><i class="fa fa-clock-o" style="font-size: 77px;"></i>
                                    <p>Defina os dias e horarios dos jogos</p>
                                </div>
                            </div>
                            <div class="col">
                                <div style="margin-top:40px;">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="seg" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Segunda-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" name="horseg" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="ter" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Terça-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" name="horter" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="qua" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Quarta-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" name="horqua" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="qui" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Quinta-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" name="horqui" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="sex" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Sexta-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" name="horsex" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="sab" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Sabado</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" name="horsab" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check"><input class="form-check-input" name="dom" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Domingo</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" name="hordom" type="time"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    <p class="text-right" style="margin-top: 20px;">Defina a localidade do torneio:</p>
                </div>
                <div class="col"><input type="text" name="cidade" style="border: 2px solid #000000;outline:none;margin-top: 20px;"></div>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col text-right"><a class="btn btn-dark" href="index.php" style="background-color: rgb(0,0,0);width: 159px;margin-bottom: 20px;margin-top: 20px;margin-right: 20px;">Cancelar &nbsp;&nbsp;<i class="fa fa-close"></i></a></div>
                <div class="col"><button class="btn btn-dark" name="criar" type="submit" style="background-color: rgb(0,0,0);width: 159px;margin-top:20px;margin-right: 20px;">Confirmar &nbsp;&nbsp;<i class="fa fa-check"></i>&nbsp;</button></div>
            </div>
        </div>
    </form>
    <?php require "footer.php" ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
    <script>
        $(".input-date").flatpickr({
            inline: true,
            mode: "range",
            dateFormat: "Y-m-d",
            minDate: "today"
        });
    </script>
</body>

</html>