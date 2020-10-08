<?php 
	$nompage="Administration";
	$indexation=false;

    ob_start();
    if($_SESSION['status']=="admin"){
?>

<?php 
    $dataUsers = $dataContent[0];
    $dataOrders = $dataContent[1];
    $dataSpect = $dataContent[2];
?>
<div class="misevaleur" id="administration">
    <?php require('visual/displayErrors.php'); ?>
    <section id="Comptes">
        <div class="contenu">
            <h2 class="titre">Comptes</h2>
            <div class="flex">
                <div class="scrolltable">
                    <table>
                        <tr>
                            <th>ID du compte</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>E-mail</th>
                            <th>Adresse</th>
                            <th>Statut</th>
                        </tr>
                        <?php
                        foreach($dataUsers as $data)
                            echo "<tr><td>$data->id</td><td>$data->nom</td><td>$data->prenom</td>
                            <td>$data->email</td><td>$data->adresse</td><td>$data->status</td></tr>";        
                        ?>
                    </table>
                </div>
                <form action="controller/controllerFormsAdmin.php" method="post">
                <label for="idcompte">Supprimer le compte n°:</label>
                    <input type="text" name="idcompte">
                    <input type="submit" value="Supprimer" name="supp">
                </form>
            </div>
        </div>
    </section>

    <section id="Reservations">
        <div class="contenu">
            <h2 class="titre">Réservations</h2>
            <div class="flex">
                <div class="scrolltable">
                    <table>
                        <tr>
                            <th>ID de réservation</th>
                            <th>Nom du spectacle</th>
                            <th>Date de réservation</th>
                            <th>ID du compte</th>
                            <th>Email du compte</th>
                        </tr>
                        <?php
                        foreach($dataOrders as $data)
                            echo "<tr><td>$data->id</td><td>$data->spectacle</td><td>$data->date</td>
                            <td>$data->idcompte</td><td>$data->emailcompte</td></tr>";        
                        ?>
                    </table>
                </div>
                <form action="controller/controllerFormsAdmin.php" method="post">
                    <label for="idcommande">Supprimer réservation n°:</label>
                    <input type="text" name="idcommande">
                    <input type="submit" value="Supprimer" name="supp">
                </form>
            </div>
        </div>
    </section>

    <section id="Spectacles">
        <div class="contenu">
            <h2 class="titre">Spectacles</h2>
            <div class="flex">
                <div class="scrolltable">
                    <table>
                        <tr>
                            <th>ID du spectacle</th>
                            <th>Nom du spectacle</th>
                            <th>Date du spectacle</th>
                            <th>Lieu</th>
                            <th>Résumé</th>
                            <th>Affiche</th>
                            <th>Complet ?</th>
                        </tr>
                        <?php
                        foreach($dataSpect as $data)
                            echo "<tr><td>$data->id</td><td>$data->nom</td><td>$data->date</td>
                            <td>$data->lieux</td><td>$data->resume</td><td><img src=\"images/events/$data->affiche\"></td>
                            <td>".($data->est_complet ? "OUI": "NON")."</td>
                            <td><button onclick='window.location.replace(\"./index.php?page=modification&type=spectacle&id=".$data->id."\")'>Modifier</button></td></tr>";        
                        ?>
                    </table>
                </div>
            </div>
            <div class="flex">
                <form action="controller/controllerFormsAdmin.php" method="post">
                    <label for="idspectacle">Supprimer spectacle n°:</label>
                    <input type="text" name="idspectacle">
                    <input type="submit" value="Supprimer" name="supp">
                </form>

                <button type="button" value='test' onclick='window.location.replace("./index.php?page=ajout&type=spectacle")'>Ajouter</button>
                
            </div>

        </div>
    </section>
</div>

<?php 
    }
    $contenu = ob_get_clean();
	require($basePagePath);
?>