<?php
session_start();
include("config.inc.php");
$DATERETOUR=date("Y-m-d");        //la date retour cet ressource
$ID=$_GET[IDE];

mysql_query("update emprunt, exemplaire set  emprunt.StatutE='Retour', exemplaire.Etat='1',emprunt.DateRetour='$DATERETOUR' , emprunt.DateEmprunt = null where emprunt.IDE='$ID' and exemplaire.IDEX=emprunt.IDEX");
echo "<script language='javascript'>alert('Ressource retour reussi！');window.location.href='bookBack.php?email=$email';</script>";

?>