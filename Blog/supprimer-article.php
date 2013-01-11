<?php
include('includes/connexion.inc.php');
include('includes/haut.inc.php'); 
include('includes/fonctions.inc.php');

$id=(int)var_get('id');
If ($id){
	requete_notif("DELETE FROM articles WHERE id='$id'",'articles','supprimé'); //fonction qui supprime un article
	?><script type="text/javascript">window.location.href='index.php'</script>
	<?php 

}