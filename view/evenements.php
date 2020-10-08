<?php 
	$nompage="Evènements";
	$indexation=true;

	ob_start();
?>
		<section id="lesevenements" class="misevaleur">	
				<div class="contenu">
					<h2 class="titre">Nos évènements</h2>
					<?php
					require('visual/displayErrors.php');
					?>
					<div class="flex">
						<?php 
							foreach($dataContent as $data){
								echo "<a href=\"index.php?page=spectacle&id=".$data->id."\"><img src=\"images/events/".$data->affiche."\" alt=\"affiche ".$data->id."\" title=\"affiche ".$data->nom."\"><span>".$data->nom."</span></a>";
							}
						?>
					</div>
				</div>			
		</section>
<?php 
	$contenu = ob_get_clean();
	require($basePagePath);
?>