<?php

session_start();

if(isset($_POST["nom"]))
    $nom = $_POST["nom"];

if(isset($_POST["prenom"]))
    $prenom = $_POST["prenom"];

if(isset($_POST["tel"]))
    $tel = $_POST["tel"];

if(isset($_POST["pass"]))
    $pass = $_POST["pass"];

if(isset($_POST["pass2"]))
    $pass2 = $_POST["pass2"];
if($pass2!=$pass){ header("location:MonCompteControleur.php?action=modifier&errLog=2"); }
else {


    include("config.inc.php");


    $req = $bdd->prepare('update utilisateur set Nom=:nom,Prenom=:prenom,MotDePasse=:mdp,Tel=:tel where IDU='.$_SESSION["IDU"].'');
    $req->bindValue(':nom', $nom, PDO::PARAM_STR);
    $req->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $req->bindValue(':mdp', $pass, PDO::PARAM_STR);
	$req->bindValue(':tel', $tel, PDO::PARAM_STR);
    $req->execute();
	
    header('location:MonCompteControleur.php?action=modifier&inscrit=1&prenom='.$prenom);}
