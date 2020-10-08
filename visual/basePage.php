<?php require('visual/docFunctions.php');?>
<!DOCTYPE html>
<html lang="fr">
<?php getHead($nompage, $indexation); ?>
<body>
    <?php 
    getNavigation();
    echo $contenu;
    getFooter();
    ?>
    <script src="javascript/jquery-3.4.1.js"></script>
    <script src="javascript/myscript.js"></script>
</body>
</html>