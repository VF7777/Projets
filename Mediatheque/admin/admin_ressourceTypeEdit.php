<?php
session_start();
include("config.inc.php");
checkLogin();

$action=$_GET['action'];
$row='';
$do = 'add';
if($action=='edit')
{
	$id = $_GET['id'];
	$result = mysql_query("select TYPE2 from ressourcetype where IDT=".$id);
	$row = mysql_fetch_array($result);
	$do = 'update&id='.$id;
}

?>
<!doctype html PUBLIC "-//W3C//DTD html 4.01 Transitional//EN" >
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Médiathèque Administrateur</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Chyfreefly" >
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.css">
    <link href="css/style.css" rel="stylesheet" />
    <script src="js/admin_js.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">

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
           <li ><a href="admin_main.php">Emprunte</a></li>
            <li ><a href="admin_reservation.php">Réservation</a></li>
            <li ><a href="admin_retourLimite.php">Pas de retour après la date limite</a></li>
        </ul>
        
        <a href="#dashboard-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-dashboard"></i>Gestion du coup du coeur<i class="icon-chevron-up"></i></a>
        <ul id="dashboard-menu" class="nav nav-list collapse">
            <li><a href="afficheArticle.php">Afficher coups de cœur</a></li>
            <li ><a href="article_edit.php">Ajouter un coup de coeur</a></li>          
        </ul>

        <a href="#accounts-menu" class="nav-header " data-toggle="collapse"><i class="icon-briefcase"></i>Gestion de Ressource<i class="icon-chevron-up"></i></a>
        <ul id="accounts-menu" class="nav nav-list collapse in">
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
        
        <a href="#legal-menuA" class="nav-header collapsed" data-toggle="collapse"><i class="icon-legal"></i>Gestion des comptes<i class="icon-chevron-up"></i></a>
        <ul id="legal-menuA" class="nav nav-list collapse">
           <li ><a href="utilisateur.php">Afficher des comptes utilisateur</a></li>
            <li ><a href="administrateur.php">Afficher des comptes Administrateur</a></li>
            <li ><a href="MDP.php">Changer mot de passe</a></li>
        </ul>

    </div>

    
    <div class="content">
        
        <div class="header">
            <div class="stats">
    <p class="stat"><span class="number"><?php echo $number; ?></span>Article en Total</p>

</div>

            <h1 class="page-title">Gestion de type Ressource</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="admin_ressourceTypeEdit.php">Ajouter un sous type ressource</a> <span class="divider">/</span></li>
            <li class="active">List</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">



<table width="780" height="450" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #9CBED6; margin-top:15px;">
	<tr>
		<td align="center" valign="top">
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC" align="center">

<tr bgcolor="#E7E7E7">
	<td height="28"  align="center">
	<b>Modifier sous-Type</b>
	</td>
</tr>
<tr align="center" bgcolor="#FAFAF1" height="22">
	<td width="100%" colspan="">

<form name="form1" action="db_booktype.php?action=<?php echo $do;?>" enctype="multipart/form-data" method="post" >
<input type="hidden" name="dopost" value="save" />
<input type="hidden" name="channelid" value="1" />
<input type="hidden" name="id" value="2" />

  <table width="98%"  border="0" align="center" cellpadding="2" cellspacing="2" id="needset">
    <tr>
      <td height="24" class="bline">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <?php if($do=='add'){?>
                  <td width="90">
                  
        <select name='type1' class='type1' id='type1' style='width:160px'	onchange="a(this)"  >
	      <option selected="selected">--Select Type--</option>

	<?php 
	
	$result_type1 = mysql_query("select DISTINCT TYPE1 from ressourcetype");
	while($r=mysql_fetch_array($result_type1))
	{$TYPE1=$r['TYPE1'];		?>
	             	<option value="<?php echo $TYPE1;?>" ><?php echo $TYPE1;?></option>
	<?php 		}       	?>
			</select>                 
                  
                  </td>
        <?php }?>
          <td width="135">&nbsp;Nom de sous type:</td>
          <td>
          	<input name="nom" type="text" id="nom" value="<?php echo $row['TYPE2'];?>" style="width:388px">
          </td>

        </tr>
      </table></td>
    </tr>
    
      </table>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
      <td width="45%" align="right"><input type="reset" value="RESET"></td>
      <td width="5%" ></td>
      <td width="45%" align="left"><input type="submit" value="UPLOAD"></td>
  </tr>

</table>
</form>
	</td>
</tr>
</table> 

		</td>
	</tr>
</table>



<!--***********************************************************************************-->
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


