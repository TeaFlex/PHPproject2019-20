<?php 
	$nompage="Inscription";
	$indexation=true;

	ob_start();
?>
    <?php
    if(!isset($_SESSION['id'])){
    ?>
        <div class="misevaleur" id="inscription">
            <div class="contenu">
                <form action="controller/controllerForms.php" method="post">
                    <label for="nom">Nom*:</label>
                    <input type="text" name="nom">
                    <label for="prenom">Prénom*:</label>
                    <input type="text" name="prenom">
                    <label for="email">Adresse E-mail*:</label>
                    <input type="email" name="email">
                    <label for="">Adresse:</label>
                    <input type="text" name="adresse">
                    <label for="mdp">Mot de passe*:</label>
                    <input type="password" name="mdp">
                    <label for="">Répétition du mot de passe*:</label>
                    <input type="password" name="mdpbis">
                    <input type="submit" value="S'inscrire" name="inscription">
                </form>
                <p>Les champs avec * sont obligatoires.</p>
                <?php 
                require('visual/displayErrors.php');
                ?>
            </div>
        </div>
        <?php } ?>
<?php 
	$contenu = ob_get_clean();
	require($basePagePath);
?>