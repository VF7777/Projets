<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=mediatheque;charset=utf8', 'root', 'Cheny1006');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


?>

