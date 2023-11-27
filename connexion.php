<?php
include 'blocks/function.php';
$pdo = dbconnect();
session_start();

$erreur = '';
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    var_dump($pdo);
    $query = $pdo -> prepare("SELECT * FROM admin WHERE username = :identifiant");
    $query -> execute(["identifiant" => $_POST["identifiant"]]);
    var_dump($query);
    $resultat_admin = $query->fetch();
    if ($_POST['identifiant'] == $resultat_admin["username"] && password_verify($_POST["password"], $resultat_admin["password"])) {
        $_SESSION['identifiant'] = $resultat_admin["username"];
        header('Location: index.php');
        exit();
    } else {
        $erreur = "identifiant invalide";
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


<form method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Identifiant</label>
        <input type="text" value="<?php
        if(!empty($_POST['identifiant'])){
            echo($_POST['identifiant']);
        }

        ?>" class="form-control" name="identifiant" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
        <div class="invalid-feedback">
            <?php
            if(!is_null($erreur)){
                echo('<p class="text-danger">'.$erreur.'</p>');
            }
            ?>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>