<?php 
	$nompage="Erreur";
	$indexation=false;

	ob_start();
?>
    <div class="misevaleur">
        <div class="contenu">
            <?=$errormsg?>
        </div>
    </div>
<?php 
	$contenu = ob_get_clean();
	require($basePagePath);
?>