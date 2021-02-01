<?php
                session_start();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css">

</head>

<body>
<header>
        <ul id="menu-deroulant">
            <li><a href="index.php">Accueil</a></li>
            <?php
            if (isset($_SESSION['isconnected']) && $_SESSION['isconnected'] === true) {
                echo <<<HTML
            <li><a href="profil.php">Profil</a>
            <li><a href="commentaire.php">Commentaire</a></li>

            HTML;
            
            }
            ?>
            <li><a href="livre-or.php">Livre d'or</a></li>
        </ul>
    </header>
    <main id="main_connexion">
        <H1> Connexion : </H1>
        <section class="section_form">

        <form method="post" action="connexion.php" class="form_edit">

<label for="identifiant">Identifiant</label>
<input type="text" id="identifiant" name="identifiant" placeholder="login" required>

<label for="password">Mot de passe</label>
<input type="password" id="password" name="password" placeholder="**********" required>

<input type="submit" class="submit_margintop" id="submit_inscription" name="connect">

</form> 

        </section>
        <div class="alerte">
        <?php
        if (isset($_POST['connect'])) {
            //On récupère les valeurs entrées par l'utilisateur :
            $pseudo = $_POST['login'];
            $password = $_POST['password'];

            $db = mysqli_connect('localhost', 'root', '', 'livreor');
            $sql = "SELECT id FROM utilisateurs WHERE login = '$pseudo' AND password = '$password'";

            $query = mysqli_query($db, $sql);
            $all_result = mysqli_fetch_all($query);
            $compteur = count($all_result);
            if ($compteur == 1) {
                session_start();
                $_SESSION['isconnected'] = true;
                header("Location: index.php");
            } else {
                $_SESSION['isconnected'] = false;
                echo ' identifiant incorrect';
            }
        }
        ?>
        </div>
    </main>
        <footer>
        <ul id="menu-deroulant" class="foot">
            <li><a href="inscription.php">Inscription</a>
            <li><a href="connexion.php">Connexion</a>
        </ul>
        </footer> 
</body>

<?php

$bdd = mysqli_connect('localhost', 'root', '', 'livreor');// je me connecte a ma bdd

if (isset($_POST['connect'])){ // si on appuie sur envoyer
    $identifiant = ($_POST['identifiant']);
    $password = ($_POST['password']);
    $error_log = 'Veuillez réessayer ! Login ou mot de passe incorrect.';

    $identifiant = mysqli_real_escape_string($bdd, htmlspecialchars(trim($identifiant))); // on enleve les espace, les \n -> string et caractere non affichable 
    $password = mysqli_real_escape_string($bdd, htmlspecialchars(trim($password)));

    if(!empty($identifiant) && !empty($password)) {

    $verification = mysqli_query($bdd, "SELECT password FROM utilisateurs WHERE login = '$identifiant' "); 
    //on vérifie si l'identitfiant et le mdp correspondent à ceux de la bdd 
    $count = mysqli_num_rows($verification);
    
        if($count){
        $result = mysqli_fetch_assoc($verification);

        // echo("koa");
    //   echo $result['password'];
    //   echo $password;
      var_dump($password);
      echo password_verify($password, $result['password']);
        // var_dump(password_verify($password, $result['password']));

            if(password_verify($password, $result['password'])){
                
                $_SESSION['utilisateur'] = $identifiant;
                $_SESSION['isconnected'] = true;
                $utilisateur = $_SESSION['utilisateur']; 
                $sql_select = "SELECT id FROM utilisateurs WHERE login = '$utilisateur'";
                $query = mysqli_query($bdd, $sql_select);// $query prend le résultat de la requete id
                $all_result = mysqli_fetch_row($query);
                $id = $all_result[0]; // id = la case 0 du tableau fetch 
                $_SESSION['id_utilisateur'] = $id;
            
                header('Location: index.php');
            }
        }
    }
    else{       
         echo $error_log;
         $_SESSION['isconnected'] = false;
    }
}

?>
</html>