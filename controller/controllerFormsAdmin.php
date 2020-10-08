<?php 
    require('controllerForms.php');
    $bd->open_connection();

    if(isset($_SESSION['status']) && $bd->is_user_admin($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['supp'])) {
            if(isset($_POST['idcompte'])) {
                if(!$bd->does_user_exist($_POST['idcompte'])) redirect("administration", "dontexist");
                
                else if($bd->get_user_infos_id($_POST['idcompte'])->status == "admin") redirect("administration", "deladmin"); 
                
                else $bd->delete_user($_POST['idcompte']);
            }

            else if(isset($_POST['idcommande'])) {
                if(!$bd->does_order_exist($_POST['idcommande'])) redirect("administration", "ordernotfound");

                else $bd->delete_order($_POST['idcommande']);
            }

            else if(isset($_POST['idspectacle'])) {
                if(!$bd->does_spectacle_exist($_POST['idspectacle'])) redirect("administration", "spectaclenotfound");

                else {           
                    unlink('../images/events/'.$bd->get_spectacle_infos($_POST['idspectacle'])[0]->affiche);
                    $bd->remove_spectacle($_POST['idspectacle']);
                }
            }

            redirectmsg("Opération réussie.");
        }

        else if(isset($_POST['modifinfosspectacle'])) {
            $page = 'modification&type=spectacle&id='.$_SESSION['idspectacle'];
            $int_value = ctype_digit($_POST['nbplspectacle']) ? intval($_POST['nbplspectacle']) : null;

            foreach($_POST as $input) if(empty($input)) redirect($page, "emptyparts");

            if(strlen($_POST['nomspectacle'])>30 || strlen($_POST['lieuspectacle'])>30 || strlen($_POST['resumespectacle']>255)) {
                redirect($page, "toolongspec");
            }
            else if($int_value > 400 || $int_value <10 || $int_value == null) {
                redirect($page, "canceled");
            }
            else {
                $date = date("Y/m/d H:i", strtotime($_POST['datespectacle']));
                $bd->modify_spectacle_infos($_SESSION['idspectacle'], test_input($_POST['nomspectacle']), test_input($date), test_input($_POST['lieuspectacle']), 
                test_input($_POST['resumespectacle']), test_input($_POST['nbplspectacle']));
                redirectmsg("Le spectacle a été modifié.");
            } 
        }

        else if(isset($_POST['modifimgspectacle'])) {
            $page = 'modification&type=spectacle&id='.$_SESSION['idspectacle'];
            $target_dir = "../images/events/";
            $target_file = $target_dir . basename($_FILES["affichespectacle"]["name"]);
            $valid = true;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["affichespectacle"]["tmp_name"]);

            $valid = ($check !== false) ? true : false;

            if (file_exists($target_file)) {
                redirect($page, "fileexist");
                $valid = false;
            }

            if ($_FILES["affichespectacle"]["size"] > 500000) {
                redirect($page, "toobig");
                $valid = false;
            }

            if (strlen($_FILES["affichespectacle"]["name"]) > 20) {
                $valid = false;
            }

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                redirect($page, "wrongtype");
                $valid = false;
            }

            if (!$valid) {
                redirectmsg("Une erreur est survenue, le fichier n'a pas été uploadé.");
            } 
            else {
                if (move_uploaded_file($_FILES["affichespectacle"]["tmp_name"], $target_file)) {
                    unlink('../images/events/'.$bd->get_spectacle_infos($_SESSION['idspectacle'])[0]->affiche);
                    $bd->modify_spectacle_image($_SESSION['idspectacle'], test_input(basename($_FILES["affichespectacle"]["name"])));
                    redirectmsg("L'affiche du spectacle a été modifiée.");
                } 
                else {
                    redirectmsg("Une erreur est survenue lors de l'upload du fichier.");
                }
            }
        }

        else if(isset($_POST['ajoutspectacle'])) {
            $page = 'ajout&type=spectacle';
            $int_value = ctype_digit($_POST['nbplspectacle']) ? intval($_POST['nbplspectacle']) : null;

            foreach($_POST as $input) if(empty($input)) redirect($page, "emptyparts");

            if(strlen($_POST['nomspectacle'])>30 || strlen($_POST['lieuspectacle'])>30 || strlen($_POST['resumespectacle']>255)) {
                redirect($page, "toolongspec");
            }
            else if($int_value > 400 || $int_value <10 || $int_value == null) {
                redirect($page, "canceled");
            }
            else {
                $target_dir = "../images/events/";
                $target_file = $target_dir . basename($_FILES["affichespectacle"]["name"]);
                $valid = true;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                $check = getimagesize($_FILES["affichespectacle"]["tmp_name"]);

                $valid = ($check !== false) ? true : false;

                if (file_exists($target_file)) {
                    redirect($page, "fileexist");
                    $valid = false;
                }

                if ($_FILES["affichespectacle"]["size"] > 500000) {
                    redirect($page, "toobig");
                    $valid = false;
                }

                if (strlen($_FILES["affichespectacle"]["name"]) > 20) {
                    $valid = false;
                }

                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    redirect($page, "wrongtype");
                    $valid = false;
                }

                if (!$valid) {
                    redirectmsg("Une erreur est survenue, le fichier n'a pas été uploadé.");
                } 
                else {
                    if (move_uploaded_file($_FILES["affichespectacle"]["tmp_name"], $target_file)) {
                        $date = date("Y/m/d H:i", strtotime($_POST['datespectacle']));
                        $bd->add_spectacle(test_input($_POST['nomspectacle']), test_input($date), test_input($_POST['lieuspectacle']), 
                        test_input(basename($_FILES["affichespectacle"]["name"])), test_input($_POST['resumespectacle']), test_input($_POST['nbplspectacle']));
                        redirectmsg("Le spectacle a été ajouté.");
                    } 
                    else {
                        redirectmsg("Une erreur est survenue lors de l'upload du fichier.");
                    }
                }
            }          
        }
    }
    else {
        $_SESSION['status'] = 'none';
        redirect("profil", "noadmin");
    }

    $bd->close_connection();

    function validateDate($date, $format = 'd-m-Y'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
?>