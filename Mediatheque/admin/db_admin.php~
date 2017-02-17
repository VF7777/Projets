<?php 
include('config.inc.php');

$action=$_GET['action'];
if($action=='add')
{
	$nom=trim($_POST['uid']);
	$result = mysql_query("select * from admin where name='".$nom."'");
    $in=intval(mysql_num_rows($result));
	if($in==0)
	{
		$pwd=md5(trim($_POST['pwd']));
		$colums="insert into admin(name,pwd) ";
		$value="values('".$nom."','".$pwd."');";	
		mysql_query($colums.$value);
		echo "<script language='javascript'>alert('Ajouter reussi!');location.href='administrateur.php';</script>";
	}
	else
	{
		echo "<script language='javascript'>alert('Ce nom administrateur déjà exists!');history.back();</script>";
	}
}
else if($action=='del')
{
	$id=trim($_GET['id']);
	mysql_query("delete from admin where id=".$id.";");
	echo "<script language='javascript'>alert('Supprimer reussi!');location.href='administrateur.php';</script>";
}
else if($action=='pwd')
{
   session_start();
	$id=$_SESSION['id'];
	$pwd=md5(trim($_POST['pwd1']));
	mysql_query("update admin set pwd='".$pwd."' where id=".$id);
	echo "<script language='javascript'>alert('Modifier reussi!');history.back();</script>";
}
else if($action=='repwd')
{
	$id=$_GET['id'];
	$pwd=md5('123456');
	mysql_query("update admin set pwd='".$pwd."' where id=".$id);
	echo "<script language='javascript'>alert('Modifier reussi!');history.back();</script>";
}

else
{}
?>