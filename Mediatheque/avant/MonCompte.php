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
	<script src="script.js"></script>
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
		<div id='cssmenu'>
<ul>
   <li class='active'><a href="MonCompte.php"><span>Mon Compte</span></a></li>
   <li class='has-sub'><a href='#'><span>Les Emprunts</span></a>
      <ul>
         <li><a href="MonCompteControleur.php?action=histoir"><span>Historique</span></a></li>
         <li><a href="MonCompteControleur.php?action=emprunts"><span>Les emprunts courants</span></a></li>
      </ul>
   </li>
      <li class='last'><a href="MonCompteControleur.php?action=modifier"><span>Modifier Mon Compte</span></a></li>
</ul>
</div>
		
		</div> 
        <div class="center">
        <?php 
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=mediatheque;charset=utf8', 'root', 'root');
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
		}
		$req = $bdd->prepare('SELECT * FROM utilisateur WHERE IDU='.$_SESSION["IDU"].' ');
		$req->execute();
		$donnees = $req->fetch();
		$r = $bdd->prepare('SELECT * FROM emprunt WHERE StatutE="Emprunt" and IDU='.$_SESSION["IDU"]. '');
		$r->execute();
		
	    ?>
		<table  class="CSSTableGenerator">
		<tr><td><span class="titre"></span><span><?php echo $donnees['Prenom'];?>.</span><span><?php echo $donnees['Nom'];?></span></td>
		</tr>
 		<tr><td><span class="titre">Mot de passe: </span><span class="description"><?php echo $donnees['MotDePasse'];?></span></td></tr>
		<tr><td><span class="titre">Tel: </span><span class="description"><?php echo $donnees['Tel'];?></span></td></tr>
		<tr><td><span class="titre">Email: </span><span class="description"><?php echo $donnees['Email'];?></span></td></tr>
        <tr><td><span class="titre">Penalite: </span><span class="description"><?php 
		$penalite=0;
		while($f = $r->fetch()){
		$date=floor((strtotime(date('Y-m-d'))-strtotime($f['DateEmprunt']))/86400);
		if($date>30){$penalite=$penalite+$date-30;}
		} 
		
		 echo $penalite;
		 ?>$</span></td></tr>
		</table>
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