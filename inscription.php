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
    <main id="main_inscription">

        <h1>Inscription : </h1>

        <section class="section_form">
            <form method="post" class="form_edit" action="inscription.php">

                <label for="identifiant">Identifiant</label>
                <input type="text" id="identifiant" name="identifiant" placeholder="login" required>

                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="*******" required>

                <label for="confirmation_mdp">Confirmation du mot de passe</label> 
                <input type="password" id="confirmation_password" name="confirmation_mdp" placeholder="*******" required>

                <input type="submit" class="submit_margintop" id="submit_inscription" name="register">

            </form>
        </section>
        <div class="alerte">
        <?php 

$bdd = mysqli_connect('localhost', 'root', '', 'livreor');// je me connecte a ma bdd

if (isset($_POST['register'])){

    $identifiant = ($_POST['identifiant']);
    $password =($_POST['password']);
    $confirm_password =($_POST['confirmation_mdp']);
    $error_log = 'Veuillez réessayer ! Login ou mot de passe incorrect.';

    // mysqli_query($bdd,$requete);
    if( $confirm_password == $password && !empty($identifiant) && !empty($password)){
        echo("confirm password");

        $identifiant_secured = mysqli_real_escape_string($bdd, trim($identifiant)); // on enleve les espace, les \n -> string et caractere non affichable 
        $password_secured = mysqli_real_escape_string($bdd, trim($password)); // htmlspecialchars ça sert a rien pour la bdd
        $confirm_password_secured = mysqli_real_escape_string($bdd, trim($confirm_password));

        $cryptedpass = password_hash($password_secured, PASSWORD_BCRYPT); // variable qui récupere la valeur crypté de $password
        

        $verification = mysqli_query($bdd, "SELECT login FROM utilisateurs WHERE login = '$identifiant_secured'"); // on recherche si l'identifiant existe déjà 
        
        if(mysqli_num_rows($verification)) {
            echo("verification");

            echo("L identifiant \"". $identifiant_secured . "\" est déjà utilisé, veuillez en choisir un autre :-)"); // s'il existe déjà on l'affiche
        }
        
        elseif ($_POST['register'] == true){ // sinon si register est true et que verification est false alors on effectue la requete d'enregistrement d'inscription et on switch de page

            $requete = "INSERT INTO utilisateurs (login, password) VALUES('$identifiant_secured','$cryptedpass')"; // je créer $requete qui va faire l'action d'inserer des infos dans la bdd
            mysqli_query($bdd,$requete);
            header('Location: connexion.php');
            exit();
        }

    }
    else{
        echo $error_log;
        echo("errorlog");
    }

}
$nbr_ligne = mysqli_num_rows(mysqli_query($bdd,"SELECT * FROM utilisateurs")); // si la bdd est vide alors on propose au visiteur de devenir le premier membre
        if($nbr_ligne == 0){// si y'a rien 
            $nbr_ligne = 1;// on reinitialise les id à 1
            mysqli_query($bdd,"ALTER TABLE utilisateurs AUTO_INCREMENT = 1");
            echo ("Inscrivez vous et devenez notre <strong>" . $nbr_ligne . "er membre</strong>!");
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


</html>