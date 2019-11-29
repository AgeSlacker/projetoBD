<?php
session_start();
require "force_login.php";
require_once "connect.php";

$id;
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "SELECT cc,nome,sobrenome,contacto,email,data_nasc,profile_photo,saldo 
            FROM pessoa 
            WHERE cc=$id";

    echo $sql;

    $result = $conn->query($sql);
    if ($result->num_rows < 1) {
        echo "     Erro esta pessoa nao existe";
        exit();
    }
    $pessoa = $result->fetch_assoc();
} else {
    echo "ERRO: Esta página não existe";
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
    <nav class="navbar navbar-dark navbar-expand-md bg-dark">
        <div class="container-fluid"><a class="navbar-brand" href="#">Logo</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="#">First</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">Second</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">Third</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">Fourth</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-6"><img class="img-thumbnail img-fluid" src="assets/img/default-user.png" loading="auto">
                    <form>
                        <input class="form-control" type="text" disabled="" value=" <?php
                                                                                    echo $pessoa["nome"];
                                                                                    ?>">
                    </form>
                </div>
                <div class="col-md-6 align-self-center">
                    <form>
                        <input class="form-control" type="email" value="<?php
                                                                        echo $pessoa["email"]; ?>" style="margin: 0px;margin-bottom: 0px;" disabled="">
                        <input class="form-control" type="tel" value="<?php echo $pessoa["contacto"]; ?>" disabled="">
                        <input class="form-control" type="date" value="<?php echo $pessoa["data_nasc"]; ?>" disabled="">
                        <input class="form-control" type="text" placeholder="temos de alterar isto" disabled="">
                        <a href="Editar_perfil.php?id=<?php echo $id ?>">
                            <button class="btn btn-primary" type="button">Editar</button>
                        </a>
                        <button class="btn btn-primary" type="button">Regressar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>