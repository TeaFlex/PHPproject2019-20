<?php 
    class JsonAccess{

        function read_json($name){//permet de lire un fichier json============================================================================
            $path = 'data/json/'.$name.'.json';
            try{
                $jsondata = json_decode(file_get_contents($path), true);
            }
            catch(Exception $e){
                die('Erreur : ' . $e->getMessage());
            }
            return $jsondata;
        }
    }
?>