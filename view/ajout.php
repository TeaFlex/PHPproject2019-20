<?php 
	$nompage="Ajout";
	$indexation=false;

    ob_start();
    if($_SESSION['status']=="admin" && isset($_GET['type'])){
?>

<div class="misevaleur">
    <section>
        <div class="contenu">
            <h2 class="titre">Ajouter un <?= $_GET['type']?></h2>
            <?php require('visual/displayErrors.php'); ?>
            <form action="controller/controllerFormsAdmin.php" method="post" enctype="multipart/form-data">
                <?php 
                switch($_GET['type']){
                    case "spectacle":
                    ?>
                    <label for="nomspectacle">Nom du spectacle:</label>
                    <input type="text" name="nomspectacle">
                    <label for="datespectacle">Date du spectacle:</label>
                    <input type="datetime-local" name="datespectacle">
                    <label for="lieuspectacle">Lieu du spectacle:</label>
                    <input type="text" name="lieuspectacle">
                    <label for="affichespectacle">Affiche du spectacle:</label>
                    <input type="file" name="affichespectacle">
                    <label for="resumespectacle">Résumé du spectacle:</label>
                    <textarea name="resumespectacle" cols="30" rows="10"></textarea>
                    <label for="nbplspectacle">Places disponibles:</label>
                    <input type="number" name="nbplspectacle" min="10" max="400">
                    <input type="submit" value="Ajouter" name=<?="ajout".$_GET['type']?>>
                    <?php
                    break;
                    default:
                    ?>
                    <span>Il n'y a rien ici !</span>
                    <?php
                    break;
                }
                ?>
            </form>
        </div>
    </section>
</div>
<?php
    }
	$contenu = ob_get_clean(); 
    require($basePagePath);
?>