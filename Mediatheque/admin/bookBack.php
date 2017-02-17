<?php
session_start();
include("config.inc.php");
checkLogin();
$email=$_POST[email];
$sql=mysql_query("select * from utilisateur,emprunt,ressource,exemplaire where utilisateur.Email='$email'and utilisateur.IDU=emprunt.IDU and emprunt.IDEX =exemplaire.IDEX and exemplaire.IDR=ressource.IDR and emprunt.StatutE='Emprunt'");
$info=mysql_fetch_array($sql);
$sqlsys=mysql_query("select * from systeme where id = '1'");
$infoSystem=mysql_fetch_array($sqlsys);
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
    <script src="js/admin_js.js"></script>
    <link rel="stylesheet" type="text/css" href="stylesheets/theme.css">
    <link rel="stylesheet" href="lib/font-awesome/css/font-awesome.css">
    <link href="css/style1.css" rel="stylesheet">
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

<script language="javascript">
		function checkutilisateur(form){
			if(form.email.value==""){
				alert("Entrer le Email d'utilisateur SVP!");form.email.focus();return;
			}
			form.submit();
		}
		</script>

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

        <a href="#accounts-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-briefcase"></i>Gestion de Ressource<i class="icon-chevron-up"></i></a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="book_admin.php">Afficher Ressource</a></li>
            <li ><a href="book_edit.php">Ajouter un Ressource</a></li>
            <li ><a href="admin_ressourceType.php">Gestion de type Ressource</a></li>
            <li ><a href="admin_ressourceTypeEdit.php">Ajouter de type Ressource</a></li>
        </ul>

        <a href="#error-menu" class="nav-header " data-toggle="collapse"><i class="icon-exclamation-sign"></i>Emprunter et Retour<i class="icon-chevron-up"></i></a>
        <ul id="error-menu" class="nav nav-list collapse in">
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

            <h1 class="page-title">Retour</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="bookBack.php">Retour</a> <span class="divider">/</span></li>
            <li class="active">List</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
<!--             class="table"       -->

<table width="776" border="0" align="center" cellpadding="0" cellspacing="0" class="tableBorder">
	<td>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="99%" height="510"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tableBorder_gray">
  <tr>
    <td height="510" align="center" valign="top" style="padding:5px;"><table width="98%" height="487"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="top">
<form name="form1" method="post" action="">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableBorder_gray">
   <tr>
     <td valign="top"><table width="100%" border="0" cellpadding="02" cellspacing="2" bordercolor="#E3F4F7">
       <tr>
         <td valign="top" bgcolor="#D2E6F1">

		 <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
           <tr>
             <td width="33%"><table width="100%" height="74" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td height="27" colspan="2" align="center"><table width="90%" height="21" border="0" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="132" ><strong>&nbsp;Retour</strong></td>
                     <td>&nbsp;</td>
                   </tr>
                 </table></td>
               </tr>
               <tr>
                 <td width="8%" height="27">&nbsp;</td>
                 <td width="92%">Email d'utilisateur：</td>
               </tr>
               <tr>
                 <td height="27" colspan="2" align="center"><input name="email" type="text" id="email" value="<?php echo $info[Email];?>" size="24">
                   &nbsp;
                   <input name="Button" type="button" class="btn_grey" value="Confirmer" onClick="checkutilisateur(form1)"></td>
               </tr>
             </table></td>
             <td width="66%" align="right">
			 <table width="96%" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td height="27">Nom：
                       <input name="nom" type="text" id="nom" value="<?php echo $info[Nom];?>"></td>
                 <td>Prenom：
                   <input name="prenom" type="text" id="prenom" value="<?php echo $info[Prenom];?>"></td>
               </tr>
               <tr>
                 <td height="27">Tel：
                   <input name="tel" type="text" id="tel" value="<?php echo $info[Tel];?>"></td>
                 <td>Nombre limite d'emprunt：
                   <input name="number" type="text" id="number" value="<?php echo $infoSystem[valeur];?>" size="17">
                   </td>
               </tr>
             </table>			 </td>
           </tr>
         </table>		 </td>
       </tr>
       <tr>
         <td valign="top" bgcolor="#D2E5F1"><table width="100%" height="35" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#D2E3E6" bgcolor="#FFFFFF">
                   <tr align="center" bgcolor="#e3F4F7">
                     <td width="24%" height="25" bgcolor="#F0FAFB">Titre</td>
                     <td width="12%" bgcolor="#F0FAFB">Date d'emprunt</td>
                     <td width="13%" bgcolor="#F0FAFB">Date limite de retour</td>
                     <td width="10%" bgcolor="#F0FAFB">Type</td>
                     <td width="10%" bgcolor="#F0FAFB">Emplacement</td>
                     <td bgcolor="#F0FAFB">Prix(€)</td>
                     <td width="10%" bgcolor="#F0FAFB">Opération</td>
                     <td width="12%" bgcolor="#F0FAFB"><input name="Button22" type="button" class="btn_grey" value="Reset" onClick="window.location.href='bookBack.php'"></td>
                   </tr>
<?php

if($info){
 do{
           if($info[DateEmprunt] !=null) {
	        $DateLimiteRetour=date("Y-m-d",strtotime("$info[DateEmprunt]+ 30 days"));        //dans+30jours
           }
           else {
	       $DateLimiteRetour=null;
           } 	
 

 	?>
 
                   <tr>
                     <td height="25" style="padding:5px;">&nbsp;<?php echo $info[Titre];?></td>
                     <td style="padding:5px;">&nbsp;<?php echo $info[DateEmprunt];?></td>
                     <td style="padding:5px;">&nbsp;<?php echo $DateLimiteRetour;?></td>
                     <td align="center">&nbsp;<?php echo $info[Type];?></td>
                     <td align="center">&nbsp;<?php echo $info[Emplacement];?></td>
                     <td width="13%" align="center">&nbsp;<?php echo $info[Prix];?></td>
                      <td style="padding:5px;">&nbsp;<?php echo $info[StatutE];?></td>
                     <td width="12%" align="center"><a href="bookBack_ok.php?IDE=<?php echo $info[IDE];?>&email=<?php echo $info[Email];?>">Retourner</a>&nbsp;</td>           
                   </tr>
<?php
}
while($info=mysql_fetch_array($sql));
}
 ?>
                 </table>                 </td>
       </tr>
     </table></td>
   </tr>
</table>
 </form> </td>
      </tr>
    </table>
</td>
  </tr>
</table></td>
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


