
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
			<div class="center" >
			
				
				<?php 
				if(isset($_SESSION["Prenom"]))
				{
				   ?>     
						<p class="description"> Bienvenu 
				<?php
						 
						 echo  $_SESSION["Prenom"]
					?> !</p>
				     <br>
					 <p><a href="deconnect.php"  class="inscription">Deconnection</p></a>   
					 <br>
					 <p><a href="MonCompte.php"  class="inscription">Compte</p></a> 
				<?php 
				}
				else
				{
					?> 
			         <form id="connexion" method="post" action="connexionControleur.php" class="form-container ">
					 <div class="form-title"><h2>CONNECTION</h2></div>
						<p class="form-title">Login :</p>
						
						<input class="form-field" type="text" name="login" id="login" required placeholder="example@example.com"/>
						
						<p  class="form-title">Mot de passe :</p>
						<input class="form-field" type="password" name="pass" id="pass" required  />
						<br>
						<br>
						<input  class="submit-button" type="submit" value="Connecter" />
						<?php if(isset($_GET["inscrit"]) && $_GET["inscrit"]=="0") { ?>
						<br>
						<br>
						<br>
						<p class="errForm" >Il y a une erreur dans le login ou le mot de passe</p>
						
						<?php } ?>
						<?php if(isset($_GET["inscrit"]) && $_GET["inscrit"]=="2") { ?>
						<br>
						<br>
						<br>
						<p class="errForm" >votre compte est bloque <?php echo $_GET["prenom"];?> veulliez contactez administrateur!</p>
						
						<?php } ?>
					
					    <br>
						<br>
					    <p><a href="creation.php"  class="submit-buttonbis">s'inscrit </p></a>    
				<?php } ?>
						</form>	
				</div>
		<div class="right">
	
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