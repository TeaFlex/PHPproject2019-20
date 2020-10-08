<?php
    //===================================================================
    //Ce fichier permet de gérer les interactions avec la base de données
    //===================================================================  
 
    Class SqlAccess{
        private $server;
        private $user;
        private $secret;
        private $data_base;

        function __construct(){
            $this->server = "putipaddresshere";//need to modify here
            $this->user = "putuserhere";//here too
            $this->secret = "putpasswordhere";//haha also here
            $this->data_base = null;
        }

        //instancie une nouvelle connexion à la BD
        function open_connection(){
            $this->data_base = new PDO('mysql:host='.$this->server.';dbname=bapsite;charset=utf8', $this->user, $this->secret);
        }

        //termine la connexion à la BD
        function close_connection(){
            $this->data_base = null;
        }

        //Ajoute une ligne à la table compte
        function inscription($firstName, $lastName, $eMail, $address, $password){
            if($address=="") $address="none";
            $request = $this->data_base->prepare('INSERT into compte (nom, prenom, email, adresse, status, hashmdp) VALUES (:nom, :prenom, :email, :adresse, :status, :hashmdp)');
            $request->bindValue(':nom', $lastName, PDO::PARAM_STR);
            $request->bindValue(':prenom', $firstName, PDO::PARAM_STR);
            $request->bindValue(':email', $eMail, PDO::PARAM_STR);
            $request->bindValue(':adresse', $address, PDO::PARAM_STR);
            $request->bindValue(':status', 'none', PDO::PARAM_STR);
            $request->bindValue(':hashmdp', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        //Vérifie si les infos d'un compte sont dans la BD
        function check_identity($eMail, $password){
            $request = $this->data_base->prepare('SELECT email, hashmdp FROM compte WHERE email=:email');
            $request->bindValue(':email', $eMail, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                if($eMail==$result->email && password_verify($password,$result->hashmdp)){
                    $request->closeCursor();
                    return true;
                }
            }
            $request->closeCursor();
            return false;
        }

        //Vérifie si l'email reçu en paramètre est déjà dans la BD
        function check_email($eMail){
            $request = $this->data_base->prepare('SELECT email FROM compte');
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                if($eMail==$result->email){
                    $request->closeCursor();
                    return true;
                }
            }
            $request->closeCursor();
            return false;
        }
        //===========================================================================================================================================
        //=====================================================Manipulation de la table compte=======================================================
        //===========================================================================================================================================

        //Permet d'obtenir la table user sans le hashmdp
        function get_users(){
            $results=array();
            $request = $this->data_base->prepare('SELECT idcompte, nom, prenom, email, adresse, status FROM compte');
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                $results[] = new Profil($result->idcompte, $result->nom, $result->prenom, $result->email, $result->adresse, $result->status);
            }
            $request->closeCursor();
            return $results;
        }

        //Permet d'obtenir les informations d'un utilisateur à l'aide de id utilisateur
        function get_user_infos_id($id){
            $results=null;
            $request = $this->data_base->prepare('SELECT idcompte, nom, prenom, email, adresse, status FROM compte where idcompte=:idcompte');
            $request->bindValue(':idcompte', $id, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                $results = new Profil($result->idcompte, $result->nom, $result->prenom, $result->email, $result->adresse, $result->status);
            }
            $request->closeCursor();
            return $results;
        }

        //Permet d'obtenir les informations d'un utilisateur à l'aide de son adresse email
        function get_user_infos_email($eMail){
            $results=null;
            $request = $this->data_base->prepare('SELECT idcompte, nom, prenom, email, adresse, status FROM compte where email=:email');
            $request->bindValue(':email', $eMail, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                $results = new Profil($result->idcompte, $result->nom, $result->prenom, $result->email, $result->adresse, $result->status);
            }
            $request->closeCursor();
            return $results;
        }

        //Permet de changer les informations d'un utilisateur
        function change_user_infos($iduser, $firstName=null, $lastName=null, $eMail=null, $address=null){
            $firstName = isset($firstName) ? $firstName : $_SESSION['prenom'];
            $lastName = isset($lastName) ? $lastName : $_SESSION['nom'];
            $eMail = isset($eMail) ? $eMail : $_SESSION['email'];
            $address = isset($address) ? $address : $_SESSION['adresse'];

            $request = $this->data_base->prepare('UPDATE compte SET nom=:nom, prenom=:prenom, email=:email, adresse=:adresse WHERE idcompte=:idcompte');
            $request->bindValue(':nom', $lastName, PDO::PARAM_STR);
            $request->bindValue(':prenom', $firstName, PDO::PARAM_STR);
            $request->bindValue(':email', $eMail, PDO::PARAM_STR);
            $request->bindValue(':adresse', $address, PDO::PARAM_STR);
            $request->bindValue(':idcompte', $iduser, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        //Permet le changement de mot de passe d'un utilisateur
        function change_user_password($iduser, $newpassword){
            $request = $this->data_base->prepare('UPDATE compte SET hashmdp=:hashmdp WHERE idcompte=:idcompte');
            $request->bindValue(':idcompte', $iduser, PDO::PARAM_STR);
            $request->bindValue(':hashmdp', password_hash($newpassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        //Supprime un utilisateur selon son id
        function delete_user($iduser){
            $this->delete_order_user($iduser);
            $request = $this->data_base->prepare('DELETE FROM compte WHERE idcompte=:idcompte');
            $request->bindValue(':idcompte', $iduser, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        //Vérifie si un utilisateur existe
        function does_user_exist($iduser){
            $request = $this->data_base->prepare('SELECT COUNT(*) AS nb FROM compte where idcompte=:idcompte');
            $request->bindValue(':idcompte', $iduser, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            $result = $request->fetch();
            $request->closeCursor();
            return $result->nb==0 ? false : true;
        }
        
        function is_user_admin($iduser){
            $request = $this->data_base->prepare('SELECT status FROM compte where idcompte=:idcompte');
            $request->bindValue(':idcompte', $iduser, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            $result = $request->fetch();
            $request->closeCursor();
            return $result->status=="admin" ? true : false;
        }

        //===========================================================================================================================================
        //=====================================================Manipulation de la table spectacle====================================================
        //===========================================================================================================================================


        function get_spectacles(){
            return $this->get_spectacle_infos();
        }

        function add_spectacle($name, $date, $place, $image, $summary, $sits) {
            $request = $this->data_base->prepare('INSERT INTO spectacle (nomspectacle, datespectacle, lieuxspectacle, affiche, resumespectacle, nbplaces)
                                                VALUES (:nomspectacle, :datespectacle, :lieuxspectacle, :affiche, :resumespectacle, :nbplaces)');
            $request->bindValue(':nomspectacle', $name, PDO::PARAM_STR);
            $request->bindValue(':datespectacle', $date, PDO::PARAM_STR);
            $request->bindValue(':lieuxspectacle', $place, PDO::PARAM_STR);
            $request->bindValue(':affiche', $image, PDO::PARAM_STR);
            $request->bindValue(':resumespectacle', $summary, PDO::PARAM_STR);
            $request->bindValue(':nbplaces', $sits, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        //Renvoie les données d'un ou plusieurs spectacle
        function get_spectacle_infos($spectacleid='none'){
            $results=array();
            if($spectacleid=='none'){
                $request = $this->data_base->prepare('SELECT idspectacle, nomspectacle, datespectacle, lieuxspectacle, resumespectacle, affiche, nbplaces from spectacle');
            }
            else{
                $request = $this->data_base->prepare('SELECT idspectacle, nomspectacle, datespectacle, lieuxspectacle, resumespectacle, affiche, nbplaces from spectacle where idspectacle=:idspec');
                $request->bindValue(':idspec', $spectacleid, PDO::PARAM_STR);
            } 
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                $results[]=new Spectacle($result->idspectacle, $result->nomspectacle, $result->datespectacle, 
                $result->lieuxspectacle, $result->resumespectacle, $result->affiche, $this->is_spectacle_full($result->idspectacle), $result->nbplaces);
            }
            $request->closeCursor();
            return $results;
        }

        function is_spectacle_full($idspec){
            $request = $this->data_base->prepare('SELECT nbplaces FROM spectacle WHERE idspectacle=:idspectacle');
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                $results=$result->nbplaces;
            }
            $request->closeCursor();
            return ($results<=$this->get_order_quantity($idspec)) ? true : false;
        }

        function get_spectacle_seats($idspec){
            $request = $this->data_base->prepare('SELECT nbplaces FROM spectacle WHERE idspectacle=:idspectacle');
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                $results=$result->nbplaces;
            }
            $request->closeCursor();
            return $results;
        }

        function remove_spectacle($idspec){
            $this->remove_order_spectacle($idspec);
            $request = $this->data_base->prepare('DELETE from spectacle WHERE idspectacle=:idspectacle');
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        function modify_spectacle_infos($idspec, $name, $date, $place, $summary, $sits) {
            $request = $this->data_base->prepare('UPDATE spectacle SET nomspectacle=:nomspectacle, datespectacle=:datespectacle, 
                                                lieuxspectacle=:lieuxspectacle, resumespectacle=:resumespectacle, nbplaces=:nbplaces
                                                WHERE idspectacle=:idspectacle');
            $request->bindValue(':nomspectacle', $name, PDO::PARAM_STR);
            $request->bindValue(':datespectacle', $date, PDO::PARAM_STR);
            $request->bindValue(':lieuxspectacle', $place, PDO::PARAM_STR);
            $request->bindValue(':resumespectacle', $summary, PDO::PARAM_STR);
            $request->bindValue(':nbplaces', $sits, PDO::PARAM_STR);
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        function modify_spectacle_image($idspec, $image) {
            $request = $this->data_base->prepare('UPDATE spectacle SET affiche=:affiche WHERE idspectacle=:idspectacle');
            $request->bindValue(':affiche', $image, PDO::PARAM_STR);
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        function does_spectacle_exist($idspec){
            $request = $this->data_base->prepare('SELECT COUNT(*) AS nb FROM spectacle where idspectacle=:idspectacle');
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            $result = $request->fetch();
            $request->closeCursor();
            return $result->nb==0 ? false : true;
        }

        //===========================================================================================================================================
        //=====================================================Manipulation de la table commande=====================================================
        //===========================================================================================================================================

        function get_orders(){
            $results=array();
            $request = $this->data_base->prepare('SELECT co.idcommande, co.idcompte ,c.email , s.nomspectacle ,co.datecommande 
                                                FROM commande co, compte c, spectacle s
                                                WHERE co.idcompte = c.idcompte
                                                AND s.idspectacle = co.idspectacle
                                                ORDER BY co.idcommande');
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                $results[] = new Commande($result->idcommande, $result->nomspectacle, $result->datecommande, $result->idcompte, $result->email);
            }
            $request->closeCursor();
            return $results;
        }

        function get_order_quantity($idspec){
            $results = 0;
            $request = $this->data_base->prepare('SELECT COUNT(*) AS nb FROM commande WHERE idspectacle=:idspectacle');
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                $results=$result->nb;
            }
            $request->closeCursor();
            return $results;
        }

        //Réserve un spectacle
        function add_order_spectacle($iduser, $idspec){
            $request = $this->data_base->prepare('INSERT into commande (idcompte, idspectacle) VALUES (:idcompte, :idspectacle)');
            $request->bindValue(':idcompte', $iduser, PDO::PARAM_STR);
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        function remove_order_spectacle($idspec){
            $request = $this->data_base->prepare('DELETE from commande WHERE idspectacle=:idspectacle');
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        function delete_order_user($iduser){
            $request = $this->data_base->prepare('DELETE from commande WHERE idcompte=:idcompte');
            $request->bindValue(':idcompte', $iduser, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        function delete_order($idorder){
            $request = $this->data_base->prepare('DELETE from commande WHERE idcommande=:idcommande');
            $request->bindValue(':idcommande', $idorder, PDO::PARAM_STR);
            $request->execute();
            $request->closeCursor();
        }

        //Renvoie toutes les réservations d'un utilisateur
        function get_orders_user($iduser){
            $results=array();
            $request = $this->data_base->prepare('SELECT c.idcommande, c.datecommande, s.nomspectacle
                                                FROM spectacle s, commande c, compte a
                                                WHERE c.idspectacle = s.idspectacle
                                                AND c.idcompte = a.idcompte
                                                AND a.idcompte = :id
                                                ORDER BY c.idcommande');
            $request->bindValue(':id', $_SESSION['id'], PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            while($result = $request->fetch()){
                $results[] = new Commande($result->idcommande, $result->nomspectacle, $result->datecommande);
            }
            $request->closeCursor();
            return $results;
        }

        function does_order_exist($idorder){
            $request = $this->data_base->prepare('SELECT COUNT(*) AS nb FROM commande where idcommande=:idcommande');
            $request->bindValue(':idcommande', $idorder, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            $result = $request->fetch();
            $request->closeCursor();
            return $result->nb==0 ? false : true;
        }

        function count_orders_user($iduser, $idspec) {
            $request = $this->data_base->prepare('SELECT COUNT(*) AS nb FROM commande where idcompte=:idcompte AND idspectacle=:idspectacle');
            $request->bindValue(':idcompte', $iduser, PDO::PARAM_STR);
            $request->bindValue(':idspectacle', $idspec, PDO::PARAM_STR);
            $request->execute();
            $request->setFetchMode(PDO::FETCH_OBJ);
            $result = $request->fetch();
            $request->closeCursor();
            return $result->nb;
        }
    }
?>