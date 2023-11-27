<?php
function dbconnect(){
    try {
        $host = 'localhost';
        $dbName = 'examblanc' ;
        $user = 'root';
        $password = '';
        $pdo = new PDO(
            'mysql:host='.$host.';dbname='.$dbName.';charset=utf8',
            $user,
            $password);
        // Cette ligne demandera à pdo de renvoyer les erreurs SQL si il y en a
        $pdo->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
    catch (PDOException $e) {
        throw new InvalidArgumentException('Erreur connexion à la base de
données : '.$e->getMessage());
        exit;
    }
}


function displayValidationBootstrapClass($errors, $inputName){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(array_key_exists($inputName, $errors)){
            echo('is-invalid');
        }else{
            echo('is-valid');
        }
    }
}

function displayForValue($inputname){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        echo($_POST[$inputname]);
    }
}

function displayFormError($inputname, $errors){
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(array_key_exists($inputname,$errors)){
            echo('<div class="invalid-feedback">'.$errors[$inputname].'</div>');
        }
    }
}
?>


