<?php 
	$nompage="Modification";
	$indexation=false;

    ob_start();
    if($_SESSION['status']=="admin" && isset($_GET['type']) && isset($_GET['id']) && !empty($_GET['id'] && !empty($dataContent))){
?>

<div class="misevaleur">
    <section>
        <div class="contenu">
            <h2 class="titre">Modifier un <?= $_GET['type']?></h2>
            <?php require('visual/displayErrors.php');
            $data = $dataContent[0];
            ?>
            <form action="controller/controllerFormsAdmin.php" method="post">
                <?php 
                $_SESSION['idspectacle'] = $_GET['id'];
                switch($_GET['type']){
                    case "spectacle":
                    ?>
                    <label for="nomspectacle">Nom du spectacle:</label>
                    <input type="text" name="nomspectacle" value="<?= $data->nom?>">
                    <label for="datespectacle">Date du spectacle:</label>
                    <input type="datetime-local" name="datespectacle" value="<?= date("Y-m-d\Th:i", strtotime($data->date))?>">
                    <label for="lieuspectacle">Lieu du spectacle:</label>
                    <input type="text" name="lieuspectacle" value="<?= $data->lieux?>">
                    <label for="resumespectacle">Résumé du spectacle:</label>
                    <textarea name="resumespectacle" cols="30" rows="10"><?= $data->resume?></textarea>
                    <label for="nbplspectacle">Places disponibles:</label>
                    <input type="number" name="nbplspectacle" min="10" max="400" value=<?= $data->nbplace?>>
                    <input type="submit" value="Modifier" name=<?="modifinfos".$_GET['type']?>>
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
            <?php 
                if($_GET['type'] == 'spectacle'){
            ?>
            <form action="controller/controllerFormsAdmin.php" method="post" enctype="multipart/form-data">
                <label for="affichespectacle">Affiche du spectacle:</label>
                <input type="file" name="affichespectacle">
                <input type="submit" value="Modifier" name=<?="modifimg".$_GET['type']?>>
            </form>
            <?php
                }
            ?>
        </div>
    </section>
</div>
<?php
    }
	$contenu = ob_get_clean(); 
    require($basePagePath);
?>