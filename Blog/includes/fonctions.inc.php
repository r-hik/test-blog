<?php
function var_post($champ) {
	return (isset($_POST[$champ]))? $_POST[$champ]:false;
}

function var_get($champ) {
	return (isset($_GET[$champ]))? $_GET[$champ]:false;
}

function requete_notif($sql,$var,$val){
//possibilité de la faire en ternaire
	if (mysql_query($sql)) $_SESSION[$var]=$val;
	else $_SESSION[$var]='erreur';
}

function dateFR($arg){ // Traduit la date en français
	$jour=array("Dimanche","Lundi","Mardi","Mercredi", "Jeudi", "Vendredi", "Samedi");
	$mois=array(" ","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
	//$lejour=date("d",$arg);
	//$lemois=date("m",$arg);

	/*$date=$jour[ date('w',$arg) ]." "; 

	if($lejour==01){$date.=" 1er "; } 
	else if($lejour<10){$date.=" $lejour[1] "; } 
	else { $date.=date (" d ",$arg); } 

	$date.=$mois[ date($lemois - 1) ]." ".date('Y - H:i'); */

	$date=$jour[date('w',$arg)]." ".date('d',$arg)." ".$mois[date('n',$arg)]." ".date('Y',$arg);
	return $date;
}