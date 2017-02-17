<?php
session_start();
include("config.inc.php");
checkLogin();
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
		function checkRessource(form){
			if(form.email.value==""){
				alert("Entrer le Email d'utilisateur SVP!");form.email.focus();return;
			}		
			if(form.inputkey.value==""){
				alert("Entrer le ID Ressource SVP!");form.inputkey.focus();return;
			}

			if(form.nombre.value-form.empruntNombre.value<=0){//fonction pour limiter le nombre maximum d'emprunt
				alert("Vous ne pouvez pas emprunter d'autres Ressource!");return;
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
            <div class="stats">
    <p class="stat"><span class="number"><?php echo $number; ?></span>Article en Total</p>

</div>

            <h1 class="page-title">Emprunter</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="bookBorrow.php">Emprunter</a> <span class="divider">/</span></li>
            <li class="active">List</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
<!--             class="table"       -->

<table width="776"  border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><table width="100%" height="509"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="tableBorder_gray">
  <tr>
    <td align="left" valign="top" style="padding:5px;"> &nbsp;     
    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
	<?php
		$sql=mysql_query("select * from utilisateur where Email='".$_POST[email]."'");
		$info=mysql_fetch_array($sql);
		$sqlsys=mysql_query("select * from systeme where id = '1'");
		$infoSystem=mysql_fetch_array($sqlsys);
	?>
	<form name="form1" method="post" action="">
        <tr>
          <td height="72" align="center" valign="top" background="Images/main_booksort_1.gif" bgcolor="#F8BF73">
          <br>		  
          <table width="96%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#9ECFEE" class="tableBorder_grey">
          <tr>
              <td height="33" valign="top" >
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  
				
                    <tr>
                      <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                      </table>
                        <table width="100%" height="21" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="76%" style="padding-top:7px;">Email d'utilisateur：
                              <input name="email" type="text" id="email" size="24" value="<?php echo $info[Email];?>">
                            &nbsp;
                              <input name="Button" type="button" class="btn_grey" value="Confirmer" onClick="checkutilisateur(form1)"></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="13" align="left" style="padding-left:7px;"><hr width="90%" size="1"></td>
                      </tr>
                    <tr>
                      <td align="center"><table width="96%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td height="27">Nom：
                              <input name="nom" type="text" id="nom" value="<?php echo $info[Nom];?>">
                              <input name="utilisateurId" type="hidden" id="utilisateurId" value="<?php echo $info[IDU];?>"></td>
                            <td>Prenom
                              <input name="prenom" type="text" id="prenom" value="<?php echo $info[Prenom];?>"></td>
                          </tr>
                          <tr>
                          <td height="27">Tel：
                              <input name="tel" type="text" id="tel" value="<?php echo $info[Tel];?>"></td>
  <!--reste-->    <td>Nombre limite d'emprunt：
                              <input name="nombre" type="text" id="nombre" value="<?php echo $infoSystem[valeur];?>" size="17">
                              </td>
                          </tr>
                      </table></td>
                    </tr>
                </table></td>
            </tr>
                 <tr>
                   <td height="32">&nbsp;Emprunter par：
                     <input name="f" type="radio" class="noborder" value="IDR" checked>
                     Id Ressource &nbsp;&nbsp;
                     <input name="inputkey" type="text" id="inputkey" size="50"><!--valeur pour faire la recherche-->
                     <input name="Submit" type="button" class="btn_grey" id="Submit" onClick="checkRessource(form1);" value="Confirmer">
                     <input name="operator" type="hidden" id="operator" value="<?php echo $_SESSION[adminname];?>">
    <input name="Button2" type="button" class="btn_grey" id="Button2" onClick="window.location.href='bookBorrow.php'" value="Reset">                   </td>
                 </tr> 
            <tr>
              <td valign="top" bgcolor="#D2E5F1" style="padding:5px"><table width="99%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="#FFFFFF" bordercolordark="#9ECFEE" bgcolor="#FFFFFF">
                     <tr align="center" bgcolor="#E2F4F6">
                       <td width="20%" height="25">Titre</td>
                       <td width="12%">Date d'emprunt</td>
                       <td width="14%">Date limite de retour</td>
                       <td width="17%">Type</td>
                       <td width="14%">Emplacement</td>
                       <td width="10%">Prix(€)</td>
                       <td colspan="2">Opération</td>
                     </tr>
<?php
$utilisateurId=$info[IDU];
$sql1=mysql_query("select * from emprunt,exemplaire,ressource where emprunt.IDU='$utilisateurId' and emprunt.IDEX =exemplaire.IDEX and exemplaire.IDR=ressource.IDR and emprunt.StatutE !='Retour' ");
$info1=mysql_fetch_array($sql1);

$empruntNombre=mysql_num_rows($sql1);     //Obtenir le nombre de ligne

		
do{
	if($info1[DateEmprunt] !=null) {
	$DateLimiteRetour=date("Y-m-d",strtotime("$info1[DateEmprunt]+ 30 days"));        //dans+30jours
   }
   else {
	$DateLimiteRetour=null;
   }
	/*if($info1==false) {
	  $Operation=null;}
	else if(isset($info1[DateEmprunt]) ==false ) {
	  $Operation="Reservation";
   }
   elseif(isset($info1[DateEmprunt]) == true) {
	  $Operation="Emprunt";
		}*/
?>
                     <tr>
                       <td height="25" style="padding:5px;">&nbsp;<?php echo $info1[Titre];?></td>
                       <td style="padding:5px;">&nbsp;<?php echo $info1[DateEmprunt];?></td>
                       <td style="padding:5px;">&nbsp;<?php echo $DateLimiteRetour;?></td>
                       <td align="center">&nbsp;<?php echo $info1[Type];?></td>
                       <td align="center">&nbsp;<?php echo $info1[Emplacement];?></td>
                       <td width="14%" align="center">&nbsp;<?php echo $info1[Prix];?></td>
                       <td style="padding:5px;">&nbsp;<?php echo $info1[StatutE];?></td>
                       
                     </tr>
<?php 
}while($info1=mysql_fetch_array($sql1));
?>
   <input name="empruntNombre" type="hidden" id="empruntNombre" value="<?php echo $empruntNombre; ?>">

                   </table>			</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" background="Images/main_booksort_2.gif">&nbsp;</td>
        </tr>
	   </form>
<?php
if($_POST[inputkey]!=""){
$f=$_POST[f]; //f est Id Ressource ou nom de Ressource
$inputkey=trim($_POST[inputkey]);
$email=$_POST[email];

$borrowTime=date('Y-m-d');

$query=mysql_query("select * from ressource where $f='$inputkey'");
$result=mysql_fetch_array($query);   //vérifier l'information de ressurce existe ou pas
if($result==false){
	echo "<script language='javascript'>alert('Cet ressource n'exist pas！');window.location.href='bookBorrow.php?email=$email';</script>";
  }
   else{
   	
   	$query5=mysql_query("select * from exemplaire where IDR='$inputkey'  and Etat='1'");
   $result5=mysql_fetch_array($query5);   
 	if($result5==false) {//décider il y a de ressource disponible ou pas
 			 	   echo "<script language='javascript'>alert('Il y a pas exemplaire disponible！');window.location.href='bookBorrow.php?email=$email';</script>";
    }
   else {
  $query1=mysql_query("select * from emprunt,exemplaire where emprunt.IDEX = exemplaire.IDEX and emprunt.IDU='$utilisateurId' and exemplaire.IDR='$inputkey' and exemplaire.Etat='0' and  emprunt.StatutE ='Emprunt'");   
  $result1=mysql_fetch_array($query1);

   	if($result1==true) {
	   //si cette ressource est déjà emprunté par cet utilisateur，on ne peut pas emprunter encore une fois 
		echo "<script language='javascript'>alert('Cet ressource a été emprunté par lui！');window.location.href='bookBorrow.php?email=$email';</script>";
	  }
   else{
		
    $query3=mysql_query("select * from emprunt,exemplaire where  emprunt.StatutE ='Reservation' and emprunt.IDEX=exemplaire.IDEX and exemplaire.IDR='$inputkey' and emprunt.IDU !='$utilisateurId'  and exemplaire.Etat ='0'");
    $result3=mysql_fetch_array($query3);
	if($result3==true){  
			   //Si cette ressource est réservé par d'autre utilisateur，on ne peut pas l'emprunter 
 					echo "<script language='javascript'>alert('Cet ressource a été reservé par autre utilisateur！');window.location.href='bookBorrow.php?email=$email';</script>";
 	 }
	 else{
	     	 $query4=mysql_query("select * from emprunt,exemplaire where emprunt.StatutE ='Reservation' and emprunt.IDEX=exemplaire.IDEX and exemplaire.IDR='$inputkey' and emprunt.IDU ='$utilisateurId'  and exemplaire.Etat ='0'");
		    $result4=mysql_fetch_array($query4);
	 if($result4==true){ 
		//si cette ressource est reservé par cet utilisateur, il veut emprunter cette ressource, on enlève la  DateReserve et ajouter un DateEmprunt
					mysql_query("update emprunt set DateReserve = null,DateEmprunt='$borrowTime',StatutE ='Emprunt' where IDE='$result4[IDE]'");
					echo "<script language='javascript'>alert('Emprunter reussi après réservation！');window.location.href='bookBorrow.php?email=$email';</script>";
		}
	 else {
	 	/*if($empruntNombre>5) {
	 		 	      echo "<script language='javascript'>alert('Le nombre d'emprunt ne peut pas supérieur à 5！');window.location.href='bookBorrow.php?email=$email';</script>";
	 	}else {*/

    $query2=mysql_query("select * from exemplaire where IDR ='$inputkey' and Etat =1");
    $result2=mysql_fetch_array($query2);
    $exempleid=$result2[IDEX];
	 if($result2==true){    //emprunter

			mysql_query("insert into emprunt(IDU,IDEX,DateEmprunt,StatutE)values('$utilisateurId','$exempleid','$borrowTime','Emprunt')");
			mysql_query("update exemplaire set Etat = '0' where IDEX='$exempleid'");
 	      echo "<script language='javascript'>alert('Emprunter reussi！');window.location.href='bookBorrow.php?email=$email';</script>";
       }
 	
 	   else{}
// 	                    }
 			           }
 			       }
 		      }
 		  }
    }
 }
?>
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


