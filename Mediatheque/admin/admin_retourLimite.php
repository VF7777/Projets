<?php
session_start();
include("config.inc.php");
checkLogin();
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
    
    <a href="#error-menu2" class="nav-header" data-toggle="collapse"><i class="icon-exclamation-sign"></i>Emprunt et réservation<i class="icon-chevron-up"></i></a>
        <ul id="error-menu2" class="nav nav-list collapse in">
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
            <?php 
$sql1=mysql_query("select * from emprunt,utilisateur where emprunt.IDU=utilisateur.IDU and emprunt.StatutE ='Emprunt' and utilisateur.bloque ='0' order by DateEmprunt desc");
$info1=mysql_fetch_array($sql1);
$empruntNombre=mysql_num_rows($sql1);     //Obtenir le nombre de ligne
?>
    <p class="stat"><span class="number"><?php echo $empruntNombre;?></span>emprunts en cour(Tous les types)</p>
</div>

            <h1 class="page-title">Gestion d'emprunt et réservation</h1>
        </div>
        
                <ul class="breadcrumb">
                <li class="active">Emprunt et réservation <span class="divider">/</span></li>
            <li><a href="admin_retourLimite.php">Pas de retour après la date limite</a></li>
            
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    <div class="row-fluid">

    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Avis:</strong> Vous pouvez consulter tous les ressources pas de retour,et bloqué un untilisateur qui a un amende supérieur à 50€ 
    </div>    
</div>

<div class="row-fluid">

        <a href="#tablewidget" class="block-heading" data-toggle="collapse">Pas de retour après la date limite<span class="label label-warning">+</a>
        <div id="tablewidget" class="block-body collapse in">
            <table class="table" width="776">
              <thead>
                <tr>
                  <th>Date limite de retour</th>
                  <th>Nom et Prénom d'utilisateur</th>
                  <th>Email</th>
                  <th>Amende(€)</th>
                  <th>Opération</th>                 
                </tr>
              </thead>
              <tbody>
       <?php do{
   		$DateLimiteRetour=date("Y-m-d",strtotime("$info1[DateEmprunt]+ 30days"));        //30 jours après la date Reserve
   		$jour=floor((strtotime(date('Y-m-d'))-strtotime($DateLimiteRetour))/86400);   		 		
       if($jour>0) {	
   		?>
                <tr>
                  <td>      <?php echo $DateLimiteRetour;?></td>
                  <td>  		 <?php echo $info1[Prenom]; ?>&nbsp;&nbsp;<?php echo $info1[Nom];?></td>
                  <td>  		 <?php echo $info1[Email];?></td>
                  <td>  		 <?php echo $jour;?></td>
                   <?php 
                     if($jour>=50) {
                     ?>                     
                     <td width="12%" align="center"><a href="bloquerUtilisateur.php?id=<?php echo $info1[IDU];?>">Bloquer compte</a>&nbsp;</td>
                    <?php  
                     }
                     ?>
                </tr>
                <?php 
             }
       }while($info1=mysql_fetch_array($sql1));
?>
              </tbody>
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


