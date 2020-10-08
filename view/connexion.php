<?php 
	$nompage="Connexion";
	$indexation=false;

    ob_start();
    if(!isset($_SESSION['id'])){
?>  
    <div class="misevaleur" id="connexion">
        <div class="contenu">
            <h2 class="titre">Se connecter</h2>
            <form action="controller/controllerForms.php" method="post">
                <label for="email">E-mail:</label>
                <input type="email" name="email">
                <label for="mdp">Mot de passe:</label>
                <input type="password" name="mdp">
                <input type="submit" value="Se connecter" name="connexion">
            </form>
            <?php 
            require('visual/displayerrors.php');
            ?>
            <p>Pas encore de compte ? <a href="index?page=inscription">Créez en un !</a></p>
        </div>
    </div>
<?php 
    }
	$contenu = ob_get_clean();
	require($basePagePath);
?>