<?php 
include('includes/connexion.inc.php');
include('includes/fonctions.inc.php'); 
//var_dump($_POST);
?>
<form action="article.php" method="post">
<?php
//pour la modification
$id =(int)var_get('id');
$action_label=($id)?'Modifier':'Ajouter';
echo ("<h2>".$action_label." un article</h2>"); 
If ($id)
	{
		$resultat=mysql_query("SELECT * FROM articles WHERE id='$id'"); 
		$data=mysql_fetch_array($resultat);
	}


If (isset($_POST['post']))
	{
	//vérification des valeurs entrées
		$titre= var_post('titre');
		$texte= var_post('texte');
		If (!$titre || !$texte)
			{ //données non remplies ??> 
				<div class='alert alert-error'>
					Veuillez saisir tous les champs.
				</div>		
			<?php
			}
		Else 
			{

		//pour l'ajout 
				$id=(int)var_post('id');
				If ($id)
					{
						requete_notif("UPDATE articles SET titre='$titre', texte='$texte' WHERE id='$id'",'articles','modifié'); //fonction qui modifie et teste
					}
				else
					{
						requete_notif("INSERT INTO articles (titre, texte) VALUES ('$titre','$texte')",'articles','ajouté'); //fonction ajoute et teste
					
					}
					?><script type="text/javascript">window.location.href='index.php'</script>
	<?php 

				
				
			}
	}
		?>
	<div class="clearfix">
		<label for="titre">Titre</label>
		<div class="input"><input type="text" name="titre" id="titre" value="<?php If (isset($data['titre'])) echo $data['titre']; ?>"></div> 
	</div>
	<div class="clearfix">
		<label for="texte">Texte</label>
		<div class="input"><textarea name="texte" id="texte"><?php If (isset($data['texte'])) echo $data['texte']; ?></textarea></div> 
	</div>
	<div class="clearfix">
		<div class="input"><input type="checkbox" name="publie" id="publie" value="1"><label for="publie">Publier</label></div> 
	</div>
	<div class="form-actions">
		<input type="submit" value="<?php echo $action_label; ?>" class="btn btn-large btn-primary"> 
		<input type="hidden" name='post' value=""> <!-- Permet de savoir si on se trouve en en traitement -->
		<input type="hidden" name='id' value="<?php echo $id; ?>"> <!-- Permet de savoir si on se trouve en modification -->
	</div>
</form>