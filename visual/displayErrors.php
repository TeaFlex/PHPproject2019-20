<?php 
    if(isset($_GET['error'])){
        $display_error="Aucune.";
        switch ($_GET['error']){
            case "bademail":
                $display_error = "Veuillez rentrer une adresse e-mail valide.";
            break;
            case "badpassword":
                $display_error = "Le mot de passe doit contenir au moins 7 caractères.";
            break;
            case "newbadpassword":
                $display_error = "Le nouveau mot de passe doit contenir au moins 7 caractères.";
            break;
            case "emptyparts":
                $display_error = "Des champs n'ont pas été complétés.";
            break;
            case "badcheck":
                $display_error = "Les deux mots de passe entrés ne correspondent pas.";
            break;
            case "existingemail":
                $display_error = "Cet e-mail est déjà utilisé.";
            break;
            case "toolong":
                $display_error = "Le nom et le prénom ne peuvent pas dépasser 20 caractères et l'adresse 35 caractères.";
            break;
            case "toolongspec":
                $display_error = "Le nom et le lieu ne peuvent pas dépasser 30 caractères et le résumé 255 caractères.";
            break;
            case "same":
                $display_error = "Les nouvelles informations sont identiques avec les anciennes.";
            break;
            case "verifyfailed":
                $display_error = "Le mot de passe entré ne correspond pas à celui du compte.";
            break;
            case "checkfailed":
                $display_error = "Le mot de passe ou l'email est incorrect.";
            break;
            case "canceled":
                $display_error = "Opération annulée.";
            break;
            case "unconnected":
                $display_error = "Vous devez être connecté(e) pour réserver des places.";
            break;
            case "dontexist":
                $display_error = "Ce compte n'existe pas.";
            break;
            case "ordernotfound":
                $display_error = "La commande entrée n'a pas été trouvée.";
            break;
            case "spectaclenotfound":
                $display_error = "Le spectacle entré n'a pas été trouvé";
            break;
            case "deladmin":
                $display_error = "Vous ne pouvez pas supprimer un admin via le site. Passez directement par la base de données.";
            break;
            case "noadmin":
                $display_error = "Opération annulée: vous n'êtes pas administrateur.";
            break;
            case "wrongtype":
                $display_error = "Les fichiers acceptés sont les jpg et les png.";
            break;
            case "toobig":
                $display_error = "Le fichier est trop volumineux.";
            break;
            case "fileexist":
                $display_error = "Un fichier de ce nom existe déjà.";
            break;
            case "baddate":
                $display_error = "Le format de la date n'est pas correct.";
            break;
            default:
                $display_error = $_GET['error'];
            break;
        }
        echo "<span>Erreur: ".$display_error."</span>";
    }
?>