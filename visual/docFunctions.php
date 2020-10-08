<?php 
function getNavigation(){//permet d'afficher la barre de navigation==================================================================
?>
<main>			
<?php 
	$j=new JsonAccess();
	$jsondata = $j->read_json('navigation');
?>
	<a href="index.php?page=accueil" title="Accueil">
		<img src="images/icons/baplogo.png" id="logobap">
	</a>
	<nav id="navigation">
		<div id="lienbouton">
		<?php
			foreach($jsondata as $data){
				echo "<a href=\"index.php?page=",$data['pagepath'],"\" title=\"",$data['descriptionpage'],"\">".$data['nompage']."</a>";
			}
			if(isset($_SESSION['status']) && $_SESSION['status']=='admin') echo "<a href=\"index.php?page=administration\" title=\"Admin\">Administration</a>"; 
			if(isset($_SESSION['id'])){
				echo "<a href=\"index.php?page=profil\" title=\"Mon profil (".$_SESSION['email'].")\"><img src=\"images/icons/icone.svg\" id=\"iconeutilisateur\"></a>";
				echo "<a href=\"disconnect.php\" title=\"Se connecter\">Se déconnecter</a>";
			}
			else echo "<a href=\"index.php?page=connexion\" title=\"Se connecter\">Se connecter</a>";
		?>
		</div>
		<a id="hamburger">&#9776;</a>			
	</nav>
</main>

<?php
}

function getHead($name, $robot){//permet d'afficher la head=========================================================================
//on donne en paramètre le nom de la page et un paramètre booléen pour l'indexation
?>
<head>
<title>La bande à p'Art - <?=$name?></title>
<meta charset="utf-8">
<meta name="keywords" content="impro, improvisation, théâtre, spectacle, Dour, Centre culturel, Hornu, Boussu">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Site de la Bande à p'Art, troupe d'improvisation Douroise depuis plus de 10 ans.">
<meta name="author" content="Jeuniaux Nicolas">
<meta name="generator" content="Sublime Text, Paint, Krita, Visual Studio Code">
<link rel="stylesheet" type="text/css" href="style/style1.css">
<link rel="icon" href="images/icons/minibap.jpg">
<?php
	if($robot) echo "<meta name=\"robots\" content=\"index, follow\"></head>";
}
function getFooter(){//permet d'afficher le footer==================================================================================
?>

<footer class="infosdusite">
    <p>©Copyright 2020 by La Bande à p'Art - <a href="index.php?page=plansite">Plan du site</a></p>
</footer>
</html>

<?php
}
//==================================================================================================================================