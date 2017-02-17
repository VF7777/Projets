<?php
    include('config.inc.php');
    checkLogin();

    for($i=1; $i<5; $i++)
    {
    	$valeur = $_POST[''.$i];
    	mysql_query("update systeme set valeur='".$valeur."' where id=".$i);
    }
    echo "<script language='javascript'>alert('Modifier reussi!');location.href='systeme.php';</script>";
?>