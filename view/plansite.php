<?php 
	$nompage="Plan du site";
	$indexation=false;

	ob_start();
?>

		<section id="plansite" class="misevaleur">
				<div class="contenu">
					<h2 class="titre">Le plan</h2>			     
					    <ul>
							 <?php 
								 foreach(scandir("view") as $file){
									 if($file != "." && $file != ".."){
										list($name, $ext) = explode(".", $file);
										echo "<li><a href=\"index.php?page=",$name,"\" title=\"",$name,"\">",ucfirst($name),"</a></li> \n";
									 }
								 }
							 ?>
				     	</ul>
				</div>
		</section>

<?php 
	$contenu = ob_get_clean();
	require($basePagePath);
?>