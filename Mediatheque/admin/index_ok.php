<?php
//header("Content-Type:text/html;   charset=UTF-8");
include('config.inc.php');
//database_connect();
function checkinput($name,$pwd)
{
    $result = mysql_query("select * from admin where name='".$name."'");
   $nombre=intval(mysql_num_rows($result));
	if($nombre==0)
	{
		echo "<script language='javascript'>alert('Il n existe pas!');history.back();</script>";
		exit;
	}
	else
	{
		$result1 = mysql_query("select * from admin where name='".$name."'");
		$row = mysql_fetch_array($result1);
		$dpwd=$row["pwd"];
		
		if($dpwd==$pwd){
				session_start();
				$_SESSION['id']=$row["id"];
				$_SESSION['name']=$row["name"];
				$date=date("Y-m-d H:i:s");
				$result2=mysql_query("update admin set lastdate='".$date."' where id=".$_SESSION['id'].";");
	 			 	echo "<script language='javascript'>window.location.href='admin_main.php';</script>";
		}
		else
		{
			echo "<script language='javascript'>alert('Le mot de passe que vous avez entrés ne correspondent pas à ceux présents dans nos fichiers. Veuillez vérifier et réessayer.!');history.back();</script>";
			exit;
		}
	}
}
checkinput(trim($_POST['username']),md5(trim($_POST['pwd'])));
?>