<?php
require_once "connect.php";
if (!empty($_POST["position"]) && !empty($_POST["equipa"])) {
    $equipa = mysqli_real_escape_string($conn, $_POST["equipa"]);
    $posicao = mysqli_real_escape_string($conn, $_POST["position"]);
    $sql = "SELECT count(*) as count
            FROM posjogadorequipa as p
            WHERE p.equipa_nome = '$equipa'
            AND p.posicao = '$posicao';
            ";
    $result = $conn->query($sql);
    if (!$result) {
        echo mysqli_error($conn);
    }
    $count = $result->fetch_assoc()["count"];
    if ($count == 0) {
        echo "<p> Posição está livre </p>";
        exit();
    }
    echo "<p>Há $count pessoas com essa posição</p>";
}
