<?php 
	$nompage="Contacts";
	$indexation=false;
	
	ob_start();
?>
		<section id="infocontact" class="misevaleur">

				<div class="contenu">
					<h2 class="titre">Nous contacter...</h2>		     
					<ul>	
						<?php
							foreach($dataContent as $data){
								echo "<li>",$data['nom']," ",$data['prenom']," (coach ",$data['equipe'],"):<img src=\"images/icons/phone.png\" alt=\"telephone\" class=\"icone\">",$data['telephone'];
								if($data['email']!='none')
									echo "<img src=\"images/icons/mail.png\" alt=\"email\" class=\"icone\"><a href=\"",$data['email'],"\">",$data['email'],"</a></li>";
							} 
						?>			     	    
					</ul>
					<div class="flex">
						<a href="https://twitter.com/LaBandeap?s=17" target="_blank" title="Twitter" class="res"><img src="images/icons/twitter.png" alt="logo twitter" class="reseaux"></a>
						<a href="https://www.facebook.com/La-bande-à-pArt-160190010712778/" target="_blank" title="Facebook" class="res"><img src="images/icons/fb.png" alt="logo facebook" class="reseaux"></a>
						<a href="https://www.youtube.com/channel/UCx8NmokoP4QsUeuUTpfF0nQ" target="_blank" title="Youtube" class="res"><img src="images/icons/yt.png" alt="logo youtube" class="reseaux"></a>
					</div>
				</div>
		</section>

<?php 
	$contenu = ob_get_clean();
	require($basePagePath);
?>