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
		<section>
     <form id=payment action="new.php" class="form-container">
         
        <ol>
            <li>
           
               <div class="form-title"><h2>PAYMENT</h2></div>
                 <fieldset  align="centre">
				<ol >
                        <label class="form-title" for=cardnumber>Entreprise cooperative:</label>
						<br>
                        <input id=visa name=cardtype type=image src="images/visa.png" />
                        <input id=mastercard name=cardtype type=image src="images/mastercard.png" width="38" height="38"/>
                        <input id=paypal name=cardtype type=image src="images/paypal.png"/>

                    
                </ol>
            </fieldset>
            </li>
            <li>
                <label class="form-title" for=cardnumber>Numero de carte</label>
                <input class="form-field" id=cardnumber name=cardnumber type=number required pattern="^0[0-9]{16}"/>
            </li>
			<br>
            <li>
                <label class="form-title" for=secure>Code securite</label>
                <input class="form-field" id=secure name=secure type=number required pattern="^0[0-9]{3}"/>
            </li>
			<br>
            <li>
                <label class="form-title" for=namecard>Nome de Card</label>
                <input class="form-field" id=namecard name=namecard type=text required pattern="^[a-zéèàêâùïüëA-Z]+([ \'-][a-zéèàêâùïüëA-Z']+)*$"/>
            </li>
        </ol>
    </fieldset>
    <fieldset align="right">
        <button type=submit class="submit-buttontfinal">PAYEZ</button>
    </fieldset>
	
</form>
		</section>
		<script>
					  $(function(){
						$("form").on("submit", function(){
							if(document.forms["payment"].elements["pass"].value !== document.forms["payment"].elements["pass2"].value){
								$("div.control-group").addClass("error");
								$("div.alert").show("slow").delay(4000).hide("slow");
								return false;
							}
						});
					  });
					</script>		
				
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