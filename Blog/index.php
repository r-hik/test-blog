<?php
require("libs/Smarty.class.php"); //On intègre Smarty
//
include('includes/connexion.inc.php');
include('includes/haut.inc.php');
include('includes/fonctions.inc.php');
include('includes/notifications.inc.php');

//Création de variables
	$smarty 	= 	new Smarty();
	$connecte	= 	false;
	$articles 	=	array();

	if(isset($_COOKIE['sid']))
		{
			$sql 	= 	"SELECT * FROM connexion WHERE sid='".$_COOKIE['sid']."'";	
			$result =  	mysql_query($sql);

			if(mysql_num_rows($result))
				{
					$connecte 	= 	true;
					$utilisateur 	= 	mysql_fetch_array($result);
				}	
		}

//

//----------------------Pagination----------------------
$nbArticles	=	4; //Nombre d'artciles maximum désirés par page
$rech 		=	var_get('r'); //Dans le cas d'une recherche on recupère son contenu
$rech = htmlspecialchars($rech);
$rech_encode = urlencode($rech);
$page 		=	(int)var_get('p'); //On récupére le numéro de la page en cours
if ($page==0) $page=1; //forcage de la page à 1 si aucun numéro n'est affecté
$debut		=	($page-1)*$nbArticles; //1er article à récuperer dans la BD selon le n° de la page
//Dans le cas d'une recherche selection des articles contenant la recherche
	$recherche	=	($rech)?
					"WHERE titre LIKE \"%$rech%\"
					OR texte LIKE \"%$rech%\"
					"
							:"";
	$sql		=	"SELECT * FROM articles $recherche ORDER BY date DESC LIMIT $debut,$nbArticles";
	$pagination =	"SELECT COUNT(*) as totArticles from articles $recherche";
$result = mysql_query($sql);

//---------------------------------------------

//Affichage du Body-->

$titre 	=	($rech)?
			"Resultat pour la recherche $rech"
			:"Derniers Articles";
echo "<h2>$titre</h2>";
while($data = mysql_fetch_array($result))
	{ //boucle qui fait apparaitre la liste d'article
			
		$articles[]= $data;
		$dateFR=dateFR(strtotime($data['date']));
	}

$result=mysql_query($pagination);
$data=mysql_fetch_array($result);
$totArticles=$data['totArticles'];
$nb_pages=ceil(($totArticles)/$nbArticles);
$precPage=$page-1; //affectation page Précedente
$nextPage=$page+1; //Affectation Page Suivante

$smarty->assign('articles',$articles);
$smarty->assign('connecte',$connecte);
$smarty->assign('nbArticles',$nbArticles); // article par page
$smarty->assign('page',$page); // page en get
$smarty->assign('rech',$rech); // si une rech est faite
$smarty->assign('debut',$debut); //
$smarty->assign('nb_pages',$nb_pages);
$smarty->assign('precPage',$precPage);
$smarty->assign('nextPage',$nextPage);
$smarty->assign('totArticles',$totArticles);
$smarty->assign('rech_encode',$rech_encode);
$smarty->assign('dateFR',$dateFR)	;
$smarty->display("templates/index.phtml");
/*?>
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

$result=mysql_query($pagination);
$data=mysql_fetch_array($result);
$totArticles=$data['totArticles'];
$nb_pages=ceil(($totArticles)/$nbArticles);
$precPage=$page-1; //affectation page Précedente
$nextPage=$page+1; //Affectation Page Suivante
?>
<div class="pagination" >
	<ul>
		<li class="prev <?php if ($precPage<=0) echo 'disabled' ;?>" ><a id="prev"<?php //if ($precPage>=1) if($rech) echo "href='?p=$precPage&r=$rech'"; else echo "href='?p=$precPage'";?>>&larr; Précédent</a></li>
		<?php 
		for ($i=1; $i <=$nb_pages ; $i++) 
				{ 
					?>

					<li <?php if ($i==$page) echo 'class="active"'; ?>><a <?php if($rech) echo "href='?p=$i&r=$rech"; else echo"href='?p=$i'" ;?>><?php echo $i;?></a></li>
					
					<?php
				}
		?>

		<li class="next <?php if ($nextPage>$nb_pages) echo 'disabled' ;?>" ><a id='next'<?php // if ($nextPage<=$nb_pages)  if($rech) echo "href='?p=$nextPage&r=$rech'"; else echo "href='?p=$nextPage'";?>>Suivant &rarr;</a></li>
	</ul>
</div>
<script src='jquery.js'></script>
<script>
	$(function() {
    $('#prev').click(function() {
      $('#body').load('<?php if ($precPage>=1) if($rech) echo "?p=$precPage#body&r=$rech"; else echo "?p=$precPage#body";?>', function() {
      });
    });

    $('#next').click(function() {
      $('#body').load("<?php  if ($nextPage<=$nb_pages)  if($rech) echo '?p=$nextPage#body&r=$rech'; else echo '?p=$nextPage#body';?>", function() {
      });
    });
  });
</script>
*/
include('includes/bas.inc.php');
