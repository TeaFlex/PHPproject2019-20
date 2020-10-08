<?php 
	$nompage="Lieux";
	$indexation=true;

	ob_start();
?>
        <div class="misevaleur"  id="infolieux">

		<div class="flex" id="selection">
			<?php 
				//production des boutons de navigation
				foreach($dataContent as $data){
					echo "<a href=\"#",$data['equipe'],"\">",$data['equipe'],"</a>";
				}	
			?>
		</div>
		
		<?php 
			//production des sections pour chaques équipes
			foreach($dataContent as $data){
		?>

		<?= "<section id=\"",$data['equipe'],"\">"; ?>
			<div class="contenu">
				<?= "<h2 class=\"titre\">",$data['equipe']." (".$data['ville'].") ","</h2>"; ?>	
				<div class="flex">
					<?= "<iframe src=\"https://www.google.com/maps/",$data['urlmap'],"\" width=\"600\" height=\"450\" frameborder=\"0\" style=\"\" allowfullscreen class=\"cadre\" ></iframe>"?> 
					<p><?= $data['description']; ?></p> 
					<ul>
						<li>Horaire: <?= $data['horaire']; ?></li>
						<li>Adresse: <?= $data['adresse'] ?></li>
					</ul>
				</div>
			</div>
		</section>

		<?php
			}
		?>
		</div>
<?php 
	$contenu = ob_get_clean();
	require($basePagePath);
?>