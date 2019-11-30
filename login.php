<?php
session_start();
// If already logged in redirect to index
if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)) {
    header('Location: index.php');
    exit();
}

require_once "connect.php";
function get_password_by_id($cc, $conn)
{
    $cc = mysqli_real_escape_string($conn, $cc);
    $sql = "SELECT password, banned from pessoa where cc=$cc";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
    }
    if (mysqli_num_rows($result) == 0) {
        return null;
    }

    $result = $result->fetch_assoc();

    // check if user is banned
    if ($result["banned"] == 1) {
        $_SESSION["banned_notify"] = true;
        echo "<script>alert('This user is banned.')</script>";
    }

    return $result["password"];
}

function do_login($cc, $password, $conn)
{
    $_SESSION["wrongPassword"] = false;
    $_SESSION["noUser"] = false;
    $hashedPassword = get_password_by_id($cc, $conn);
    if (!$hashedPassword) {
        $_SESSION["noUser"] = true;
        return;
    } else {
        if (!password_verify($_POST["password"], $hashedPassword)) {
            // set wrong password
            $_SESSION["wrongPassword"] = true;
            return;
        } else {
            $_SESSION["logged"] = true;
            $_SESSION["cc"] = $cc;
            unset($_SESSION["wrongPassword"]);
            unset($_SESSION["noUser"]);
            header('Location: minha_area.php');
            exit();
        }
    }
    return;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["cc"]) && !empty($_POST["password"])) {
        do_login($_POST["cc"], $_POST["password"], $conn);
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
    <link rel="icon" href="assets/images/icon.ico" type="image/gif">
</head>

<body style="overflow-x: hidden;">
    <?php require "top_navbar.php" ?>
    <h1 style="margin-bottom:65px;;margin-top:50px;" align="center">Login</h1>
    <div id="loginform" class="container" style="max-width: 350px">
        <form method="post">
            <div class="form-group">
                <input class="form-control <?php if (isset($_SESSION["noUser"]) && $_SESSION["noUser"] == true) {
                                                echo "is-invalid";
                                            } ?>" type="number" placeholder="CC" required="" name="cc">
                <?php
                if (isset($_SESSION["noUser"]) && $_SESSION["noUser"] == true) {
                    echo "<small class='text-danger'> No such user.</small> ";
                }
                unset($_SESSION["noUser"]);
                ?>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" placeholder="password" required="" minlength="6" maxlength="18" name="password">
                <?php
                if (isset($_SESSION["wrongPassword"]) && $_SESSION["wrongPassword"] == true) {
                    echo "<label style='color: red;' for='password'>Wrong password!</label>";
                }
                unset($_SESSION["wrongPassword"]);
                ?>
            </div>
            <div class="form-group text-center"><button class="btn btn-dark" type="submit">Login</button></div>
            <div class="form-group text-center" style="margin-bottom:100px;"><a href="register.php">Não tem uma conta? Clique aqui</a></div>
        </form>
    </div>
    <div class="footer-dark" style="background-color: rgb(0,0,0);">
        <?php require "footer.php" ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>