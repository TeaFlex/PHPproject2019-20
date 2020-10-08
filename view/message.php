<?php 
	$nompage="Message";
	$indexation=false;

	ob_start();
?>
    <div class="misevaleur">
        <div class="contenu">
            <?=isset($_GET['msg']) ? $_GET['msg'] : "Aucun message à afficher."?>
        </div>
    </div>
<?php 
	$contenu = ob_get_clean();
	require($basePagePath);
?>