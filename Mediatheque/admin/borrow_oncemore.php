<?php
session_start();
include("config.inc.php");
$email=$_GET[email];
$idEmprunt=$_GET[IDE];
$dateEmprunt=$_GET[DateEmprunt];
$prolonger=mysql_query("select valeur from systeme where id ='3'");
$dateProlongation=date("Y-m-d",strtotime($dateEmprunt.'+ 7 days'));        //prolonger
mysql_query("update emprunt set DateEmprunt='$dateProlongation',Prolongation='0' where IDE=$idEmprunt");
echo "<script language='javascript'>alert('Prolongation reussi！');window.location.href='bookRenew.php?email=$email';</script>";
?>