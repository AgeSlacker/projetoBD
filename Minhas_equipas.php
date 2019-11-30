<?php
session_start();
require_once "force_login.php";
require_once "connect.php";
$conn = mysqli_connect($servername, $username, $password, $dbname);
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Minhas_equipas</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?h=55a404c6b19f68e1c3974b42d10918d9">
    <link rel="stylesheet" href="assets/css/styles.css?h=d41d8cd98f00b204e9800998ecf8427e">
</head>

<body style="overflow-x:hidden;">
    <?php require_once "top_navbar.php" ?>
    <div class="row">
        <div class="col">
            <h1 class="text-center">Minhas Equipas</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive text-center">
                <table class="table">
                    <thead>
                        <tr style="background-color: #000000;color: rgb(255,255,255);">
                            <th>Nome Da Equipa</th>
                            <th>Posição</th>
                            <th>Gerir Equipa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cc = $_SESSION["cc"];
                        $sql = "SELECT equipa_nome, posicao, aceite 
										FROM posjogadorequipa 
										WHERE pessoa_cc = '$cc'";
                        if ($result = $conn->query($sql)) {

                            while ($row = $result->fetch_assoc()) {
                                if ($row["aceite"] = 1) {

                                    echo "<tr>";
                                    echo "<td>";
                                    echo $row["equipa_nome"];
                                    echo "</td>";
                                    echo "<td>";
                                    echo $row["posicao"];
                                    echo "</td>";
                                    //echo "<td><button class=\"btn btn-primary\" type=\"button\" style=\"padding-right: 12px;margin-right: 10px;height: 38px;\">Gerir</button><button class=\"btn btn-primary\" type=\"button\">Info</button></td>";
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-10 col-sm-5 col-md-4 col-lg-3 col-xl-3 offset-2 offset-sm-7 offset-md-8 offset-lg-8 offset-xl-8"><a class="btn btn-primary" type="button" href="minha_area.php" style="margin-bottom:50px;margin-top:50px;background-color: rgb(0,0,0);width: 100%;">Voltar</a></div>
    </div>
    <?php require_once "footer.php" ?>
    <script src="assets/js/jquery.min.js?h=83e266cb1712b47c265f77a8f9e18451"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js?h=63715b63ee49d5fe4844c2ecae071373"></script>
</body>

</html>