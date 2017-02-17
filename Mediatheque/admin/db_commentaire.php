<?php 
    include('config.inc.php');
    checkLogin();
$action=$_GET['action'];
if($action=='del')
{
	$id=trim($_GET['id']);
	mysql_query("delete from commentaire where idC=".$id.";");
	echo "<script language='javascript'>alert('Supprimer reussi!');location.href='commentaire.php';</script>";
}
else
{}
?>