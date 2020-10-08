<?php
    class Spectacle{
        public $id;
        public $nom;
        public $date;
        public $lieux;
        public $resume;
        public $affiche;
        public $est_complet;
        public $nbplace;

        function __construct($id, $nom, $date, $lieux, $resume, $affiche, $est_complet, $nbplace){
            $this->id=$id;
            $this->nom=$nom;
            $this->date=$date;
            $this->lieux=$lieux;
            $this->resume=$resume;
            $this->affiche=$affiche;
            $this->est_complet=$est_complet;
            $this->nbplace=$nbplace;
        }
    }

    class Profil{
        public $id;
        public $nom;
        public $prenom;
        public $email;
        public $adresse;
        public $status;

        function __construct($id, $nom, $prenom, $email, $adresse, $status){
            $this->id=$id;
            $this->nom=$nom;
            $this->prenom=$prenom;
            $this->email=$email;
            $this->adresse=$adresse;
            $this->status=$status;
        }
    }

    class Commande{
        public $id;
        public $spectacle;
        public $date;
        public $idcompte;
        public $emailcompte;

        function __construct($id, $spectacle, $date, $idcompte="none", $emailcompte="none"){
            $this->id=$id;
            $this->spectacle=$spectacle;
            $this->date=$date;
            $this->idcompte=$idcompte;
            $this->emailcompte=$emailcompte;
        }
    }
?>