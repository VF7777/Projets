<!doctype html PUBLIC "-//W3C//DTD html 4.01 Transitional//FR" >
<html>
<head>
<title>MEDIATHEQUE</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />


</head>
<?php 
include("config.inc.php");
function replacestr($str_)
{
	$str_ = addcslashes($str_,"'\"");
	return $str_;
}

$action=$_GET['action'];
if($action=='add')
{
	session_start();
	$title=$_POST['title'];
	$author=$_POST['author'];
	$content=replacestr($_POST['content']);
	$date=date("Y-m-d H:i:s");

	$image = $_FILES['image']['name'];
	$size = $_FILES['image']['size'];
	$type = $_FILES['image']['type'];
	
//RENOMMER le fichier par un chiffre aleatoire, pour Éviter les doublons sur les noms de fichiers
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return $sec;
}


$a = array("   ",".");

	$tf=str_replace($a,"",microtime_float()).".".substr($image,-3);   

//le repertoire pour sauvegarder des fichiers
$dest_image = "/Applications/MAMP/htdocs/Mediatheque/images/" . $tf;
$dest_image2 = "/Mediatheque/images/" . $tf;

//verifier le format et la taille de fichier, il y a 5 types, et la taille de fichier est strictment inferieur a 1àM
	if (($type == "image/gif" || $type == "image/png" || $type == "image/pjpeg" || $type == "image/jpg" || $type == "image/jpeg") && $size < 10240000) {
   if (true==move_uploaded_file($_FILES['image']['tmp_name'], $dest_image)) {
		//si le fichier est mise a jour dans le repertoire, on va connecter la base de donnee et l'ajoute dans la table

	 $colums="insert into article(publish,title,author,content,image,date,updatedate) ";
	 $value=" values('NO','".$title."','".$author."','".$content."','".$dest_image2."','".$date."','".$date."');";

	 mysql_query($colums.$value);
	 echo "<script language='javascript'>alert('add reussi!');location.href='afficheArticle.php';</script>";

	 set_time_limit(30); // Fixe le temps maximum d'exécution
    }
	else 
	{
        $tf = "";
		echo "Ajout échoué！！"."<br />";
	}
} 
else 
{
    echo "format de photo ne permet que gif/png/jpg/jpeg,et la taille de fichier est strictment inferieur a 5M."."<br />";
}	
}
else if($action=='del')
{
	$id=trim($_GET['id']);
	mysql_query("delete from article where idA=".$id.";");
	echo "<script language='javascript'>alert('supprime reussi!');location.href='afficheArticle.php';</script>";
}
else if($action=='publish')
{
	$id=trim($_GET['id']);
	mysql_query("update article set publish='YES' where idA=".$id.";");
	echo "<script language='javascript'>alert('publié réussi!');location.href='afficheArticle.php';</script>";
}
else if($action=='unpublish')
{
	$id=trim($_GET['id']);
	mysql_query("update article set publish='NO' where idA=".$id.";");
	echo "<script language='javascript'>alert('annulé publié!');location.href='afficheArticle.php';</script>";
}
else if($action=='updateArticle')
{

	$id=trim($_GET['id']);
	
	$title=$_POST['title'];
	$author=$_POST['author'];
	$date=date("Y-m-d H:i:s");
	$newContent=replacestr($_POST['content']);
	$content=str_replace("\n","<br />",$newContent);
//	Pour afficher ligne par ligne



$image = $_FILES['image']['name'];
	$size = $_FILES['image']['size'];
	$type = $_FILES['image']['type'];

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return $sec;
}
//fonction pour RENOMMER le fichier par un chiffre aleatoire, pour Éviter les doublons sur les noms de fichiers
$a = array("   ",".");

	$tf=str_replace($a,"",microtime_float()).".".substr($image,-3);   

//le repertoire pour sauvegarder des fichiers
$dest_image = "/Applications/MAMP/htdocs/Mediatheque/images/" . $tf;
$dest_image2 = "/Mediatheque/images/" . $tf;

//vérifier le format et la taille de fichier, il y a 5 types, et la taille de fichier est strictment inferieur à 5M
	if (($type == "image/gif" || $type == "image/png" || $type == "image/pjpeg" || $type == "image/jpg" || $type == "image/jpeg") && $size < 5120000) {
   if (true==move_uploaded_file($_FILES['image']['tmp_name'], $dest_image)) {
		//si le fichier est mise a jour dans le repertoire, on va connecter la base de donnee et l'ajoute dans la table


	
	$value="title='".$title."',author='".$author."',content='".$content."',image='".$dest_image2."',updatedate='".$date."',publish='NO'";
	mysql_query("update article set ".$value." where idA=".$id);
	echo "<script language='javascript'>alert('mettre à jour réussi!');location.href='afficheArticle.php';</script>";

	 set_time_limit(30);// Fixe le temps maximum d'exécution
    }
	else 
	{
        $tf = "";
		echo "Mettre à jour échoué！"."<br />";
	}
} 
else 
{
    echo "format de photo ne permet que gif/png/jpg/jpeg,et la taille de fichier est strictment inferieur a 5M."."<br />";
}
}
else
{}
?>
</html>