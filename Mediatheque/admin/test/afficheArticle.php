<!doctype html PUBLIC "-//W3C//DTD html 4.01 Transitional//EN" >
<html>


<head>
	<title>MEDIATHEQUE</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />


</head>
<?php
    include("config.inc.php");
//article_admin.php
//    checkLogin();
//    database_connect();
    $result = mysql_query("select * from article");
    $number=intval(mysql_num_rows($result));
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理</title>
<link href="css/style.css" rel="stylesheet" />
<script src="js/admin_js.js"></script>
</head>

<table width="780" height="450" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #9CBED6; margin-top:15px;">
	<tr>
		<td align="center" valign="top">
		
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#DDDDDD" align="center">
<tr bgcolor="#E7E7E7">
	<td height="28" colspan="8">
	<b>Gestion de coup de coeur-&gt;Consulation de coup de coeur</b>
	</td>
</tr>
<tr align="center" bgcolor="#F0EEEE" height="22">
	<td>Index</td>
	<td>Titre</td>
	<td>Date de modification</td>
	<td>Auteur</td>
	<td>Publie ou pas</td>
	<td>Operations</td>
</tr>

<?php 
$i = 1;
$page = intval($_GET['page']);
$pageLink = 'afficheArticle.php';
if($page<1)$page = 1;
$pagenum = intval($number/10)+(($number%10)==0?0:1);
$result = mysql_query("select * from article order by idA desc limit  ".(($page-1)*10).",10");
while($row=mysql_fetch_array($result))
{
?>	
<tr align='center' height="22"   bgcolor="#FFFFFF" align="center">
	<td nowrap><?php echo $i++;?></td>
	<td align='left'>
		<span id="arc2">
			<a href='article_edit.php?action=view&id=<?php echo $row['idA']?>'>
				<u><?php echo $row['title']?></u>
			</a>
		</span></td>
	<td><?php echo $row['date']?></td>
	<td><?php echo $row['author']?></td>
	<td>
	 <?php if($row['publish']=='NO'){?>
	 <a href='db_article.php?action=publish&id=<?php echo $row['idA']?>'>Non Publié</a>
	<?php }else {?> <a href='db_article.php?action=unpublish&id=<?php echo $row['idA']?>'>Publié</a><?php }?></td>
	<td>
		<img src='images/view.png' title="consulter" alt="consulter" onclick="location='article_edit.php?action=view&id=<?php echo $row['idA']?>';" style='cursor:pointer' border='0' width='16' height='16' />
		<img src='images/edit.png' title="rédiger" alt="rédiger" onclick="location='article_edit.php?action=edit&id=<?php echo $row['idA']?>';"  style='cursor:pointer' border='0' width='16' height='16' />
		<img src='images/del.png' title="supprimer" alt="supprimer" onclick="location='db_article.php?action=del&id=<?php echo $row['idA']?>';"  style='cursor:pointer' border='0' width='16' height='16' />
	</td>
</tr>
<?php 
}
?>
<tr bgcolor="#EEF4EA">
	<td  bgcolor="#E7E7E7" height="24" colspan="8" align="center"  valign="middle">
    	<table>
    	      <tr>
    	          <td>共<?php echo $number; ?>条&nbsp;每页10条&nbsp;第<?php echo $page;?>页/共<?php echo $pagenum;?>页&nbsp;&nbsp;[<a href="<?php echo $pageLink;?>?page=1">第一页</a>][<a  href="<?php echo $pageLink;?>?page=<?php echo $page-1;?>">上一页</a>][<a a  href="<?php echo $pageLink;?>?page=<?php echo $page+1;?>">下一页</a>][<a a  href="<?php echo $pageLink;?>?page=<?php echo $pagenum;?>">最后一页</a>]
    	          </td>
    	       </tr></table>
    </td>
</tr>
</table>

       </td>
	</tr>
</table>
</html>