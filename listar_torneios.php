<?php
session_start();
require_once "connect.php";
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>ListaTorneios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="icon" href="assets/images/icon.ico" type="image/gif">
</head>

<body>
    <?php require "top_navbar.php" ?>
    <div>
        <form method="post">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <p>Filtrar</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <input type="search" name="torneioId" placeholder="Nome do torneio"></div>
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="iniciado" id="formCheck-1" <?php if (!empty($_POST["iniciado"])) {
                                                                                                                echo " checked ";
                                                                                                            } ?>>
                        <label class="form-check-label" for="formCheck-1">A decorrer</label></div>
                    <div class="form-check"><input class="form-check-input" name="vagas" type="checkbox" id="formCheck-2"><label class="form-check-label" for="formCheck-2">Equipa com vagas</label>
                    </div>
                </div>
                <div class="col"><label>Data de inicio</label><input type="date" name="startDate" <?php
                                                                                                    if (!empty($_POST["startDate"])) {
                                                                                                        echo " value='" . $_POST["startDate"] . "' ";
                                                                                                    }
                                                                                                    ?>></div>
                <div class="col"><label>Data final</label><input type="date" name="endDate" <?php
                                                                                            if (!empty($_POST["endDate"])) {
                                                                                                echo " value='" . $_POST["endDate"] . "' ";
                                                                                            }

                                                                                            ?>></div>
                <div class="col">
                    <select class="form-control" name="cidade">
                        <option>Qualquer</option>
                        <?php
                        $result = $conn->query("SELECT DISTINCT cidade from torneio");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $option = "<option";
                                if (!empty($_POST["cidade"] && $_POST["cidade"] == $row["cidade"])) {
                                    $option = $option . " selected";
                                }
                                $option = $option . ">";
                                echo $option . $row["cidade"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <button class="btn btn-primary" type="submit">Search</button></div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Torneio ID</th>
                        <th>A decorrer</th>
                        <th>Data de inicio</th>
                        <th>Data final</th>
                        <th>Cidade</th>
                        <th>Equipa com vagas</th>
                        <th>Info</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT id, iniciado, inicio, fim, cidade FROM torneio";

                    $filterAndMode = false;

                    if (!empty($_POST["iniciado"])) {
                        $iniciado = $_POST["iniciado"] == 'on' ? 1 : 0;
                        if ($filterAndMode) {
                            $sql = $sql . " AND iniciado = $iniciado";
                        } else {
                            $sql = $sql . " WHERE iniciado = $iniciado";
                            $filterAndMode = true;
                        }
                    }

                    if (!empty($_POST["cidade"]) && $_POST["cidade"] != 'Qualquer') {
                        $cidade = $_POST["cidade"];
                        if ($filterAndMode) {
                            $sql = $sql . " AND cidade = '$cidade'";
                        } else {
                            $sql = $sql . " WHERE cidade = '$cidade'";
                            $filterAndMode = true;
                        }
                    }

                    if (!empty($_POST["startDate"])) {
                        $startDate = $_POST["startDate"];
                        if ($filterAndMode) {
                            $sql = $sql . " AND inicio >= '$startDate'";
                        } else {
                            $sql = $sql . " WHERE inicio >= '$startDate'";
                            $filterAndMode = true;
                        }
                    }

                    if (!empty($_POST["endDate"])) {
                        $endDate = $_POST["endDate"];
                        if ($filterAndMode) {
                            $sql = $sql . " AND fim <= '$endDate'";
                        } else {
                            $sql = $sql . " WHERE fim <= '$endDate'";
                            $filterAndMode = true;
                        }
                    }

                    echo $sql;

                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        echo "<tr><td>" . $row["id"] . "</td>" .
                            "<td>" . $row["iniciado"] . "</td>" .
                            "<td>" . $row["inicio"] . "</td>" .
                            "<td>" . $row["fim"] . "</td>" .
                            "<td>" . $row["cidade"] . "</td>" .
                            "<td></td>" .
                            "<td>" .
                            "<a href='Info_torneio.php?id=$id' class='btn btn-info' role='button'>Info</a>" .
                            "</td></tr>";
                    }
                    ?>
                    <tr>
                        <td>Cell 1</td>
                        <td>Cell 2</td>
                        <td>Cell 3</td>
                        <td>Cell 4</td>
                        <td>Cell 5</td>
                        <td>Cell 6</td>
                        <td>Cell 7</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="footer-dark" style="background-color: rgb(0,0,0);">
        <?php require "footer.php" ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>


</body>

</html>