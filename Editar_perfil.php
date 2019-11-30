<?php
session_start();
require "force_login.php";
require_once "connect.php";

$cc = $_SESSION["cc"];
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
    $sql = "SELECT password from pessoa where cc=$cc";
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


    $sql = "UPDATE pessoa SET nome = '$nome', sobrenome = '$sobrenome', contacto = $cont, email = '$email', data_nasc = '$data' 
            WHERE pessoa.cc = $cc";

    //echo $sql;

    if (!$conn->query($sql)) {
        echo mysqli_error($conn);
    }
}

$sql = "SELECT cc,nome,sobrenome,contacto,email,data_nasc from pessoa where cc=$cc";

//echo $sql;

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

<body style="overflow-x: hidden;">
    <?php require_once "top_navbar.php" ?>
    <div class="text-center">
        <form method="post">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <img class="img-thumbnail img-fluid" src="assets/img/default-user.png" style="margin-top:20px;margin-bottom:20px;" loading=" auto" width="400">
                        <input class="form-control" type="text" placeholder="Nome" name="nome" style="margin-bottom:20px; value=" <?php
                                                                                                                                    echo $pessoa["nome"];
                                                                                                                                    ?>">
                        <input class="form-control" type="text" placeholder="Sobrenome" style="margin-bottom:20px; name=" sobrenome" value="<?php echo $pessoa["sobrenome"]; ?>">
                    </div>
                    <div class="col-md-6 align-self-center">
                        <input class="form-control" style="margin-bottom:20px; type=" email" placeholder="Email" name="email" value="<?php echo $pessoa["email"]; ?>" style="margin: 0px;margin-bottom: 0px;">
                        <input class="form-control" style="margin-bottom:20px; type=" tel" placeholder="contacto" name="contacto" value="<?php echo $pessoa["contacto"]; ?>">
                        <input class="form-control" style="margin-bottom:20px; type=" date" name="data" placeholder="dd-mm-aaaa" value="<?php echo $pessoa["data_nasc"]; ?>">
                        <input class="form-control" style="margin-bottom:20px; type=" password" placeholder="password atual" name="password">
                        <input class="form-control" style="margin-bottom:20px; type=" password" placeholder="password nova" name="password_nova">
                        <input class="form-control" style="margin-bottom:20px; type=" password" placeholder="password nova repetida" name="password_nova_rep">
                        <input class="form-control" style="margin-bottom:20px; type=" text" placeholder="Descrição">
                        <a href="Meu_perfil.php?id=14900002">
                            <button class="btn btn-dark" type="submit">Guardar</button>
                        </a>
                        <a href="Meu_perfil.php?id=14900002">
                            <button class="btn btn-dark" type="button">Regressar</button>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php require_once "footer.php" ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>