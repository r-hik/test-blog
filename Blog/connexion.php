<form style="width:375px" method="POST" name ="identif" class="pull-right">
<?php
$connecte=false;
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

	//traitement du formulaire
	if (isset($_POST["login"])=='identification')
	{
		
		//récuperation des données du formulaire
		$identif = $_POST['identif'];
		$mdp = $_POST['mdp'];
				
		//Préparation de la requête au serveur
		$req="SELECT utilisateur, motdepasse FROM connexion WHERE utilisateur='$identif' AND motdepasse='$mdp';";
		
		//Envoi de la requete et enregistrement du resultat
		$id_req = mysql_query($req);
				
		//tentative de lecture du premier enregistrement
		$data=mysql_fetch_array($id_req, MYSQL_ASSOC);
		//echo "<hr>";
			//echo "Votre nom est ".$ligne[nom]." et votre prénom est ".$ligne[prenom];
			if ($data)
			{
				$sql="SELECT prenom,nom FROM connexion WHERE utilisateur='$identif';";
				$result=mysql_query($sql);
				$data=mysql_fetch_array($result);
				$connexionOK=true;

				$sid=md5($identif.time());
				$sql="UPDATE connexion SET sid='$sid' WHERE utilisateur='$identif' "; 
				$requete=mysql_query($sql);
				setcookie('sid',$sid,time()+15*60);

				?>
						<div class='alert alert-success'>
							Bienvenue <?php echo $data['prenom']." ".$data['nom']; ?>.
						</div>
				<?php
				header('Location:index.php');
				exit();
			}			
	
			else 
			{
				//Affichage d'erreur sur l'un des 2 champs renseignés 
				?>
						<div class='alert alert-error' style='height:10px;margin-bottom:10px'>Verifiez la combinaison pseudo/mot de passe</div>
						<style type="text/css">
					      body {
					        padding-top: 90px;
					      }
					      .nav-collapse{
					      	padding-bottom: 30px;
					      }
					  	</style>
				<?php
						
			}	
					
	}
	//suppression du cookie pour se deconnecter 
	else if(isset($_POST["logout"])=='deconnection')
	{
		setcookie('sid','',0);
		header('Location:index.php');
		exit();
	}
	//si connecte on recupere affiche un message de bienvenue et un bouton deconnexion
	if($connecte)
	{
		$sql="SELECT prenom,nom FROM connexion WHERE sid='".$_COOKIE['sid']."'";
		$result=mysql_query($sql);
		$data=mysql_fetch_array($result);
		echo '<input type="submit" name="valider" value="Se Déconnecter" class="btn-large btn-danger pull-right" style="margin-top:15px" data-toggle="collapse" data-target=".nav-collapse">';
		echo "<h4>Bienvenue ".$data['prenom']." ".$data['nom']."</h4>";
		?>
		<a>Mon compte</a>
		<input type="hidden" name="logout" value="deconnection">	<?php
	}
	//sinon on affiche le formulaire de connexion
	else
	{
	?>

		<!-- Bouton Valider -->
		<input type="submit" name="valider" value="S'identifier" class="btn-large btn-success pull-right" style="margin-top:10px" data-toggle="collapse" data-target=".nav-collapse">
		<!-- champ de type text limité à 20 caractères pour indiquer l'identifiant-->
		<h4>identifiant&nbsp<input type="text" name="identif" maxlength="20" class="span2 pull-right" placeholder="Identifiant" style="margin-right:5px;margin-top:-5px;height:20px;width:110px"></h4>
		<!-- champ de type password limité à 20 caractères-->
		<h4 style="margin-top:-5px">mot de passe&nbsp<input type="password" name="mdp" maxlength="20" class="span2 pull-right" placeholder="Mot de Passe" style="margin-right:5px;margin-top:-20px;height:20px;width:110px"></h4>
		<input type="hidden" name="login" value="identification">	
		
		<?php	
	}	

?>
	<!-- Fin du formulaire-->
	</form>

