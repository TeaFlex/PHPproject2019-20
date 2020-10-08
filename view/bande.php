<?php 
	$nompage="La Bande";
	$indexation=true;

	ob_start();
?>
<section id="histoirebap" class="misevaleur">
		<div class="contenu">
			<h2 class="titre">La bande... Toute une histoire !</h2>
				

			<p>La bande à p'Art est un groupe d'improvisateurs fondé en 2008 et basé à Dour avec de multiples branches partant dans les quatres coins de la région de Mons. 
			Notre but est de vous aider à vous ouvrir que ce soit de manière théâtrale ou même socialement, tout cela en compagnie de joyeux lurons prêts à vous accueillir à bras ouverts ! 
			Nous organisons et participons à des spectacles, des rencontres entre équipes, des rassemblement culturels et pleins d'autres choses en relation avec le monde de la comédie, 
			émerveillant petits et grands sur notre passage. Que ce soit adultes, enfants ou ados, nous planifions des coachings pour tout le monde (plus d'informations 
			<a href="index.php?page=lieux">ici</a>), alors il n'y a plus de raisons de rester à "p'art", devenez acteur plutôt que spectateur et rejoignez la Bande à p'Art !</p>
					
			<div class="flex">
				<a href="images/articles/imageimpro9.jpg" target="_blank" title="La bande">
					<img src="images/articles/imageimpro9.jpg" alt="La Bande à p'Art" class="cadre">
				</a>
			</div>
		</div>
</section>

<?php 
	$contenu = ob_get_clean();
	require($basePagePath);
?>