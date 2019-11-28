<?php
session_start();

require_once "connect.php";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php




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
                                    <input id="input" class="input-date" name="range" type="text" placeholder="Select Date..." style="visibility:hidden !important;" data-input>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-3 text-center">
                                <div><i class="fa fa-clock-o" style="font-size: 77px;"></i>
                                    <p>Defina o Horario dos jogos</p>
                                </div>
                            </div>
                            <div class="col">
                                <div style="margin-top:40px;">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="seg" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Segunda-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="ter" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Terça-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="qua" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Quarta-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="qui" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Quinta-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="sex" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Sexta-Feira</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check" style="margin-bottom: 10px;"><input class="form-check-input" name="sab" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Sabado</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" type="time"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-check"><input class="form-check-input" name="dom" type="checkbox" id="formCheck-1"><label class="form-check-label" for="formCheck-1">Domingo</label></div>
                                        </div>
                                        <div class="col"><input class="border rounded-0 border-dark" type="time"></div>
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
                <div class="col text-right"><button class="btn btn-dark" name="cancelar" type="submit" style="background-color: rgb(0,0,0);width: 159px;margin-bottom: 20px;margin-top: 80px;margin-right: 20px;">Cancelar &nbsp;&nbsp;<i class="fa fa-close"></i></button></div>
                <div class="col"><button class="btn btn-dark" name="criar" type="submit" style="background-color: rgb(0,0,0);width: 159px;margin-top: 80px;margin-right: 20px;">Confirmar &nbsp;&nbsp;<i class="fa fa-check"></i>&nbsp;</button></div>
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
            dateFormat: "d-m-Y",
            minDate: "today"
        });
    </script>
</body>

</html>