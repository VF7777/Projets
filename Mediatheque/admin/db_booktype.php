<?php 
    include('config.inc.php');
    checkLogin();
$action=$_GET['action'];
if($action=='add')
{
	$nom=$_POST['nom'];
	$type=$_POST['type1'];
	mysql_query("insert into ressourcetype(TYPE1,TYPE2)  values('".$type."','".$nom."')");
	echo "<script language='javascript'>alert('Ajouter reussi!');location.href='admin_ressourceType.php';</script>";
}
else if($action=='del')
{
	$id=trim($_GET['id']);
	mysql_query("delete from ressourcetype where IDT=".$id.";");
	echo "<script language='javascript'>alert('Supprimer reussi!');location.href='admin_ressourceType.php';</script>";
}
else if($action=='update')
{
	$id=trim($_GET['id']);
	$nom=$_POST['nom'];
	mysql_query("update ressourcetype set TYPE2='$nom' where IDT='$id'");
	echo "<script language='javascript'>alert('Mettre à jour reussi!');location.href='admin_ressourceType.php';</script>";
}
else
{}
?>