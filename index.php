<?php
include 'blocks/function.php';
$pdo = dbconnect();
session_start();

$query = $pdo -> query("SELECT * FROM players JOIN postes ON postes.id = post_id");
$resultats = $query->fetchAll();

?>







<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Examen Blanc</title>
</head>
<body>
<?php include 'blocks/navbar.php'?>

<h1 class="text-center m-5">Liste des joueurs sélectionner actuellement</h1>
<div class="row justify-content-center">
<?php

foreach ($resultats as $result){
    echo('<div class="card pb-5" style="width: 20rem;">
  <img src="'.$result["image"].'" class="card-img-top" alt="photo de '.$result["name"].' '.$result["firstname"].'">
  <div class="card-body">
    <h5 class="card-title">'.$result["firstname"].' '.$result["name"].'</h5>
    <p class="card-text">Ocuppera le poste de '.$result["post_id"].'</p>
  </div>
</div>');
}

?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>