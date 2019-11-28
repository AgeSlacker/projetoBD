<?php
session_start();

require_once "connect.php";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Pagina Inicial</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css" integrity="test">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Simple-Slider.css">
    <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body style="background-color: rgb(0,0,0);">
    <?php require "top_navbar.php" ?>
    <div class="simple-slider" style="margin-top: 30px;">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image: url(http://drinktank.org.au/wp-content/uploads/2018/06/dt-soccerfield-1500x500.jpg);"></div>
                <div class="swiper-slide" style="background-image:url(https://igeeksoccer.com/wp-content/uploads/2019/02/SOCCER-FOOTWORK-DRILLS-TO-HELP-DEVELOP-TECHNIQUE-1500x500.png);"></div>
                <div class="swiper-slide" style="background-image:url(https://districtsportssoccer.org/wp-content/uploads/2018/02/Tubman-Women-1500x500.jpg);"></div>
            </div>
            <div class="swiper-pagination" style="color: rgb(0,0,0);"></div>
            <div class="swiper-button-prev swiper-button-black"></div>
            <div class="swiper-button-next swiper-button-black"></div>
        </div>
    </div>
    <div class="footer-dark" style="background-color: rgb(0,0,0);">
        <?php require "footer.php" ?>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
    <script src="assets/js/Simple-Slider.js"></script>
</body>

</html>