<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">

    <title>Commentaire</title>
</head>
<body>
<header>
        <ul id="menu-deroulant">
            <li><a href="index.php">Accueil</a></li>
            <?php
            if (isset($_SESSION['isconnected']) && $_SESSION['isconnected'] === true) {
                echo <<<HTML
            <li><a href="profil.php">Profil</a><li>
            <li><a href="commentaire.php">Commentaire</a></li>

            HTML;
            
            }
            ?>
            <li><a href="livre-or.php">Livre d'or</a></li>
        </ul>
    </header>
    <main>
        <section class="section_form_commentaire">
    <form action="" method="post" class="form_edit">
        <label for="commentaire">Commentaire</label>
        <textarea rows="15" cols="70" name="commentaire" id="text-commentaire" placeholder="Marquez ici vôtre commentaire :)"></textarea>
        <input type="submit" name="submit" value="Poster">
    </form>
        </section>
    <?php
    $bdd = mysqli_connect('localhost', 'root', '', 'livreor');// je me connecte a ma bdd

    // $submit = $_POST['submit'];
    // $submit = mysqli_real_escape_string($bdd,trim($submit));
    // if (isset($submit))
    if(isset($_POST['submit']))
    { //si on appuie sur envoyer, $_POST prend un nouveau prénom dans son tableau 

        $commentaire = $_POST['commentaire'];
        $commentaire = mysqli_real_escape_string($bdd,trim($commentaire));
        // $_SESSION['commentaire_id'] = $_SESSION['utilisateur'] . "<br />" . $_POST['commentaire']; // a = a+b 

        $today = date("Y-m-j H:i:s");  
        echo $_SESSION['id_utilisateur'];
    
        $sql_commentaire = "INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES('" . $commentaire . "', '" . intval($_SESSION['id_utilisateur'])."','". $today . "')";
        mysqli_query($bdd, $sql_commentaire);
        echo "Votre commentaire à bien été envoyé";
    }

  // bdd > id	commentaire	id_utilisateur	date
?>
    </main>
<?php



if (isset($_SESSION['isconnected']) && $_SESSION['isconnected'] === true) {
    echo "<footer>";
    echo "<p> Bonjour " . $_SESSION['utilisateur'] . "</p>";
    echo " <form method=post>";
    echo " <input type='submit' name='disconnect' value='déconnexion'>";
    echo " </form>";
    echo '</footer>';
    if (isset($_POST['disconnect'])) {
        session_destroy();
        header("Location: index.php");
    }
} else {
    echo <<<HTML
        <footer>
        <ul id="menu-deroulant" class="foot">
            <li><a href="inscription.php">Inscription</a>
            <li><a href="connexion.php">Connexion</a>
        </ul>
        </footer> 
    HTML;
}
?>
    
</body>
</html>