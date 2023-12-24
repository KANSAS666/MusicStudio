<?php
session_start();
?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <title>Личный кабинет бухгалтера</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg brown_panel">
        <a class="navbar-brand" href="#">Личный кабинет бухгалтера</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-4">
            <li class="nav-item">
                <a class="nav-link" href="MusicEquipment.php">Оборудование</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="rooms.php">Тариф по залам</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Reports.php">Отчеты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.html">Выход</a>
            </li>
        </ul>
    </div>
    </nav>

    
    
</body>
</html> -->

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.2.2-dist/css/bootstrap.css">
    <!-- <link rel="stylesheet" href="css/menu.css"> -->
    <link rel="stylesheet" href="popUpCss.css">
    <style>
        /* .navbar {
            background-color: #00FFFF;
        } */
        .navbar-brand {
  letter-spacing: 3px;
  color: #1990B7;
}

.navbar-brand:hover {
	color: #1990B7;
}

.navbar-scroll .nav-link,
.navbar-scroll .fa-bars {
  color: #04303E;
}

.navbar-scrolled .nav-link,
.navbar-scrolled .fa-bars {
  color: #04303E;
}

.navbar-scrolled {
  background-color: #ffede7;
}
.container.text-center {
            /* margin-top: 100px; */
            margin-top: 100px;
        }


body {
  /*background-color: #E74C3C; */
  background-image: url('img/admin_background.jpg'); /* Путь к изображению фона */
  background-size: cover; /* Растягиваем изображение на всю область фона */
  background-repeat: no-repeat
}

h4{
      margin-bottom: 10px;
      color: #04303E;
      background: #ADD8E6;
      display: inline-block;
      border-radius: 5px;
      padding: 2px;
}

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    
    
    <title>Личный кабинет бухгалтера</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-scroll shadow-0" style="background-color: #ADD8E6;">
  <div class="container">
    <a class="navbar-brand" href="#">Личный кабинет бухгалтера</a>
    <button class="navbar-toggler ps-0" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
      aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="d-flex justify-content-start align-items-center">
        <i class="fas fa-bars"></i>
      </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarExample01">
    <ul class="navbar-nav mr-4">
            <li class="nav-item">
                <a class="nav-link" href="MusicEquipment.php">Оборудование</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="rooms.php">Тариф по залам</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Reports.php">Отчеты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.html">Выход</a>
            </li>
        </ul>
    </div>
  </div>
</nav>

    
    
</body>
</html>

<script scr="bootstrap-5.2.2-dist/js/bootstrap.js"></script>
<script scr="bootstrap-5.2.2-dist/js/bootstrap.min.js"></script>