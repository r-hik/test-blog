<?php
//Code pour afficher les notifications

	//Création d'une croix por la fermeture des notifications
		$croix = '<a class="cacher_notif" href="#null"> X </a>';

	//Notifications pour l'ajout/modification/suppression/erreur des articles
		if (isset ($_SESSION['articles']))
			{
				switch ($_SESSION['articles'])
					{
						case 'ajouté':
							echo ("<div class='alert alert-success'>L'article a bien été ajouté. $croix</div>");
							break;
						case 'modifié':
							echo ("<div class='alert alert-success'>L'article a bien été modifié. $croix</div>");
							break;
						case 'supprimé':
							echo ("<div class='alert alert-success'>L'article a bien été supprimé. $croix</div>");
							break;
						case 'erreur':
							echo ("<div class='alert alert-error'>Oups! Il y a une erreur. $croix</div>");
							break;
					} 
				unset($_SESSION['articles']);
			}

	//Notifications pour la réussite ou erreurs lors de la connexion
		if(isset($_SESSION['utilisateur']))
			{
				switch ($_SESSION['utilisateur'])
					{
						case 'connecte':
							echo ("<div class='alert alert-success'id='notif'><span>Vous êtes bien connecté.</span> $croix</div>");
							break;
						case 'erreur-login':
							echo ("<div class='alert alert-error' id='notif'><span>Votre couple login/password est faux.</span> $croix</div>");
							break;
						case 'erreur-login-vide':
							echo ("<div class='alert alert-error' id='notif'><span>Veuillez renseigner le champs login.</span> $croix</div>");
							break;
							
						case 'erreur-password-vide':
							echo ("<div class='alert alert-error' id='notif'><span>Veuillez renseigner le champs password.</span> $croix</div>");
							break;
							
						case 'erreur-login-password-vide':
							echo ("<div class='alert alert-error' id='notif'><span>Veuillez renseigner les champs login et password.</span> $croix</div>");
							break;
			
					}
				unset($_SESSION['utilisateur']);
			}
		else 
			{
	 			echo "<div class='alert hide' id='notif'><span></span><a class='cacher_notif' href='#null'> X</a></div>";
	 		}