<?php
    //===========================================================================================
    //Ce fichier permet de contrôler les entrées lors des connexions/inscriptions des utilisateurs
    //===========================================================================================


    // CODE METIER===============================================================================
    session_start();
    require('../models/sqlAccess.php');
    require('../models/dataClasses/sqlData.php');
    $bd = new SqlAccess();
    $bd->open_connection();

    //conditions d'inscription
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['inscription'])){
        $required = array('nom','prenom','email','mdp','mdpbis');
        $errors = array();
        foreach($required as $index) if(empty($_POST[$index])) $errors[]=$index;
        if(!empty($errors)){
            redirect('inscription', "emptyparts");
            //TODO: changer le message d'erreur et ne pas afficher le nom des champs, juste colorer leur contour en rouge.
        }
        else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            redirect('inscription', "bademail");
        }
        else if($bd->check_email(strtolower($_POST['email']))){
            redirect('inscription', "existingemail");
        }
        else if($_POST['mdp']!=$_POST['mdpbis']){
            redirect('inscription', "badcheck");
        }
        else if(strlen($_POST['mdp'])<7){
            redirect('inscription', "badpassword");
        }
        else if(strlen($_POST['nom'])>20 || strlen($_POST['prenom'])>20){
            redirect('inscription', "toolong");
        }
        else if(strlen($_POST['adresse'])>35) redirect("inscription", "toolong");
        //TODO: vérifier que le nombre de caractère ne dépasse pas un certain nombre
        else{
            $_POST['email'] = strtolower($_POST['email']);
            $correct_data = array();
            foreach($_POST as $data) $correct_data[]=test_input($data);
            try{
                $bd->inscription($correct_data[0], $correct_data[1],$correct_data[2],$correct_data[3],$correct_data[4]);
                redirect('connexion');
            }
            catch(Exception $e){
                redirect('erreur','sqlerror');
            }
        }
    }

    //conditions de connexion
    else if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['connexion'])){
        if(empty($_POST['email']) || empty($_POST['mdp'])){
            redirect('connexion',"emptyparts");
        }
        else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            redirect('connexion',"bademail");
        }
        else if($bd->check_identity(strtolower($_POST['email']), $_POST['mdp'])){ 
            refresh_session($infos = $bd->get_user_infos_email(strtolower($_POST['email'])));
            header('Location: ../index.php?page=accueil');
        }
        else{
            redirect('connexion',"checkfailed");
        }
    }

    //conditions pour les réservations
    else if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['commande'])){
        $int_value = ctype_digit($_POST['nbplace']) ? intval($_POST['nbplace']) : null;

        if(empty($_POST['nbplace']) || $int_value == null){
            redirect('evenements', 'canceled');
        }

        else if(!isset($_SESSION['id'])) redirect('evenements', 'unconnected');

        else if(isset($_SESSION['id']) && !$bd->does_user_exist($_SESSION['id'])) redirect('evenements', 'dontexist');

        else if(($bd->count_orders_user($_SESSION['id'], $_SESSION['spectacle']) + $int_value) > 5) 
            redirectmsg('Vous ne pouvez pas commander plus de 5 places au total par spectacle. Vous avez déjà commandé '.$bd->count_orders_user($_SESSION['id'], $_SESSION['spectacle']).' places.');
        
        else if($int_value+$bd->get_order_quantity($_SESSION['spectacle']) > $bd->get_spectacle_seats($_SESSION['spectacle']))
            redirectmsg("Il ne reste que ".($bd->get_spectacle_seats($_SESSION['spectacle'])-$bd->get_order_quantity($_SESSION['spectacle']))." place(s). Veuillez commander une autre quantité de places.");

        else{
            for($i=1; $i<=$int_value; $i++){
                $bd->add_order_spectacle($_SESSION['id'], $_SESSION['spectacle']);     
            }        
            redirectmsg("Vous avez réservé $int_value places."); 
        }
    }

    //conditions pour le changement d'informations
    else if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['changerinfos'])){

        if(isset($_SESSION['id']) && !$bd->does_user_exist($_SESSION['id'])) redirect('profil', 'dontexist');

        else if(isset($_POST['nom']) || isset($_POST['prenom'])){
            $input = isset($_POST['prenom']) ? $_POST['prenom'] : $_POST['nom'];
            if(empty($input)) redirect("profil", "emptyparts");
    
            else if(strlen($input)>20) redirect("profil", "toolong");

            else if($input==$_SESSION[isset($_POST['prenom']) ? 'prenom' : 'nom']) redirect("profil", "same");

            else{
                $input=test_input($input);
                if(isset($_POST['nom'])) $bd->change_user_infos($_SESSION['id'], null, $input);
                else $bd->change_user_infos($_SESSION['id'], $input);
            }
        }
        else if(isset($_POST['email'])){
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) redirect('connexion',"bademail");

            else if(strtolower($_POST['email'])==$_SESSION['email']) redirect("profil", "same");

            else if($bd->check_email(strtolower($_POST['email']))) redirect("profil", "existingemail");

            else{
                $bd->change_user_infos($_SESSION['id'], null, null, test_input($_POST['email']));
            }
        }
        else if(isset($_POST['adresse'])){
            if(empty($_POST['adresse'])) redirect("profil", "emptyparts");

            else if(strlen($_POST['adresse'])>35) redirect("profil", "toolong");

            else if($_POST['adresse']==$_SESSION['adresse']) redirect("profil", "same");

            else $bd->change_user_infos($_SESSION['id'], null, null, null, test_input($_POST['adresse']));    
        }
        refresh_session($bd->get_user_infos_id($_SESSION['id']));
        redirectmsg("Vous avez changé vos informations avec succès !");
    }

    //conditions pour le changement de mot de passe
    else if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['changermdp'])){

        if(isset($_SESSION['id']) && !$bd->does_user_exist($_SESSION['id'])) redirect('profil', 'dontexist');

        else if(empty($_POST['ancientmdp']) || empty($_POST['newmdp']) || empty($_POST['newmdpbis'])) redirect("profil", "emptyparts");

        else if($_POST['newmdp']!=$_POST['newmdpbis']) redirect('profil', "badcheck");

        else if(strlen($_POST['newmdp'])<7) redirect("profil", "newbadpassword");

        else if(!$bd->check_identity(strtolower($_SESSION['email']), $_POST['ancientmdp'])) redirect("profil", "checkfailed");

        else $bd->change_user_password($_SESSION['id'], test_input($_POST['newmdp']));
        redirectmsg("Vous avez changé votre mot de passe avec succès !");
    }

    else if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['supprimer'])){
        if(isset($_SESSION['id']) && $bd->does_user_exist($_SESSION['id'])) $bd->delete_user($_SESSION['id']);
        header("Location: ../disconnect.php");
        exit();
    }

    $bd->close_connection();


    // FONCTIONS ===========================================================================================

    function test_input($inputdata){// Permet de prévenir toute injection de code===========================
        $inputdata = trim($inputdata);
        $inputdata = stripcslashes($inputdata);
        $inputdata = htmlspecialchars($inputdata);
        return $inputdata;
    }

    function redirect($page, $error="none"){ 
        header(($error=='none')?"Location: ../index.php?page=".$page:"Location: ../index.php?page=".$page."&error=".$error);
        exit();
    }

    function redirectmsg($msg){
        header("Location: ../index.php?page=message&msg=$msg");
        exit();
    }

    function disconnect(){
        header("Location: ../disconnect.php");
        exit();
    }

    function refresh_session($infos){
        $_SESSION['id']=$infos->id;
        $_SESSION['nom']=$infos->nom;
        $_SESSION['prenom']=$infos->prenom;
        $_SESSION['email']=$infos->email;
        $_SESSION['adresse']=$infos->adresse;
        $_SESSION['status']=$infos->status;
    }
?>