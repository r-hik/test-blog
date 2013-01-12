<?php 
require("libs/smarty.class.php");
include('includes/connexion.inc.php');
include('includes/fonctions.inc.php'); 
//var_dump($_POST);
/************************************************************
 * Definition des constantes / tableaux et variables
 *************************************************************/
 
// Constantes
define('TARGET', 'img/');    // Repertoire cible
define('MAX_SIZE', 500000);    // Taille max en octets du fichier
define('WIDTH_MAX', 1800);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 1800);    // Hauteur max de l'image en pixels
 
// Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
$infosImg = array();
 
// Variables
$extension = '';
$message = '';
$nomImage = '';
 
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé ! Vérifiez que vous diposiez des droits suffisants pour le faire ou créez le manuellement !');
  }
}
?>
<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
				
				if( !empty($_FILES['fichier']['name']) )
				  {
				    // Recuperation de l'extension du fichier
				    $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
				 
				    // On verifie l'extension du fichier
				    if(in_array(strtolower($extension),$tabExt))
				    {
				      // On recupere les dimensions du fichier
				      $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
				 
				      // On verifie le type de l'image
				      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
				      {
				        // On verifie les dimensions et taille de l'image
				        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
				        {
				          // Parcours du tableau d'erreurs
				          if(isset($_FILES['fichier']['error']) 
				            && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
				          {
				            // On renomme le fichier
				            $nomImage = $titre .'.'. $extension;
				 
				            // Si c'est OK, on teste l'upload
				            if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
				            {
				              $message = 'Upload réussi !';
				            }
				            else
				            {
				              // Sinon on affiche une erreur systeme
				              $message = 'Problème lors de l\'upload !';
				            }
				          }
				          else
				          {
				            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
				          }
				        }
				        else
				        {
				          // Sinon erreur sur les dimensions et taille de l'image
				          $message = 'Erreur dans les dimensions de l\'image !';
				        }
				      }
				      else
				      {
				        // Sinon erreur sur le type de l'image
				        $message = 'Le fichier à uploader n\'est pas une image !';
				      }
				    }
				    else
				    {
				      // Sinon on affiche une erreur pour l'extension
				      $message = 'L\'extension du fichier est incorrecte !';
				    }

				  }
				  $id=(int)var_post('id');
				If ($id)
					{
						requete_notif("UPDATE articles SET titre='$titre', texte='$texte' image='$id.jpg' WHERE id='$id'",'articles','modifié'); //fonction qui modifie et teste
					}
				else
					{
						requete_notif("INSERT INTO articles (titre, texte, image) VALUES ('$titre','$texte',)",'articles','ajouté'); //fonction ajoute et teste
					
					}
  
					?><!--<script type="text/javascript">window.location.href='index.php'</script>-->
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
	<p>
            <label for="fichier_a_uploader" title="Recherchez le fichier à uploader !">Envoyer le fichier :</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
            <input name="fichier" type="file" id="fichier_a_uploader" />
        
    </p>
	<div class="clearfix">
		<div class="input"><input type="checkbox" name="publie" id="publie" value="1"><label for="publie">Publier</label></div> 
	</div>
	<div class="form-actions">
		<input type="submit" value="<?php echo $action_label; ?>" class="btn btn-large btn-primary"> 
		<input type="hidden" name='post' value=""> <!-- Permet de savoir si on se trouve en en traitement -->
		<input type="hidden" name='id' value="<?php echo $id; ?>"> <!-- Permet de savoir si on se trouve en modification -->
	</div>
</form>