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
				<div class="the-latest">					
					<div class="txthead">THE LATEST</div>
                <?php
              try
				{
					$bdd = new PDO('mysql:host=localhost;dbname=mediatheque;charset=utf8', 'root', 'root');
				}
				catch (Exception $e)
				{
						die('Erreur : ' . $e->getMessage());
				}
				$req = $bdd->prepare('SELECT DISTINCT * FROM ressource,dvd WHERE type="dvd" and IDR=IDD and IDR >((SELECT MAX(IDD)FROM dvd )-3) ');
				$req->execute();
				$livres = array();?>
				
               <table  style="background-color:White">
			   <tr>
			   <?php while ($donnees = $req->fetch()) {?>
				
				<table>
				
					<tr>
						<a href="blancD.php?article_id=<?php echo $donnees['IDR']?>"><img src=<?php echo $donnees['Image'] ?> width="120" height="180"><br>
					</tr>
					<tr>
						<span class="titre"><?php echo $donnees['Titre'] ?></span>
					</tr>
					<tr>
					    <p>by<span class="green-text"><?php echo $donnees['Acteur'] ?></span></p>
					</tr>
					<div class="border"></div>
					<tr>
					<div>
					   <p><span class="description"> <?php echo$donnees['Description'] ?></span></P>
					</div>
					</tr>
					
					<div class="green-border"></div>
				</table>			
				 <?php } ?>
				 <tr>
				 </table>
			</div>
		</div> 
				<div class="center">
		<div class="center">
		    <p ><a href="DVD-CD.php" class="txthead">Categorie>><span class="categorie"><?php echo$_GET['catD_id'] ?></p>
	        <?php

			   require("config.inc.php");
				$bdd = connect_db();				
				$req = $bdd->prepare('SELECT * FROM ressource,dvd WHERE type="dvd" and IDR=IDD and GenreD="'.$_GET['catD_id'].'"');
				$req->execute();
				
				?>
            <table  style="background-color:White">
			   <?php
			    while ($donnees = $req->fetch()) {
			      ?>
				<td>
				<table>
					<tr>
						<?php 
						
						echo '<a href="blancD.php?article_id='.$donnees['IDR'].'"><img src=' .$donnees['Image']. ' width=120 height=180/><br>';
						
						?>
					</tr>
					<tr>
						<?php echo $donnees['Titre'] ?>
					</tr>
					<tr>
						<p class="description">by<span class="green-text"><?php echo $donnees['Acteur'] ?></span></p>
					</tr>
					<tr>
					    <p><span class="description"> <?php echo $donnees['Prix'] ?>$</span></P>
						
					</tr>
					
				</table>
                 </td>  				
				 <?php } ?>
				 </table>
		<div class="clear"></div>
		<div class="green-button">INTERESTING ARTICLE</div>
			<p class="grey-text">	Designer Edmar Cisneros has an interesting and unique philosophy regarding design that. It’s always entertaining to explore the works of a great caricature artist. This showcase from Web Designer Depot features some amazing and hilarious caricatures from Athony Geoffroy. This showcase from Web Designer Depot.
				</p>
			</div>
			</div>
		<div class="right">
		<div class="txthead"> LES PLUS POPULAIRE </div>
						
				 <?php
			
					$populaire = $bdd->prepare('select distinct IDR,count(IDR)as nb from exemplaire where Etat=0 group by IDR order by nb desc limit 5');
					$populaire->execute();
				 ?>
				 <table>
				 <tr>
				   <?php while ($p = $populaire->fetch()) {?>
					<table>
						<tr>
						<?php
						$getp = $bdd->prepare('select * from ressource where IDR='.$p['IDR'].'');
						$getp->execute();
						$getpnom = $getp->fetch();
						?>
						<?php if($getpnom['Type']=="livre"){?>
						<p><span class="number"><?php echo $p['nb']?> </span> <span class="green-popular-text"><a href="blanc.php?article_id=<?php echo $p['IDR']?> ">
						<?php echo $getpnom['Titre'];}?></a></p>
						<?php if($getpnom['Type']=="music"){?>
						<p><span class="number"><?php echo $p['nb']?> </span> <span class="green-popular-text"><a href="blancM.php?article_id=<?php echo $p['IDR']?> ">
						<?php echo $getpnom['Titre'];}?></a></p>
						<?php if($getpnom['Type']=="dvd"){?>
						<p><span class="number"><?php echo $p['nb']?> </span> <span class="green-popular-text"><a href="blancD.php?article_id=<?php echo $p['IDR']?> ">
						<?php echo $getpnom['Titre'];}?></a></p>
						
				        <div class="r-border"></div>
						
						</tr>
						</tr>
					</table>			
					 <?php } ?>
					 <tr>
					 </table>
				
					 <tr>
					 </table>
				
			
			<div class="txthead">Nouveaux Commentaire</div>
			
			
			 <?php
		
				$r = $bdd->prepare('SELECT DISTINCT * FROM commentaire WHERE idc >((SELECT MAX(idc)FROM commentaire )-3) ');
				$r->execute();
				?>
               <table>
			   <tr>
			   <?php while ($d = $r->fetch()) {?>
				<table>
					<tr>
					<?php
					$getNom = $bdd->prepare('SELECT Prenom FROM utilisateur WHERE IDU='.$d['idU'].'');
				    $getNom->execute();
					$nom = $getNom->fetch();
					
					$getTitre = $bdd->prepare('SELECT * FROM ressource WHERE IDR='.$d['idR'].'');
				    $getTitre->execute();
					$titre = $getTitre->fetch();
					?>
					<div class="twitbackgrnd">
					<div class="twitcontents">
					<?php if ($titre['Type']=="livre"){?>
					<a href="blanc.php?article_id=<?php echo $d['idR']?>"><span class="green-popular-text" >@<?php echo $titre['Titre']?>:<span class="number"><?php echo $d['texte'] ?></span><br><span class="green-popular-text" >From <?php echo $nom['Prenom']?></div></a>
					<?php }?>
					<?php if ($titre['Type']=="music"){?>
					<a href="blancM.php?article_id=<?php echo $d['idR']?>"><span class="green-popular-text" >@<?php echo $titre['Titre']?>:<span class="number"><?php echo $d['texte'] ?></span><br><span class="green-popular-text" >From <?php echo $nom['Prenom']?></div></a>
					<?php }?>
					<?php if ($titre['Type']=="dvd"){?>
					<a href="blancD.php?article_id=<?php echo $d['idR']?>"><span class="green-popular-text" >@<?php echo $titre['Titre']?>:<span class="number"><?php echo $d['texte'] ?></span><br><span class="green-popular-text" >From <?php echo $nom['Prenom']?></div></a>
					<?php }?>
					<div class="twitcontents">
					
					</div>
					</tr>
					</tr>
				</table>			
				 <?php } ?>
				 <tr>
				 </table>
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