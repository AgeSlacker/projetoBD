<?php
session_start();
// Se já estiver loggado volta para o index
if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)) {
    header('Location: index.php');
    exit();
}

require_once "connect.php";

//echo print_r($_POST, true);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        !empty($_POST["name"]) &&
        !empty($_POST["cc"]) &&
        !empty($_POST["email"]) &&
        !empty($_POST["number"]) &&
        !empty($_POST["password"]) &&
        !empty($_POST["password_repeat"])
    ) {

        $error = false;
        $cc = mysqli_escape_string($conn, $_POST["cc"]);
        $name = mysqli_escape_string($conn, $_POST["name"]);
        $email = mysqli_escape_string($conn, $_POST["email"]);
        $number = mysqli_escape_string($conn, $_POST["number"]);
        $password = mysqli_escape_string($conn, $_POST["password"]);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT cc from pessoa where cc = $cc";
        if (!($result = $conn->query($sql))) {
            // erro, já existe user com este cc registado
            $error = true;
            echo "error, cc already exists";
        }

        if (!$error) {
            $sql = "INSERT INTO pessoa (cc, nome, sobrenome, contacto, email, password, data_nasc, profile_photo, saldo) 
                    VALUES ($cc, '$name', '', $number, '$email' , '$password' , '0000-00-00', NULL, '0')";
            //echo $sql;
            if (!$conn->query($sql)) {
                echo mysqli_error($conn);
            }
            header("Location: login.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>RegisterLogin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .form-control {}

        .container {
            max-width: 350px;
        }
    </style>
    <link rel="icon" href="assets/images/icon.ico" type="image/gif">
</head>

<body style="overflow-x: hidden;">
    <?php require "top_navbar.php" ?>
    <h1 style="margin-bottom:40px;margin-top:45px;" align="center">Register</h1>
    <div id="registerform" class="container" style="max-width: 350px">
        <form method="post">
            <div class="form-group"><input class="form-control" type="text" placeholder="Nome" required="" name="name"></div>
            <div class="form-group"><input class="form-control" type="number" placeholder="CC" required="" name="cc"></div>
            <div class="form-group"><input class="form-control" type="number" placeholder="Contacto" required="" name="number"></div>
            <div class="form-group"><input class="form-control" type="email" placeholder="Email" required="" name="email"></div>
            <div class="form-group"><input class="form-control" type="password" placeholder="password" required="" minlength="6" maxlength="18" name="password"></div>
            <div class="form-group"><input class="form-control" type="password" placeholder="repeat password" required="" minlength="6" maxlength="18" name="password_repeat"></div>
            <div class="form-group text-center"><button class="btn btn-dark" type="submit">Register</button></div>
            <div class="form-group text-center" style="margin-bottom:100px;"><a href="login.php">Já possui uma conta? Clique aqui</a></div>
        </form>
    </div>
    <?php require "footer.php" ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>