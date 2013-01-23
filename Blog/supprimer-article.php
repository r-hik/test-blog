<?php
include('includes/connexion.inc.php');
include('includes/haut.inc.php'); 
include('includes/fonctions.inc.php');
//on récupere l'id de l'article
$id=(int)var_get('id');
//si id est vrai (différent de 0 ou NULL) on supprime la ligne correspondant à l'id
If ($id)
{
	requete_notif("DELETE FROM articles WHERE id='$id'",'articles','supprimé'); //fonction qui supprime un article
	//on renvoie vers l'accueil
	header('Location:index.php');
	exit();

}