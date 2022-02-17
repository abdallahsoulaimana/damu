<?php
    try {
        //$db = new PDO('mysql:host=sql-server.k8s-2ixmbeyn;dbname=bd1; charset=utf8', 'abdallah', 'A46531H');
        $db = new PDO('mysql:host=localhost;dbname=gest_sang; charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);//Les noms des champs seront en caractères minuscules
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Les erreurs lanceront des exceptions
    } catch (Exception $e) {
    
        echo 'une erreur est survenue';
        die();
    
    }

?>