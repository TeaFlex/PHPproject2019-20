<?php 
	$nompage="Profil";
	$indexation=false;

    ob_start();
    if(isset($_SESSION['id'])){
?>
    <div class="misevaleur" id="profil">

        <section id="informations">
            <div class="contenu">
                <h2 class="titre">Vos informations</h2>
                <?php 
                    require('visual/displayErrors.php');
                ?>
                <div class="flex">
                    <form action="controller/controllerForms.php" method="post">
                        <label for="nom">Nom:</label>
                        <input type="text" name="nom" value=<?=$_SESSION['nom']?>>
                        <input type="submit" value="Changer" name="changerinfos">
                    </form>
                    <form action="controller/controllerForms.php" method="post">
                        <label for="prenom">Prénom:</label>
                        <input type="text" name="prenom" value=<?=$_SESSION['prenom']?>>
                        <input type="submit" value="Changer" name="changerinfos">
                    </form>
                    <form action="controller/controllerForms.php" method="post">
                        <label for="email">Adresse E-mail:</label>
                        <input type="email" name="email" value=<?=$_SESSION['email']?>>
                        <input type="submit" value="Changer" name="changerinfos">
                    </form>
                    <form action="controller/controllerForms.php" method="post">
                        <label for="">Adresse:</label>
                        <input type="text" name="adresse" value=<?=$_SESSION['adresse']?>>
                        <input type="submit" value="Changer" name="changerinfos">
                    </form>

                    <form action="controller/controllerForms.php" method="post">
                        <label for="mdp">Ancien mot de passe:</label>
                        <input type="password" name="ancientmdp">
                        <label for="mdp">Nouveau mot de passe:</label>
                        <input type="password" name="newmdp">
                        <label for="">Répétition du nouveau mot de passe:</label>
                        <input type="password" name="newmdpbis">
                        <input type="submit" value="Changer" name="changermdp">
                    </form>
                </div>
            </div>
        </section>

        <section id="commandes">
            <div class="contenu">
                <h2 class="titre">Vos réservations</h2>
                <div class="flex">
                    <div class="scrolltable">
                        <table>
                            <tr>
                                <th>ID réservation</th>
                                <th>Spectacle</th>
                                <th>Date de la réservation</th>
                            </tr>

                            <?php
                            foreach($dataContent as $data){
                                echo "<tr><td>".$data->id."</td><td>".$data->spectacle."</td><td>".$data->date."</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section id="divers">
            <div class="contenu">
                <h2 class="titre">Divers</h2>
                <div class="flex">
                    <form action="controller/controllerForms.php" method="post">
                        <input type="submit" value="Supprimer mon compte" name="supprimer">
                    </form>
                </div>
            </div>
        </section>
        
        
           
    </div>
<?php 
    }
    else{
    }
	$contenu = ob_get_clean();
	require($basePagePath);
?>