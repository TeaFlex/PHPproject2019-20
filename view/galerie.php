<?php 
	$nompage="Galerie";
	$indexation=true;

	ob_start();
?>
	   <section id="galerie" class="misevaleur">		
				<div class="contenu">
					<h2 class="titre">Les photos</h2>
					<div class="flex">
						<?php 
							foreach(scandir("images/gallery") as $key => $photo){
								list($name, $ext)=explode(".",$photo);
								if($ext == "png" || $ext == "jpg"){
									echo "<a title=\"photo impro ",$key-1,"\"href=\"images/gallery/",$photo,"\" target=\"_blank\" class=\"galerie\"><img src=\"images/gallery/",$photo,"\" alt=\"",$name,"\"></a>";
								}
							}
						?>
					</div>
				</div>
	   </section>
<?php 
	$contenu = ob_get_clean();
	require($basePagePath);
?>