<?php
session_start();
include("config.inc.php");

 if($_GET["action"]=="supprimer"){
$req = $bdd->prepare('delete from emprunt where IDE='.$_GET["ide"].'');
$req->execute();
$r = $bdd->prepare('update exemplaire set Etat=1 where IDEX='.$_GET["idex"].'');
$r->execute();
header("location: MonCompteControleur.php?action=emprunts");
 }
if ($_GET["action"]=="prolongation"){
$re= $bdd->prepare('update emprunt set Prolongation=0 where IDE='.$_GET["ide"].'');
$re->execute();
$new = date('Y-m-d', strtotime( $_GET['date']. ' + 7 day'));
//echo $new;
$re= $bdd->prepare('update emprunt set DateEmprunt="'.date('Y-m-d', strtotime( $_GET['date']. ' + 7 day')).'" where IDE='.$_GET["ide"].'');
$re->execute();
header("location: MonCompteControleur.php?action=emprunts");
}

?>