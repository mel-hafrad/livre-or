<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'Or</title>
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
    <main>
        <section class="block_container">
                <section class="section_commentaire">
<?php
$bdd = mysqli_connect('localhost', 'root', '', 'livreor');// je me connecte a ma bdd
$sql_recuperation = "SELECT u.login, c.date, c.commentaire FROM utilisateurs AS u 
INNER JOIN commentaires AS c WHERE c.id_utilisateur = u.id ORDER BY c.date DESC";// je récupère les données qui m'interesse
$sql_result = mysqli_query($bdd,$sql_recuperation);

while($commentaire_display = mysqli_fetch_assoc($sql_result)){//je les imprime depuis un tableau 
    echo "<table style=' border-collapse: collapse';><tr><th class='th_pseudo'>". htmlspecialchars($commentaire_display['login'])
     . "</th></tr><tr><td class='td_date'>" . htmlspecialchars($commentaire_display['date'])
      . "</td><td class='td_commentaire'>" . htmlspecialchars($commentaire_display['commentaire']) . "</td></tr></table>";
}

?>
            </section>
        </section>
    </main>

    <?php



    if (isset($_SESSION['isconnected']) && $_SESSION['isconnected'] === true) {
        echo "<footer>";
        echo "<p> Bonjour " . $_SESSION['utilisateur'] . "</p>";
        echo " <form method='post' action=''>";
        echo " <input type='submit' name='disconnect' value='déconnexion'>";
        echo " </form>";
        echo '</footer>';
        if (isset($_POST['disconnect'])) {
            session_destroy();
            header("Location: livre-or.php");
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