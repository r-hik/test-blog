<?php
$sql="SELECT COUNT(*) as totArticles from articles";
$result=mysql_query($sql);
$data=mysql_fetch_array($result);
$totArticles=$data['totArticles'];
$nb_pages=ceil(($totArticles)/$nbArticles);
$precPage=ceil((int)var_get("p")-1);
$nextPage=ceil((int)$precPage+2);
?>
<div class="pagination">
	<ul>
		<li class="prev [disbale]"><a href="?p=<?php echo $precPage?>">&larr; Précédent</a></li>
		<?php for ($i=1; $i <=$nb_pages ; $i++) {
			?> <li><a href="?p=<?php echo $i ;?>"><?php echo $i."/ ";?></a></li>
			
			<?php
		}
		?>

		<li class="next [disbale]"><a href="?p=<?php echo $nextPage?>">Suivant &rarr;</a></li>
	</ul>