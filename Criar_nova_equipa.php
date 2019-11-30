<?php
session_start();

require "force_login.php";
require_once "connect.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if (!empty($_POST["nome"])) {
        $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
        $pessoa_cc = $_SESSION["cc"];
        echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
        // TODO verificar se ja existe equipa assim, se o torneio nao est+a iniciado
        $sql = "INSERT INTO equipa (nome, composicao, pessoa_cc, torneio_id) 
                VALUES ('$nome', NULL, $pessoa_cc, $id)";
        if (!$conn->query($sql)) {
            echo mysqli_error($conn);
        };
        // TODO check if error
    }
}

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
    <div>
        <div class="container">
            <form method="post">
                <div class="form-row" style="margin-bottom: 16px;">
                    <div class="col-md-6">
                        <h1>Criar nova equipa no Torneio</h1><label for="nome">Nome da equipa</label><input class="form-control" type="text" placeholder="exemplo nome" name="nome">
                    </div>
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="col"><img></div>
                        </div><input type="file">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col text-center"><button class="btn btn-secondary" type="button">Cancel</button><button class="btn btn-primary" type="submit">Criar nova equipa</button></div>
                </div>
            </form>
        </div>
        <div class="footer-dark" style="background-color: rgb(0,0,0);">
            <?php require "footer.php" ?>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>