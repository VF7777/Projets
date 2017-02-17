<?php
session_start();
if(isset($_POST["login"]))
    $login = $_POST["login"];

if(isset($_POST["pass"]))
    $pass = $_POST["pass"];

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=mediatheque;charset=utf8', 'root', 'Cheny1006');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

//所有用户查询
$req = $bdd->prepare('SELECT * FROM utilisateur WHERE Email=:login AND MotDePasse=:mdp');
$req->bindValue(':login', $login, PDO::PARAM_STR);
$req->bindValue(':mdp', $pass, PDO::PARAM_STR);
$req->execute();

if (FALSE === ($res = $req->fetch()))
{//inscrit=0不存在此用户,inscrit=1正常用户,inscrit=2被封禁用户
    header("location:connexion.php?inscrit=0");
}
else
{    
//管理员查询
$requet = $bdd->prepare('SELECT * FROM utilisateur WHERE Email=:login AND MotDePasse=:mdp AND Statut="adm"');
$requet->bindValue(':login', $login, PDO::PARAM_STR);
$requet->bindValue(':mdp', $pass, PDO::PARAM_STR);
$requet->execute();
//si je suis utilisateur 
    if (FALSE === ($resultat = $requet->fetch()))
    { 
	//tester si ce utilisateur est bloque ou pas
	if($res['bloque']==1){
    	header('location:connexion.php?inscrit=2&prenom='.$res['Prenom']);
	}else{
        header('location:index.php?inscrit=1&prenom='.$res['Prenom']);
        $_SESSION["Prenom"] = $res['Prenom'] ;
	    $_SESSION["IDU"]=$res['IDU'];
	}
    }
    else{
//si je suis administradeur
     header("location:admin/afficheArticle.php");
    }
}
?>