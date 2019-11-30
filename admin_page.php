<?php

session_start();
require "force_login.php";
require "connect.php";

if ($_SESSION["cc"] != 111111) {
    header("Location: index.php");
    exit();
}

//echo print_r($_POST, true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num = $_POST["num"];
    for ($i = 0; $i < $num; $i++) {
        echo $i;
        $cc = $_POST["cc$i"];
        $pode_criar = isset($_POST["pode_criar$i"]) ? 1 : 0;
        $banned = isset($_POST["ban$i"]) ? 1 : 0;
        $sql = "UPDATE pessoa SET pode_criar = $pode_criar, banned = $banned WHERE cc = $cc";
        $result = $conn->query($sql);
        if (!$result) {
            echo mysqli_error($conn);
        }
    }
}

$sql = "SELECT * from pessoa";
$pessoas = $conn->query($sql);
if (!$pessoas) {
    echo mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin page</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="overflow-x: hidden;">
    <?php require "top_navbar.php" ?>
    <div class="container" style="max-width: 500px;">
        <div class="jumbotron">
            <h1>Admin Page</h1>
            <div class="form-group text-center">
                <div class="table-responsive">
                    <form method="post">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pessoa</th>
                                    <th class="text-center">Criar Torneios</th>
                                    <th class="text-center">Banir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $num = 0;
                                echo "<input hidden value=" . $pessoas->num_rows . " name='num'>";
                                while ($pessoa = $pessoas->fetch_assoc()) {
                                    $nome = $pessoa["nome"] . " " . $pessoa["sobrenome"];
                                    $cc = $pessoa["cc"];
                                    $pode_criar = ($pessoa["pode_criar"] == 1) ? "checked" : "";
                                    $banned = ($pessoa["banned"] == 1) ? "checked" : "";
                                    echo "<tr>
                                    <td>$nome</td>
                                    <input hidden value='$cc' name='cc$num'/>
                                    <td class='text-center'>
                                    <input type='checkbox' $pode_criar name='pode_criar$num' data-toggle='toggle' data-on='Pode' data-off='Não pode' data-onstyle='success' data-offstyle='danger'></td>
                                    <td><input type='checkbox' $banned name='ban$num' data-toggle='toggle' data-on='Banido' data-off='Ativo' data-onstyle='danger' data-offstyle='success'></td>
                                    </tr>";
                                    $num++;
                                }
                                ?>
                            </tbody>
                        </table>
                </div><button class="btn btn-primary" type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>
    <?php require "footer.php" ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script>
        /*$(document).ready(function() {
            $(".btn-danger").off('click').click(function() {

                $.confirm({
                    title: 'Tem a certeza que quer apagar este user?',
                    content: 'Simple confirm!',
                    buttons: {
                        confirm: function() {
                            $.alert('Confirmed!');
                        },
                        cancel: function() {
                            $.alert('Canceled!');
                        },
                        somethingElse: {
                            text: 'Something else',
                            btnClass: 'btn-blue',
                            keys: ['enter', 'shift'],
                            action: function() {
                                $.alert('Something else?');
                            }
                        }
                    }
                });
            });
        });*/
    </script>
</body>

</html>