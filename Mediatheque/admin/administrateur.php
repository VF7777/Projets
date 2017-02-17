<?php
session_start();
include("config.inc.php");
checkLogin();
$resultA = mysql_query("select * from admin");
$number=intval(mysql_num_rows($resultA));
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Médiathèque Administrateur</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Chyfreefly" >

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">    
    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">
    <link href="css/style.css" rel="stylesheet" />
    <script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>


    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body class=""> 
    
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    <li><a href="systeme.php" class="hidden-phone visible-tablet visible-desktop" role="button">Paramètre</a></li>
                    
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> <?php echo $_SESSION[name];?>
                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                              <li class="divider visible-phone"></li>
                            <li><a tabindex="-1" href="logout.php">Se déconnecter</a></li>
                            </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="admin_main.php"><span class="first">Médiathèque</span> <span class="second">Administrateur</span></a>
        </div>
    </div>
    


    
    <div class="sidebar-nav">
    
    <a href="#error-menu2" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>Emprunt et réservation<i class="icon-chevron-up"></i></a>
        <ul id="error-menu2" class="nav nav-list collapse">
            <li ><a href="admin_main.php">Emprunt</a></li>
            <li ><a href="admin_reservation.php">Réservation</a></li>
            <li ><a href="admin_retourLimite.php">Pas de retour après la date limite</a></li>
        </ul>
        
        <a href="#dashboard-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-dashboard"></i>Gestion du coup du coeur<i class="icon-chevron-up"></i></a>
        <ul id="dashboard-menu" class="nav nav-list collapse">
            <li><a href="afficheArticle.php">Afficher coups de cœur</a></li>
            <li ><a href="article_edit.php">Ajouter un coup de coeur</a></li>
            
        </ul>

        <a href="#accounts-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-briefcase"></i>Gestion de Ressource<i class="icon-chevron-up"></i></a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="book_admin.php">Afficher Ressource</a></li>
            <li ><a href="book_edit.php">Ajouter un Ressource</a></li>
            <li ><a href="admin_ressourceType.php">Gestion de type Ressource</a></li>
            <li ><a href="admin_ressourceTypeEdit.php">Ajouter de type Ressource</a></li>
        </ul>

        <a href="#error-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>Emprunter et Retour<i class="icon-chevron-up"></i></a>
        <ul id="error-menu" class="nav nav-list collapse">
            <li ><a href="bookBorrow.php">Emprunter</a></li>
            <li ><a href="bookRenew.php">Prolonger</a></li>
            <li ><a href="bookBack.php">Retour</a></li>
        </ul>

        <a href="#legal-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-legal"></i>Gestion de commentaire<i class="icon-chevron-up"></i></a>
        <ul id="legal-menu" class="nav nav-list collapse">
             <li ><a href="commentaire.php">Afficher des commentaires</a></li>
            <li ><a href="commentaireRecherche.php">Recherche des commentaires</a></li>
            </ul>
        
        <a href="#legal-menuA" class="nav-header" data-toggle="collapse"><i class="icon-legal"></i>Gestion des comptes<i class="icon-chevron-up"></i></a>
        <ul id="legal-menuA" class="nav nav-list collapse in">
            <li ><a href="utilisateur.php">Afficher des comptes utilisateur</a></li>
            <li ><a href="administrateur.php">Afficher des comptes Administrateur</a></li>
            <li ><a href="MDP.php">Changer mot de passe</a></li>
        </ul>

    </div>
    

    
    <div class="content">
        
        <div class="header">
            <div class="stats">
    <p class="stat"><span class="number"><?php echo $number;?></span>administrateurs</p>
</div>

            <h1 class="page-title">Gestion des Comptes</h1>
        </div>
        
                <ul class="breadcrumb">
                 <li class="active">Gestion des Comptes<span class="divider">/</span></li>
            <li><a href="administrateur.php">Afficher des administrateurs</a> </li>

                </ul>

        <div class="container-fluid">
            <div class="row-fluid">

<div class="row-fluid">


<table width="780" height="450" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #9CBED6; margin-top:15px;">
	<tr>
		<td align="center" valign="top">

<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#DDDDDD" align="center">
<tr align="center" bgcolor="#F0EEEE" height="22">
	<td>ID Administrateur</td>
	<td>Nom administrateur</td>
	<td>La date dernière connexion</td>
	<td>Suppression</td>
	<td>Réinitialiser mot de passe </td>
</tr>
 <?php 
$i = 1;
$page = intval($_GET['page']);
$pageLink = 'administrateur.php';
if($page<1)$page = 1;
$pagenum = intval($number/10)+(($number%10)==0?0:1);
$result = mysql_query("select * from admin order by id asc limit ".(($page-1)*10).",10");
while($row=mysql_fetch_array($result))
{
?>	
<tr align='center' height="22"   bgcolor="#FFFFFF" align="center">
	<td><?php echo $row['id'];?></td>
	<td><?php echo $row['name'];?></td>
	<td><?php echo $row['lastdate'];?></td>
	<td>                      
   <img src='images/del.png' title="Supprimer" alt="Supprimer" onclick="location='db_admin.php?action=del&id=<?php echo $row['id'];?>';"  style='cursor:pointer' border='0' width='16' height='16' />
	</td>
    
      <td width="12%" align="center"><a href="db_admin.php?action=repwd&id=<?php echo $row['id'];?>">Réinitialiser</a>&nbsp;</td>	

</tr>
<?php 
}
?>
<tr><td colspan="7"><a href="admin_edit.php?action=add"><u>Ajouter administrateur</u></a></td></tr>
<tr bgcolor="#EEF4EA">
	<td  bgcolor="#E7E7E7" height="24" colspan="8" align="center"  valign="middle">
    	<table>
    	      <tr>
    	          <td>Page<?php echo $page;?>/<?php echo $pagenum;?>&nbsp;&nbsp;[<a href="<?php echo $pageLink;?>?page=1">Premier page</a>][<a  href="<?php echo $pageLink;?>?page=<?php echo $page-1;?>">page précedent</a>][<a a  href="<?php echo $pageLink;?>?page=<?php echo $page+1;?>">page suivant</a>][<a a  href="<?php echo $pageLink;?>?page=<?php echo $pagenum;?>">dernier page</a>]
    	          </td>
    	       </tr></table>
    </td>
</tr>
</table>

</td>
	</tr>
</table>
    </div>
    
</div>
                    <footer>
                        <hr>
                        
                        <p class="pull-right">Médiathèque</a> de Yang, Yiran, Edgar</p>

                        <p>&copy; 2015 Yang</a></p>
                    </footer>
                    
            </div>
        </div>
    </div>
    


    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>


