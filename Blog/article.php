<?php 
include('includes/haut.inc.php');
include('includes/connexion.inc.php');
include('includes/fonctions.inc.php'); 
//var_dump($_POST);
/************************************************************
 * Definition des constantes / tableaux et variables
 *************************************************************/
 
// Constantes
define('TARGET', 'img/');    // Repertoire cible pour l'upload
define('TARGETvgn', 'img/vignettes/');
define('MAX_SIZE', 1000000);    // Taille max en octets du fichier
define('WIDTH_MAX', 1800);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 1800);    // Hauteur max de l'image en pixels
 
// Tableaux de donnees
$tabExt = array('jpg','gif','png','jpeg','bmp');    // Extensions autorisees
$infosImg = array();
 
// Variables
$extension = '';
$message = '';
$nomImage = '';
$id =(int)var_get('id');
  
/************************************************************
 * Creation du repertoire cible si inexistant
 *************************************************************/
if( !is_dir(TARGET) ) {
  if( !mkdir(TARGET, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé !');
  }
}
if( !is_dir(TARGETvgn) ) {
  if( !mkdir(TARGETvgn, 0755) ) {
    exit('Erreur : le répertoire cible ne peut-être créé !');
  }
}
?>
<form enctype="multipart/form-data" action="article.php" method="post">
<?php
//pour la modification
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
				
				If ($id)
					{
						requete_notif("UPDATE articles SET titre='$titre', texte='$texte' WHERE id='$id'",'articles','modifié'); //fonction qui modifie et teste
					}
				elseif (!empty($_FILES['image']))
					{
						requete_notif("INSERT INTO articles (titre, texte) VALUES ('$titre','$texte')",'articles','ajouté'); //fonction ajoute et teste
						$sql=mysql_fetch_array(mysql_query("SELECT id FROM articles WHERE titre='$titre' and texte='$texte'"));
						$id=$sql["id"];
						$insertID=mysql_query("UPDATE articles SET image='$id.jpg' WHERE id='$id'");
					}
					else {
						requete_notif("INSERT INTO articles (titre, texte) VALUES ('$titre','$texte')",'articles','ajouté'); //fonction ajoute et teste
					}
				
				if( !empty($_FILES['image']['name']) )
				  {
				    // Recuperation de l'extension du fichier
				    $extension  = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
				    if($extension == 'jpeg') $extension = 'jpg';
				 
				    // On verifie l'extension du fichier
				    if(in_array(strtolower($extension),$tabExt))
				    {
				      // On recupere les dimensions du fichier
				      $infosImg = getimagesize($_FILES['image']['tmp_name']);
				 
				      // On verifie le type de l'image
				      if($infosImg[2] >= 1 && $infosImg[2] <= 14)
				      {
				        // On verifie les dimensions et taille de l'image
				        if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['image']['tmp_name']) <= MAX_SIZE))
				        {
				          // Parcours du tableau d'erreurs
				          if(isset($_FILES['image']['error']))
				          {
				            // On renomme le fichier
				            $nomImage = $id .'.'. $extension;
				 			$cheminImage= $_FILES['image']['tmp_name'];
				            switch($extension){
    case 'bmp': $imageSource = imagecreatefromwbmp($cheminImage); break;
    case 'gif': $imageSource = imagecreatefromgif($cheminImage); break;
    case 'jpg': $imageSource = imagecreatefromjpeg($cheminImage); break;
    case 'png': $imageSource = imagecreatefrompng($cheminImage); break;
    default : return "Unsupported picture type!";

  }
				              //$imageSource = imagecreatefromjpeg($cheminImage);
				              $imageDestination= imagecreatetruecolor(300, 150);
				              if($extension == "gif" or $extension == "png"){
    imagecolortransparent($imageDestination, imagecolorallocatealpha($imageDestination, 0, 0, 0, 127));
    imagealphablending($imageDestination, false);
    imagesavealpha($imageDestination, true);
  }
				              imagecopyresampled($imageDestination, $imageSource, 0, 0, 0,0, 300, 150, $infosImg[0], $infosImg[1]);
				              if(file_exists(TARGETvgn.$nomImage)) unlink(TARGETvgn.$nomImage);
				              switch($extension){
    case 'bmp': header("Content-Type: image/bmp"); imagewbmp($imageDestination, TARGETvgn.$nomImage,100); break;
    case 'gif': header("Content-Type: image/gif");imagegif($imageDestination, TARGETvgn.$nomImage); break;
    case 'jpg': header("Content-Type: image/jpeg");imagejpeg($imageDestination, TARGETvgn.$nomImage,100); break;
    case 'png': header("Content-Type: image/png");imagepng($imageDestination, TARGETvgn.$nomImage,0); break;
  }
				              //$vignette=imagejpeg($imageDestination,TARGETvgn.$nomImage,100);
				              imagedestroy($imageSource);				              
				            // Si c'est OK, on teste l'upload
				            if(move_uploaded_file($_FILES['image']['tmp_name'], TARGET.$nomImage))
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
				
  
					?><!--<script type="text/javascript">window.location.href='index.php'</script>-->
	<?php 

				header('Location:article.php');
				exit();
				
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
			<div class="input"><textarea name="tags" id="tags"><?php If (isset($data['texte'])) echo $data['texte']; ?></textarea></div> 

	</div>
	<div class="clearfix">
            <label for="image_a_uploader">Ajouter une image :</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
            <input name="image" type="file" id="image_a_uploader">
        
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
<?php
include('includes/bas.inc.php');