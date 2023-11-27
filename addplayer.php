<?php
include 'blocks/function.php';
$pdo = dbconnect();
session_start();


if(!array_key_exists("identifiant", $_SESSION)){
    header("Location: index.php");
}



$allowedExtension = ["image/jpeg","image/png"];
$errors = [];
if($_SERVER["REQUEST_METHOD"]=='POST'){
    $files_image = "image/".uniqid().'-'.$_FILES["image"]["name"];
    if(empty($_POST["nom"])){
        $errors["nom"] = "veuillez saisir un nom";
    }

    if($_FILES["image"]["error"]!= 0){
        $errors["image"]= "il y a une erreur";
    }
    if(in_array($_FILES['image']['type'],$allowedExtension)){
        if($_FILES["image"]["size"]> 2097152){
            $errors["image"]= "c'est trop gros";
        }
    }else{
        $errors["image"]= "le format est pas bon";
    }

    if(empty($_POST["prenom"])){
        $errors["prenom"] = "veuillez saisir un prénom";
    }

    if(empty($_POST["age"])){
        $errors["age"] = "veuillez saisir une date de naissance";
    }
    if(!empty($_POST["age"])){
        $dateOfBirth = DateTime::createFromFormat('Y-m-d', $_POST['age']);
        $dateToday = new DateTime();
        $agePlayer = $dateToday->diff($dateOfBirth)->y;
        if ($agePlayer < 18 || $agePlayer > 45) {
            $errors["age"] = "Veuillez saisir un joueur ayant l'âge légal (entre 18 et 45 ans).";
        }
    }else{
        $errors["age"] = "Saisissez une date ! ";
    }

    if(count($errors) == 0){
        move_uploaded_file($_FILES["image"]["tmp_name"],$files_image);

        $req = $pdo->prepare("INSERT INTO players (name,firstname,date_of_birth,post_id,image)
            VALUES (:name, :firstname, :date_of_birth, :post_id, :image)");
        $req-> execute(["name"=>$_POST["nom"],
            "firstname"=>$_POST["prenom"],
            "date_of_birth"=>$_POST["age"],
            "post_id"=>$_POST["poste"],
            "image"=>$files_image
        ]);
    }
}

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

<div class="container">
    <div class="row justify-content-center">
        <h1 class="text-center">form</h1>
        <div class="w-25">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" value="<?php displayForValue("nom")?>" class="form-control <?php displayValidationBootstrapClass($errors,"nom") ?>">
                    <?php displayFormError("nom",$errors)?>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image"  class="form-control <?php displayValidationBootstrapClass($errors,"image") ?>">
                    <?php displayFormError("image",$errors)?>
                </div>
                <div class="form-group">
                    <label for="prenom">Prenom</label>
                    <input type="text" name="prenom" value="<?php displayForValue("prenom")?>" class="form-control <?php displayValidationBootstrapClass($errors,"prenom") ?>">
                    <?php displayFormError("prenom",$errors)?>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="date" name="age" value="<?php displayForValue("age")?>" class="form-control <?php displayValidationBootstrapClass($errors,"age") ?>">
                    <?php displayFormError("age",$errors)?>
                </div>
                <div class="form-group">
                    <label for="poste">Poste</label>
                    <select  name="poste" class="form-select">
                        <option></option>
                        <?php
                        $req = $pdo->query("SELECT * FROM postes");
                        $resultats = $req->fetchAll();
                        foreach($resultats as $result){
                            $actif = '';
                            if($_SERVER["REQUEST_METHOD"]=='POST' && $_POST["poste"] == $result['id']){
                                $actif = 'selected';
                            }
                            echo('<option '.$actif.' value="'.$result["id"].'">'.$result["poste_name"].'</option>');
                        }
                        ?>
                </div>
                <input type="submit" class="btn btn-success">
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>