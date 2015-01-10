<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']==true)
{
	require 'params2.php';
	mysql_connect($host,$user,$password) or die('Erreur de connexion au SGBD.');
	mysql_select_db($base) or die('La base de données n\'existe pas');
	
	$titre = $_POST['titre'];
	$type = $_POST['type'];
	$texte = $_POST['texte']; 
	$datedebut = $_POST['dateDebut']." ".$_POST['heureDebut'];
	$datefin = $_POST['dateFin']." ".$_POST['heureFin'];
	
	$queryAjout="insert into statut(TYPE,TITRE,TEXTE,DATEDEBUT, HEUREDEBUT, DATEFIN, HEUREFIN) VALUES('$type','$titre','$texte','$datedebut', '$heureDebut','$datefin','$heureFin')";
	mysql_query($queryAjout);
	echo $queryAjout;
	mysql_close();
	header('location:Admin.php');
}
?>