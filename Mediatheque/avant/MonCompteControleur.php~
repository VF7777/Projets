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
		 $action=$_GET["action"];
		 if ($action=="modifier"){?>
		 
		 <?php if(isset($_GET["inscrit"]) && $_GET["inscrit"]=="1")
					{?>
						<form class="form-container">
                        <h1> Les modification sont bien enregistre dans la base <?php echo $_GET['prenom'] ?> !</h1>
						</form>
					<?php
					} 
					else
					{?> 
					  
					  <form id="myForm"  method="post" action="modifierControleur.php" class="form-container" >
						<div class="txthead"><h2>Modifier Mon compte</h2></div>
						
						<p class="form-title" for="nom">Nom :</p>
						<input class="form-field"  type="text" name="nom" id="nom" required pattern="^[a-zéèàêâùïüëA-Z]+([ \'-][a-zéèàêâùïüëA-Z']+)*$"
							   value="<?php if(isset($_GET['nom'])) echo $_GET['nom']; ?>" />
						
						<p class="form-title" for="prenom">Prenom :</p>
						<input class="form-field"  type="text" name="prenom" id="prenom" required pattern="[a-zéèàêâùïüëA-Z]+\-?[a-zéèàêâùïüëA-Z]+"
							   value="<?php if(isset($_GET['prenom'])) echo $_GET['prenom']; ?>" />
						
						<p class="form-title" for="tel">Telephone :</p>
						<input class="form-field"  type="text" name="tel" id="tel" required pattern="^0[0-9]{9}"
							   value="<?php if(isset($_GET['tel'])) echo $_GET['tel']; ?>" />
					
						<p class="form-title" for="pass">Mot de passe :</p>
						<input class="form-field"  type="password" name="pass" id="pass" required pattern=".{6,20}" />
						
						<div class="control-group">
						<div class="controls">
						<p class="form-title" for="pass2">Ressaisissez votre mot de passe :</p>
						<input class="form-field"   type="password" name="pass2" id="pass2" required pattern=".{6,20}" />
					    <?php if(isset($_GET["errLog"]) && $_GET["errLog"]=="2") { ?>
							<p class="errForm">Les deux mots de passe doivent etre identiques</p>
							<?php } ?>
						</div>
						</div> 
						<br /> 
						<br />
						<input class="submit-buttontri" id="val1" type="submit" value="Envoyer" class="inscription"/>
					</form>
					<?php } 
					?>
					
					<script>
					  $(function(){
						$("form").on("submit", function(){
							if(document.forms["myForm"].elements["pass"].value !== document.forms["myForm"].elements["pass2"].value){
								$("div.control-group").addClass("error");
								$("div.alert").show("slow").delay(4000).hide("slow");
								return false;
							}
						});
					  });
					</script>	
		<?php } 
		if ($action=="histoir"){
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=mediatheque;charset=utf8', 'root', 'root');
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
		}
		$req = $bdd->prepare('SELECT * FROM emprunt,exemplaire,ressource WHERE IDU='.$_SESSION["IDU"].' and StatutE="Retour" and emprunt.IDEX=exemplaire.IDEX and ressource.IDR=exemplaire.IDR');
		$req->execute();
		?>
		 <table class="CSSTableGenerator">
			   <tr>
			    <td>
						<span class="titre">Ressource</span>
				</td>
				 <td>
						<span class="titre">Prix</span>
				</td>
				<td>
						<span class="titre">DateReserve</span>
				</td>
				<td>
						<span class="titre" >DateRetour</span>
				</td>
				
				</tr>
				<tr>
			   <?php while ($donnees = $req->fetch()) {?>
				  
				    <tr>
					<td>
						<span class="description"><?php echo $donnees['Titre'] ?></span>
					</td>
					<td>
					    <p><span class="green-text"><?php echo $donnees['Prix'] ?></span></p>
					</td>
					<td >
					    <p><span class="green-text"><?php echo $donnees['DateReserve'] ?></span></p>
					</td>
					<td >
					<div >
					   <p><span class="green-text"> <?php echo$donnees['DateRetour'] ?></span></P>
					</div>
					</td>
					</tr>
						
				 <?php } ?>
				 </tr>
				</table>
				
				
		<?php
		}
		if ($action=="emprunts"){
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=mediatheque;charset=utf8', 'root', 'root');
		}
		catch (Exception $e)
		{
				die('Erreur : ' . $e->getMessage());
		}
		$req = $bdd->prepare('SELECT * FROM emprunt,exemplaire,ressource WHERE IDU='.$_SESSION["IDU"].' and StatutE="Reservation" and emprunt.IDEX=exemplaire.IDEX and ressource.IDR=exemplaire.IDR');
		$req->execute();
		?>
		<tr><span class="description">Reservation</span></tr>
		 <table  class="CSSTableGenerator">
		       
			   <tr>
			    <td>
						<span class="titre">Ressource</span>
				</td>
				 <td>
						<span class="titre">Prix</span>
				</td>
				<td>
						<span class="titre">DateReserve</span>
				</td>
				<td>
						<span class="titre">DateLimite</span>
				</td>
				<td>
						<span class="titre">Supprimer</span>
				</td>
			
				</tr>
				<tr>
			   <?php while ($donnees = $req->fetch()) {?>
				  
				    <tr>
					<td>
						<span class="description"><?php echo $donnees['Titre'] ?></span>
					</td>
					<td>
					    <p><span class="green-text"><?php echo $donnees['Prix'] ?></span></p>
					</td>
					<td >
					    <p><span class="green-text"><?php echo $donnees['DateReserve'] ?></span></p>
					</td>
					<td >
					<div>
					<p><span class="orange-text"> 
					<?php $stop_date = date('Y-m-d ', strtotime( $donnees['DateReserve']. ' + 2 day'));
					echo $stop_date;?></span></P>
					</div>
				    <td >
						<span class="titre" >
						<a href=<?php echo 'EmpruntsControleur.php?action=supprimer&ide='.$donnees['IDE'].'&idex='.$donnees['IDEX'].''?> ><img src="images/erase.png" alt="Mountain View" style="width:20px;height:20px"></a></span>
				    </td>
					</td>
					</tr>
				 <?php } ?>
				 </tr>
				</table>
				
				
				
				
				<div class="border"></div>
				<?php
				$r = $bdd->prepare('SELECT * FROM emprunt,exemplaire,ressource WHERE IDU='.$_SESSION["IDU"].' and StatutE="Emprunt" and emprunt.IDEX=exemplaire.IDEX and ressource.IDR=exemplaire.IDR');
		        $r->execute();
		        ?>
				<tr><span class="description">Les emprunts courants</span></tr>
		 <table class="CSSTableGenerator">
		       
			   <tr>
			    <td>
						<span class="titre">Ressource</span>
				</td>
				 <td>
						<span class="titre">Prix</span>
				</td>
				<td>
						<span class="titre">DateEmprunt</span>
				</td>
				<td>
						<span class="titre">Prolongation</span>
				</td>
				
				</tr>
				
			   <?php while ($d = $r->fetch()) {?>
				  
				    <tr>
					<td>
						<span class="description"><?php echo $d['Titre'] ?></span>
					</td>
					<td>
					    <p><span class="green-text"><?php echo $d['Prix'] ?></span></p>
					</td>
					<td >
					    <p><span class="green-text"><?php echo $d['DateEmprunt'] ?></span></p>
					</td>
					<td >
					<?php 
					if ($d['Prolongation']==1){
					?>
					<a href=<?php echo 'EmpruntsControleur.php?action=prolongation&ide='.$d['IDE'].'&date='.$d['DateEmprunt'].''?> ><img src="images/plo.png" alt="Mountain View" style="width:20px;height:20px"></a></span>

					
						 <?php
					}
					?>
						
					</td>
					</tr>
				 <?php } ?>
				 
				</table>
				
		<?php
		}
		?>
				
		</div>
		<div class="right">
		
				<div class="clear"></div>
		</div>
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