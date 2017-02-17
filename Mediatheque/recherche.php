<?php
session_start();
?>
<!doctype html PUBLIC "-//W3C//DTD html 4.01 Transitional//EN" >
<html lang="fr">


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
         <span class="description"><p>Resultat de recherche pour: <?php echo $_POST["recherche"];?></p></span>
		 <div class="border"></div>
	        <?php
			   $com=0;

			   require("config.inc.php");
				$req = $bdd->prepare('SELECT * FROM ressource WHERE Titre like "%'.$_POST["recherche"].'%" ');
				$req->execute();
				
				?>
            <table  style="background-color:White">
			
			   <?php
			   
			    while ($donnees = $req->fetch()) {
			      ?>
				 <?php 
				 if(fmod($com,3)==0){echo '<tr>';}
				 ?>
				
				 <td>
				   <table>
					<tr>
					<?php if($donnees['Type']=="livre") {?>
					<a href="blanc.php?article_id=<?php echo $donnees['IDR']?>"><img src=<?php echo $donnees['Image'] ?> width="120" height="180"><br></a>
					<?php }?>
					<?php if($donnees['Type']=="music") {?>
					<a href="blancM.php?article_id=<?php echo $donnees['IDR']?>"><img src=<?php echo $donnees['Image'] ?> width="120" height="180"><br></a> 
					<?php }?>
					<?php if($donnees['Type']=="dvd") {?>
					<a href="blancD.php?article_id=<?php echo $donnees['IDR']?>"><img src=<?php echo $donnees['Image'] ?> width="120" height="180"><br> </a>
					<?php }?>
					</tr>
					<tr>
						<td width="200"><p><?php echo $donnees['Titre'] ?></p></td>
					</tr>
					<tr >
						<td>In<span class="green-text"><?php echo $donnees['AnneeSortie'] ?></span></td>
					</tr>
					 </table>
					 
				 </td>	
			 
				<?php 
				 if(fmod($com,3)==2){echo '</tr><br>';}?>
				 <?php
				 $com=$com+1;
				 } ?>
				
				</tr>
				 </table>
		<div class="clear"></div>
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