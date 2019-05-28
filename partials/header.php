<?php 
session_start();
require_once 'functions.php';

$currentPage = getRouteName($_SERVER);

$loggedStatus = $_SESSION['logged'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <title>Rimedia</title>
</head>
<body>
    <!-- Navbar/Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php"><h2>Rimedia</h2></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo($currentPage == "index" ? "active" : "");?>">
                <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span> </a>
            </li>
            <li class="nav-item <?php echo($currentPage == "last" ? "active" : "");?>">
                <a class="nav-link" href="last.php">Derniers</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Genres
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item active" href="#">Découpeurs</a>
                <a class="dropdown-item" href="#">Mélodieux</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="genres.php">Tous genres confondus</a>
                </div>
            </li>
            <li class="nav-item <?php echo($currentPage == "about" ? "active" : "");?>">
                <a class="nav-link" href="about.php">Présentation</a>
            </li>
            <?php if($loggedStatus === true):?>
            <li class="nav-item">
                <a class="nav-link" href="add.php" style="color:green">Ajouter</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?disconnect=true" style="color:red">Déconnexion</a>
            </li>
            <?php endif;?>
            </ul>
        </div>
    </nav>