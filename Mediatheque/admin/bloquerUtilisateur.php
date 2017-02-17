<?php
session_start();
include("config.inc.php");
$id=$_GET[id];
mysql_query("update utilisateur set bloque='1' where IDU=$id");
echo "<script language='javascript'>alert('Bloquer utiisateur reussi！');window.location.href='admin_retourLimite.php';</script>";
?>