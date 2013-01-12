<?php
include('includes/connexion.inc.php');
include('includes/fonctions.inc.php');
//-------Obtenir 3 arcticles par page--------
$nbArticles=3; //nombre d'artciles maximum désirés par page
$page=(int)var_get('p'); //On récupére le numéro de la page en cours
if ($page==0) $page=1; //forcage de la page à 1 si aucun numéro n'est affecté
$debut=($page-1)*$nbArticles; //
// //WHERE publie=1 
$rech=var_get('r');
if ($rech) {
	$sql="SELECT * FROM articles
	WHERE titre LIKE \"%$rech%\"
	OR texte LIKE \"%$rech%\" ORDER BY date DESC LIMIT $debut,$nbArticles
	";
} else $sql = "SELECT * FROM articles ORDER BY date DESC LIMIT $debut,$nbArticles";

$result = mysql_query($sql);
//---------------------------------------------
?>
<!--Affichage du Body-->
<h2>Derniers articles</h2> 
<?php
while($data=mysql_fetch_array($result)){ //boucle qui fait apparaitre la liste d'article
	//var_dump($data);
	
	//echo $data['titre'];
	//echo '<br>';
?>
	<article>
		<h3><?php echo $data['titre']; ?></h3>
			<p>
				<?php echo nl2br(htmlspecialchars($data['texte']));?>
				<br>
				<?php echo dateFR(strtotime($data['date'])); // Affichage de la date ?>
			</p>
	</article>
<a href="article.php?id=<?php echo $data['id']; ?>" class="btn btn-primary">Modifier</a>
<a href="supprimer-article.php?id=<?php echo $data['id']; ?>" class="btn btn-danger">Supprimer</a>
<?php
} 
//-----Selection de la page----------------------
$sql="SELECT COUNT(*) as totArticles from articles";
$result=mysql_query($sql);
$data=mysql_fetch_array($result);
$totArticles=$data['totArticles'];
$nb_pages=ceil(($totArticles)/$nbArticles);
$precPage=$page-1; //affectation page Précedente
$nextPage=$page+1; //Affectation Page Suivante

?>
<div class="pagination" >
	<ul>
		<li class="prev <?php if ($precPage<=0) echo 'disabled' ;?>"><a <?php if ($precPage>=1) echo 'href="accueil.php?p=$precPage"'; if($rech) echo 'href="accueil.php&r=$rech"';?>>&larr; Précédent</a></li>
		<?php 
		for ($i=1; $i <=$nb_pages ; $i++) 
				{ 
					?>

					<li <?php if ($i==$page) echo 'class="active"'; ?>><a href="accueil.php?p=<?php echo $i ;?>"><?php echo "Page ".$i;?></a></li>
					
					<?php
				}
		?>

		<li class="next <?php if ($nextPage>$nb_pages) echo 'disabled' ;?>"><a href="<?php if ($nextPage<=$nb_pages)  if($rech) echo 'accueil.php?p=$nextPage&r=$rech'; else echo 'accueil.php?p='.$nextPage;?>">Suivant &rarr;</a></li>
	</ul>
</div>
<?php
