<?php
    include('config.inc.php');
/*    checkLogin();
    database_connect();*/
    
    $result = mysql_query("select * from ressource");
    $nombre=intval(mysql_num_rows($result));
?>
<!-- 				<?php	echo "<script language='javascript'>alert('Test！');</script>"; ?>-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestion d'administrateur</title>
<link href="css/style.css" rel="stylesheet" />
<script src="js/admin_js.js"></script>
</head>

<table width="780" height="450" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #9CBED6; margin-top:15px;">
	<tr>
		<td align="center" valign="top">
		
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#DDDDDD" align="center">
<tr bgcolor="#E7E7E7">
	<td height="28" colspan="8">
	<b>Gestion de Ressource-&gt;Afficher ressouces</b>
	</td>
</tr>
<tr align="center" bgcolor="#F0EEEE" height="22">
	<td>ID Ressource</td>
	<td>Titre</td>
	<td>Type</td>
	<td>Prix</td>
	<td>Emplacement</td>
	<td>Nombre</td>
	<td>Disponibilité</td>
	<td>Opération</td>
</tr>

<?php 
$i = 1;
$page = intval($_GET['page']);
$pageLink = 'book_admin.php';
if($page<1)$page = 1;
$pagenum = intval($nombre/10)+(($nombre%10)==0?0:1);
$result = mysql_query("select * from ressource order by IDR asc limit  ".(($page-1)*10).",10");
while($row=mysql_fetch_array($result))
{ 
    $id=$row[IDR];
	$query=mysql_query("select * from exemplaire where IDR=$id");
	$nombreR=intval(mysql_num_rows($query));
    
?>	
<tr align='center' height="22"   bgcolor="#FFFFFF" align="center">
	<td nowrap><?php echo $row['IDR'];?></td>
	<td align='left'>
		<span id="arc2">
			<a href="book_edit.php?action=consulter&id=<?php echo $row['IDR'];?>">
				<u><?php echo $row['Titre']?></u>
			</a>
		</span></td>
	
	<td><?php echo $row['Type'];?></td>
	<td><?php echo $row['Prix'];?></td>
	<td><?php echo $row['Emplacement'];?></td>
	<td><?php echo $nombreR;?></td>
<!--	decider cet ressource disponible ou pas-->
	<?php    
	$nouveauSql=mysql_query("select * from exemplaire where IDR=$id and Etat=1");  
	$query2=mysql_fetch_array($nouveauSql)
	    ?>
	<td><?php if($query2 ==null) { ?>
                         Non disponible
<?php }else {?>Disponible
<?php }?></td>
	
	<td>
	   <img src='images/add.png' title="Ajouter un ressource" alt="Ajouter un ressource" onclick="location='db_book.php?action=ajouterUn&id=<?php echo $row['IDR']?>';" style='cursor:pointer' border='0' width='16' height='16' />
		<img src='images/view.png' title="Consulter" alt="Consulter" onclick="location='book_edit.php?action=consulter&id=<?php echo $row['IDR']?>';" style='cursor:pointer' border='0' width='16' height='16' />
		<img src='images/edit.png' title="Rédiger" alt="Rédiger" onclick="location='book_edit.php?action=rediger&id=<?php echo $row['IDR']?>';"  style='cursor:pointer' border='0' width='16' height='16' />
		<img src='images/del.png' title="Supprimer" alt="Supprimer" onclick="location='db_book.php?action=supprimer&id=<?php echo $row['IDR']?>';"  style='cursor:pointer' border='0' width='16' height='16' />
	</td>
</tr>
<?php 
}
?>
<tr bgcolor="#EEF4EA">
	<td  bgcolor="#E7E7E7" height="24" colspan="8" align="center"  valign="middle">
    	<table>
    	      <tr>
    	          <td>共<?php echo $nombre; ?>条&nbsp;每页10条&nbsp;第<?php echo $page;?>页/共<?php echo $pagenum;?>页&nbsp;&nbsp;[<a href="<?php echo $pageLink;?>?page=1">第一页</a>][<a  href="<?php echo $pageLink;?>?page=<?php echo $page-1;?>">上一页</a>][<a a  href="<?php echo $pageLink;?>?page=<?php echo $page+1;?>">下一页</a>][<a a  href="<?php echo $pageLink;?>?page=<?php echo $pagenum;?>">最后一页</a>]
    	          </td>
    	       </tr></table>
    </td>
</tr>
</table>

       </td>
	</tr>
</table>