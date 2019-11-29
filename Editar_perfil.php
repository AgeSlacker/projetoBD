<?php
session_start();
require "force_login.php";
require_once "connect.php";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



//conecção feita
if (!empty($_POST)) {

    implode("|", $_POST);

    if (empty($_POST["email"])) {
        // escrever erro
    }
    $email = $_POST["email"];
    if (empty($_POST["contacto"])) {
        // escrever erro
    }
    $cont = $_POST["contacto"];
    if (empty($_POST["nome"])) {
        // escrever erro
    }
    $nome = $_POST["nome"];
    if (empty($_POST["sobrenome"])) {
        // escrever erro
    }
    $sobrenome = $_POST["sobrenome"];
    if (empty($_POST["data"])) {
        // escrever erro
    }
    $data = $_POST["data"];
    if (empty($_POST["password"])) {
        // escrever erro
    }
    $password = $_POST["password"];
    $sql = "SELECT password from pessoa where cc=14900002";
    $result = $conn->query($sql);
    if ($result = $result->fetch_assoc()) {
        //obteve user co esta passe 
        password_hash($password, PASSWORD_DEFAULT);
    } else {
        echo "data base does not have this user";
        //base de dados nao tem este user
    }
    if (empty($_POST["password_nova"])) {
        // escrever erro
    }
    $password_nova = $_POST["password_nova"];
    if (empty($_POST["password_nova_rep"])) {
        // escrever erro
    }
    $password_nova_rep = $_POST["password_nova_rep"];

    if (password_an)

        $sql = "UPDATE pessoa SET nome = '$nome', sobrenome = '$sobrenome', contacto = $cont, email = '$email', data_nasc = '$data'. 
            WHERE pessoa.cc = 14900002";

    echo $sql;

    if (!$conn->query($sql)) {
        echo mysqli_error($conn);
    }
}

$sql = "SELECT cc,nome,sobrenome,contacto,email,data_nasc from pessoa where cc=14900002";

echo $sql;

$result = $conn->query($sql);
if ($result->num_rows < 1) {
    echo "     Erro esta pessoa nao existe";
    exit();
}

$pessoa = $result->fetch_assoc();
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
    <div class="text-center">
        <form method="post">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img class="img-thumbnail img-fluid" src="assets/img/default-user.png" loading="auto" width="400">
                        <input class="form-control" type="text" placeholder="Nome" name="nome" value="<?php
                                                                                                        echo $pessoa["nome"];
                                                                                                        ?>">
                        <input class="form-control" type="text" placeholder="Sobrenome" name="sobrenome" value="<?php echo $pessoa["sobrenome"]; ?>">
                    </div>
                    <div class="col-md-6 align-self-center">
                        <input class="form-control" type="email" placeholder="Email" name="email" value="<?php echo $pessoa["email"]; ?>" style="margin: 0px;margin-bottom: 0px;">
                        <input class="form-control" type="tel" placeholder="contacto" name="contacto" value="<?php echo $pessoa["contacto"]; ?>">
                        <input class="form-control" type="date" name="data" placeholder="dd-mm-aaaa" value="<?php echo $pessoa["data_nasc"]; ?>">
                        <input class="form-control" type="password" placeholder="password atual" name="password">
                        <input class="form-control" type="password" placeholder="password nova" name="password_nova">
                        <input class="form-control" type="password" placeholder="password nova repetida" name="password_nova_rep">
                        <input class="form-control" type="text" placeholder="Descrição">
                        <a href="Meu_perfil.php?id=14900002">
                            <button class="btn btn-primary" type="submit">Guardar</button>
                        </a>
                        <a href="Meu_perfil.php?id=14900002">
                            <button class="btn btn-primary" type="button">Regressar</button>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>