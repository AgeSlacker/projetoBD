<?php
include "connect.php";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!empty($_POST["position"]) && !empty($_POST["equipa"])) {
    $pos = mysqli_real_escape_string($conn, $_POST["position"]);
    $equipa = mysqli_real_escape_string($conn, $_POST["equipa"]);

    $sql = "SELECT count(*) FROM ";

    echo "<p> yea?</p>";
}
