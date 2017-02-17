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


try
{
	$bdd = new PDO('mysql:host=localhost;dbname=mediatheque;charset=utf8', 'root', 'root');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}	

    $req = $bdd->prepare('update utilisateur set Nom=:nom,Prenom=:prenom,MotDePasse=:mdp,Tel=:tel where IDU='.$_SESSION["IDU"].'');
    $req->bindValue(':nom', $nom, PDO::PARAM_STR);
    $req->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $req->bindValue(':mdp', $pass, PDO::PARAM_STR);
	$req->bindValue(':tel', $tel, PDO::PARAM_STR);
    $req->execute();
	
    header('location:MonCompteControleur.php?action=modifier&inscrit=1&prenom='.$prenom);
