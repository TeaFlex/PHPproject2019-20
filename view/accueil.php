<?php 
	$nompage="Accueil";
	$indexation=true;

	ob_start();
?>
<div class="misevaleur">
		<section id="introsite">	
			<h1>Improviser des histoires sans limites...</h1>
		</section>

		<section id="improintro">
				<div class="contenu">
					<h2 class="titre">L'impro...Tout un spectacle !</h2>

					    <div class="flex">
					    	
							<a href="images/articles/imageimpro8.jpg" target="_blank" title="Jouteur"><img src="images/articles/imageimpro8.jpg" alt="Comédien au meilleur de ses performances" class="cadre"></a>

							<iframe width="800" height="480" src="https://www.youtube.com/embed/uSSkSnjDtZ8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="cadre"></iframe>
	                        
	                        
							<p>L'improvisation... Une discipline millénaire se basant sur la réthorique, le jeu de scène et
							la bonne humeur pour divertir petits et grands est désormais à portée de main ! 
							Notre équipe "La bande à p'Art" pratique cette merveille depuis plus de 10 ans, improvisant des émotions comme aucune autre troupe. Que ce soit la joie, la tristesse ou
							la détresse en passant par la paresse, nous nous efforçons à vous procurer des frissons à chacunes de nos
							improvisations ! Si vous n'êtes toujours pas familiarisés avec cette discipline, nous vous invitons à jeter 
							un coup d'oeil à la vidéo ci-dessus.</p>
							
						</div>
				</div>		
		</section>

		<section id="impropourtous">
			<div class="contenu">
				<h2 class="titre">Et c'est pour tout le monde ?</h2>

					<div class="flex">
						
						<iframe width="800" height="480" src="https://www.youtube.com/embed/BiadP1XovEc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="cadre"></iframe>

						<a href="images/articles/imageimpro2.jpg" target="_blank" title="Un match pas comme les autres...">
							<img src="images/articles/imageimpro2.jpg" alt="match impro ado" class="cadre">
						</a>
						<p>Mais bien évidemment ! Il n'y a pas d'âge pour commencer, la rencontre des générations est d'ailleurs
						maître-mot de notre troupe. Que vous ayez participé à mai 68 ou que vous soyez né hier, tout le monde peut commencer
						l'improvisation ! Nos différents groupes vous accueilleront à bras ouverts afin que vous puissiez vous épanouir
						en jouant avec nous, promis nous ne vous mangerons pas ! L'improvisation permet même d'acquérir une certaine confiance en soi,
						permettant ainsi d'affronter de nombreuses épreuves au quotidien tout en s'amusant.
						Pour plus de renseignements sur les différents groupes constituant La Bande à p'Art, vous pouvez visiter 
						<a href="index.php?page=lieux">cette page</a>.</p>					
				    </div>			
			</div>
		</section>		
</div>

<?php
	$contenu = ob_get_clean(); 
    require($basePagePath);
?>