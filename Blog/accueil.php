﻿<body>

{foreach $articles AS $article}
				<h3>{$article.titre}</h3>
					<p>{$article.texte}
					
					 </p>
					 ecrit le : {$dateFR}
					
				{if ( $connecte )}
					<br><br>
					<a href="article.php?id={$article.id}" class="btn btn-primary">Modifier</a>
					<a href="supprimer-article.php?id={$article.id}" class="btn btn-danger"> Supprimer</a>  
				 
				{/if}
				
				<hr>
			{/foreach}
{if $nb_pages gt 1}
<div class="pagination" >
	<ul>
		<li class="prev {if $page<=1} disabled{/if}" >
			<a id="prev" {if $page gt 1}href="?p={$page-1}{/if}{if $rech}&r={$rech}{/if}">&larr; Précédent</a>
		</li>
		 {for $i=1 to $nb_pages}<!-- On boucle jusqu a l'avant dernier page-->
						<li{if $page==$i } class="active"{/if}>
							<a  href="?p={$i}{if $rech}&r={$rech}{/if}">{$i}</a>
						</li>						
					{/for}
	

		<li class="next {if $nextPage gt $nb_pages} disabled {/if}">
			<a id='next' {if $page lt $nb_pages} href="?p={$page+1}{/if}{if $rech}&r={$rech}{/if}">Suivant &rarr;</a>
		</li>
	</ul>
</div>
{/if}
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