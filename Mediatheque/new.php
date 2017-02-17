<?php
session_start();
?>
<!doctype html PUBLIC "-//W3C//DTD html 4.01 Transitional//EN" >
<html>


<head>
	<title>Mediatheque</title>
	<link rel="shortcut icon">
	<link rel="stylesheet" type="text/css" href="css/reset.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery.cycle.all.js"></script>
	<script src="js/main.js"></script>
</head>

<body>

	<div class="page-wrap">
		<div class="top-menu">								
			<?php 
		if(isset($_SESSION["Prenom"]))
		{?>     
		<li> <a href="panier.php" > <img src="images/panier.png" style="width:30px;height:30px" /></a><a>Bienvenu <?php echo $_SESSION["Prenom"]?> !</li></a> <?php }?>	
		</div>
		<div class="clear"></div>
		<div class="main-content">
			<div class="bar">
				<header>
					<h1 class="header"><a>MEDIATHEQUE</a>
					</h1>
					<nav>
					<ul> 			
							<li><a href="index.php">Home Page</a></li> 
							<li><a href="DVD-CD.php">DVD</a></li> 
							<li><a href="livre.php">Livre</a></li> 
							<li><a href="music.php">Music</a></li> 
							<?php 
							if(isset($_SESSION["Prenom"]))
							{
							   ?>     
								 
								<li><a href="deconnect.php">Déconnection</li></a>   
								<li><a href="MonCompte.php">Mon Compte</li> </a> 
							<?php 
							}
							else {
							?>
							<li><a href="connexion.php">Connecxion|Créer Compte</li> </a><?php 
							}?>
							
						</ul>
					</nav>
					
				</header>
			</div>	
			<div class="clear"></div>
			<div class="clear"></div>
			<div class="body-contents">
		<div class="left-body">
	
		</div> 
        <div class="center">
		
	<?php

 $jour=date("Y-m-d");
 echo "<form class=\"form-container\">";
  $nbArticles=count($_SESSION['panier']['libelleProduit']);
	 if ($nbArticles <= 0)
	 {echo "<tr><td>Votre panier est vide </ td></tr>";}
	 else
	   {
	      for ($i=0 ;$i < $nbArticles ; $i++)
	      {
              include("config.inc.php");

              $j = $bdd->prepare('select count(*) as nb from emprunt,exemplaire where emprunt.IDU='.$_SESSION['IDU'].' and StatutE !="Retour" and emprunt.IDEX=exemplaire.IDEX and exemplaire.IDR='.$_SESSION['panier']['reference'][$i].'');
			$j->execute();
			$resultat = $j->fetch();
	
		    if ($resultat['nb']==0)
			{
            $req = $bdd->prepare('select min(IDEX) as idex from exemplaire where Etat=1 and IDR='.$_SESSION['panier']['reference'][$i].'');
			$req->execute();
			$res = $req->fetch();
			
			$r = $bdd->prepare('insert into emprunt(IDU,DateReserve,IDEX,StatutE,NumeroCarte,Code,NomCarte)values('.$_SESSION['IDU'].',"'.$jour.'",'.$res['idex'].',"Reservation",'.$_GET["cardnumber"].','.$_GET["secure"].',"'.$_GET["namecard"].'")');
		    $r->execute();

	        $re = $bdd->prepare('update exemplaire set Etat=0 where IDEX='.$res['idex'].'');
			$re->execute();
			
			}
			else {
			
			echo "vous avec déjà reservé ou emprunté ";
			echo $_SESSION['panier']['libelleProduit'][$i];
			echo "<br>";
			 }
			
			}
			echo "<div class=\"form-title\"><h2>votre commande est bien enregistre dans la base</h2></div>";
            
	      }
	  unset($_SESSION['panier']);
      unset($_SESSION['panier']['libelleProduit']);
      unset($_SESSION['panier']['qteProduit']);
      unset($_SESSION['panier']['prixProduit']); 
	  unset($_SESSION['panier']['reference'] );
      unset($_SESSION['panier']['verrou']);
		  echo "<br><a href=\"index.php\"><img src=\"images/back.png\" alt=\"Mountain View\" style=\"width:50px;height:50px\"></a></td>";
          echo "</form>";
  
	 ?>		
				
		</div>
			
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div><!-- eo .body-content -->
	<footer>
		<div class="footer">
			<div class="footer-left">
				<div class="footer-heading">
					MEDIATHEQUE
				</div>
				<p class="footer-text">Hôtel de ville
										2, Esplanade Pierre-Yves-Cosnier
										94807 Villejuif Cedex<br>
										Tél.: 01 45 59 20 00  </p>
			</div>
			<div class="footer-right">
				<nav>
					<div class="footer-nav">
					<div class="footer-text">
					Horaires d'ouverture
				    </div>
					<a href="#">Lundi, mardi, mercredi : de 8h30 à 12h et de 13h30 à 18h</a>
					<a href="#">Jeudi : accueil central, de 8h30 à 12h et de 13h30 à 18h (autres services accueillant le public : 8h à 12h. fermeture l'après-midi).</a>
					<a href="#">Vendredi : de 8h30 à 12h et de 13h30 à 17h</a>
					<a href="#">Samedi : de 8h30 à 12h</a>
					
					</div>
				</nav>
				<div class="clear"></div>
				
				
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div><!-- eo .footer -->		
	</footer>
	</div><!-- eo .page-wrap-->
	<p class="footer-link">Copyright 2015 | Website Developed By ZHANG Yiran CHEN YANG et Edgar</p>
</body>
</html>