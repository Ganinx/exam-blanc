<?php
include 'blocks/function.php';
$pdo = dbconnect();
session_start();




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
    if(empty($_POST["pv"])){
        $errors["pv"] = "veuillez saisir un nombre de pv";
    }elseif(!is_numeric($_POST["pv"])){
        $errors["pv"]= 'veuillez saisir un nombre entier';
    }elseif($_POST["pv"] <= 0 || $_POST["pv"] > 200 ){
        $errors["pv"]= 'pas bon nombre';
    }

    if(empty($_POST["attaque"])){
        $errors["attaque"] = "veuillez saisir un nombre de pv";
    }elseif(!is_numeric($_POST["attaque"])){
        $errors["attaque"]= 'veuillez saisir un nombre entier';
    }elseif($_POST["attaque"] <= 0 || $_POST["attaque"] > 200 ){
        $errors["attaque"]= 'pas bon nombre';
    }

    if(empty($_POST["defense"])){
        $errors["defense"] = "veuillez saisir un nombre de pv";
    }elseif(!is_numeric($_POST["defense"])){
        $errors["defense"]= 'veuillez saisir un nombre entier';
    }elseif($_POST["defense"] <= 0 || $_POST["defense"] > 200 ){
        $errors["defense"]= 'pas bon nombre';
    }

    if(empty($_POST["vitesse"])){
        $errors["vitess"] = "veuillez saisir un nombre de pv";
    }elseif(!is_numeric($_POST["vitesse"])){
        $errors["vitesse"]= 'veuillez saisir un nombre entier';
    }elseif($_POST["vitesse"] <= 0 || $_POST["vitesse"] > 200 ){
        $errors["vitesse"]= 'pas bon nombre';
    }

    if(empty($_POST["special"])){
        $errors["special"] = "veuillez saisir un nombre de pv";
    }elseif(!is_numeric($_POST["special"])){
        $errors["special"]= 'veuillez saisir un nombre entier';
    }elseif($_POST["special"] <= 0 || $_POST["special"] > 200 ){
        $errors["special"]= 'pas bon nombre';
    }
    if(count($errors) == 0){
        move_uploaded_file($_FILES["image"]["tmp_name"],$files_image);

        $req = $pdo->prepare("INSERT INTO pokemon (image,nom,pv,attaque,defense,vitesse,special,type_id)
            VALUES (:image, :nom, :pv, :attaque, :defense, :vitesse, :special, :type_id)");
        $req-> execute(["image"=>$files_image,
            "nom"=>$_POST["nom"],
            "pv"=>$_POST["pv"],
            "attaque"=>$_POST["attaque"],
            "defense"=>$_POST["defense"],
            "vitesse"=>$_POST["vitesse"],
            "special"=>$_POST["special"],
            "type_id"=>$_POST["type"]
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
                    <label for="pv">Prenom</label>
                    <input type="text" name="prenom" value="<?php displayForValue("pv")?>" class="form-control <?php displayValidationBootstrapClass($errors,"pv") ?>">
                    <?php displayFormError("pv",$errors)?>
                </div>
                <div class="form-group">
                    <label for="attaque">Age</label>
                    <input type="number" name="age" value="<?php displayForValue("attaque")?>" class="form-control <?php displayValidationBootstrapClass($errors,"attaque") ?>">
                    <?php displayFormError("attaque",$errors)?>
                </div>
                <div class="form-group">
                    <label for="type">Poste</label>
                    <select  name="type" class="form-select">
                        <option></option>
                        <?php
                        $req = $pdo->query("SELECT * FROM types");
                        $resultats = $req->fetchAll();
                        foreach($resultats as $result){
                            $actif = '';
                            if($_SERVER["REQUEST_METHOD"]=='POST' && $_POST["type"] == $result['id']){
                                $actif = 'selected';
                            }
                            echo('<option '.$actif.' value="'.$result["id"].'">'.$result["name"].'</option>');
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