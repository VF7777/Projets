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
		<li><a>Bienvenu <?php echo $_SESSION["Prenom"]?> !</li></a> <?php }?>	
		</div>
		<div class="clear"></div>
		<div class="main-content">
			<div class="bar">
				<header>
					<h1 class="header"><a>Mediqtaique</a>
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
								 
								<li><a href="deconnect.php">Deconnection</li></a>   
								<li><a href="MonCompte.php">Mon Compte</li> </a> 
							<?php 
							}
							else {
							?>
							<li><a href="connexion.php">Connection|Creer compte</li> </a><?php 
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
 
  $nbArticles=count($_SESSION['panier']['libelleProduit']);
	 if ($nbArticles <= 0)
	 {echo "<tr><td>Votre panier est vide </ td></tr>";}
	 else
	   {
	      for ($i=0 ;$i < $nbArticles ; $i++)
	      {
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=mediatheque;charset=utf8', 'root', 'root');
			}
			catch (Exception $e)
			{
					die('Erreur : ' . $e->getMessage());
			}
			$j = $bdd->prepare('select count(*) as nb from emprunt,exemplaire where emprunt.IDU='.$_SESSION['IDU'].' and StatutE="Emprunt" and emprunt.IDEX=exemplaire.IDEX and exemplaire.IDR='.$_SESSION['panier']['reference'][$i].'');
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
			echo "vous avec deja reserve ";
			echo $_SESSION['panier']['libelleProduit'][$i];
			echo "<br>";
			 }
			
			}
			echo "votre commande est bien enregistre dans la base";
	      }
		  
		 
		  echo "<br><a href=\"index.php\">Continuer Mes Achats</a></td>";
   
  
	 ?>		
				
		</div>
		<div class="right">
		
				<div class="clear"></div>
		</div>
				
				
			
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div><!-- eo .body-content -->
	<footer>
		<div class="footer">
			<div class="footer-left">
				<div class="footer-heading">
					DEAD STOCKER
				</div>
				<p class="footer-text">The best blog about fashion.We love fashion and we cant't live without it.See the latest news and reviews</p>
			</div>
			<div class="footer-right">
				<nav>
					<div class="footer-nav">
					<a href="#">DEAD SPACER</a>
					<a href="#">DEAD ZONE</a>
					<a href="#">RACK SNATCH</a>
					<a href="#">TAGGER WATCH</a>
					<a href="#">ADVERTISE</a>
					<a href="#">PRIVACY POLICY</a>
					<a href="#">TERMS OF USE</a>
					</div>
				</nav>
				<div class="clear"></div>
				<div class="abt-ths-site-footer">
					<h5><a href="#">ABOUT THIS SITE</a></h5>
					<p class="footer-text-border">The best blog about wine
					and we can't live without it.See always the latest news and reviews.</p>
				</div>
				<div class="subscription-footer">
					<h5><a href ="#">SUBSCRIBE</a></h5>
					<p class="footer-text-border">Follow us: <a href="http://twitter.com/sumeetchawla/"><img src="images/twitter.png"> Twitter </a> <a href ="http://www.facebook.com/codepal"><img src="images/fb.png"> Facebook</a> <a href="http://feeds.feedburner.com/code-pal/"><img src="images/rss.png"> RSS</a></p>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div><!-- eo .footer -->		
	</footer>
	</div><!-- eo .page-wrap-->
	<p class="footer-link">Copyright 2015 | Website Developed By ZHANG Yiran CHEN YANG et Edgar</p>
</body>
</html>