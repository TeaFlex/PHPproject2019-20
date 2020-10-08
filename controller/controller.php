<?php
    //Ce fichier contient le code de la partie controller du site

    //Appel des parties models
    require('models/sqlAccess.php');
    require('models/jsonAccess.php');
    require('models/dataClasses/sqlData.php');
    
    //Affiche les vues, prend en paramètre des données de contenu ou un message d'erreur
    function get_view($view='accueil', $dataContent=null, $errormsg=null){
        $basePagePath='visual/basePage.php';
        require('view/'.$view.'.php');
    }

    //Affiche les vues nécéssitant des données provenant d'une DB SQL
    function get_sqldata_view($view, $option=null){
        $sql = new SqlAccess();
        $sql->open_connection();
        $dataContent=null;
        switch($view){
            case "modification":
            case "spectacle":
                if($sql->does_spectacle_exist($option))
                    $dataContent = (empty($option))? $sql->get_spectacle_infos() : $sql->get_spectacle_infos($option);
            break;
            case "evenements":
                $dataContent = (empty($option))? $sql->get_spectacle_infos() : $sql->get_spectacle_infos($option);
            break;
            case "profil":
                if(isset($_SESSION['id'])) $dataContent = $sql->get_orders_user($_SESSION['id']);
            break;
            case "administration":
                if(isset($_SESSION['status']) && $_SESSION['status']=='admin'){
                    $dataContent = array();
                    $dataContent[] = $sql->get_users();
                    $dataContent[] = $sql->get_orders();
                    $dataContent[] = $sql->get_spectacles();
                }
            break;
        }
        get_view($view, $dataContent);
        $sql->close_connection();
    }

    //Affiche les vues nécéssitant des données provenant d'un fichier JSON
    function get_jsondata_view($view){
        $json = new JsonAccess();
        get_view($view, $json->read_json($view));
    }


?>