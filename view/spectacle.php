<?php 
	$nompage="Spectacle";
	$indexation=false;

	ob_start();
	if(isset($_GET['id']) && !empty($_GET['id'] && !empty($dataContent))){
?>
		<?php
		if(isset($_GET['id'])){
		?>
		<section id="spectacle" class="misevaleur">	
				<div class="contenu">
					<?php  
						$data = $dataContent[0];
					?>
					<h2 class="titre">Spectacle "<?= $data->nom?>" <?= $data->est_complet ? "-COMPLET-" : "" ?></h2>
					<div class="flex">
						<figure>
							<?= "<img src=\"images/events/$data->affiche\" alt=\"affiche\">"?>
						</figure>
						<ul>
							<li>
								Nombre de place: <?= $data->nbplace?> places.
							</li>
							<li>
								Date: <?= "Le ".date("d/m/Y à H:i", strtotime($data->date))?>
							</li>
							<li>
								Lieu: <?= $data->lieux?>
							</li>
							<li>
								Résumé: <?= $data->resume?>
							</li>
						</ul>
					</div>
					<?php
					if(!$data->est_complet){
					?>
					<form action="controller/controllerForms.php" method="post">
						<label for="nbplace">Nombre de place à réserver:</label>
						<select name="nbplace" id="nbplace">
							<?php for($i=1; $i<=5; $i++) echo "<option value=\"$i\">$i</option>";?>
						</select>
						<?php $_SESSION['spectacle']=$_GET['id']?>
						<input type="submit" value="Réserver" name="commande">
					</form>			
					<?php
					}
					else { 
					?>
					<p>Désolé, le spectacle est complet !</p>
					<?php
					} 
					?>
				</div>			
		</section>
		<?php } ?>
<?php 
	}
	$contenu = ob_get_clean();
	require($basePagePath);
?>