<?php
$servername = "81.88.52.17";
$port = 3306;
$username = "qm3jt7qs_AIOO";
$password = "basesdedados";
$dbname = "qm3jt7qs_projetobd_aioo";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
