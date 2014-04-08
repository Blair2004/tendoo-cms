Tendoo-cms
=========
v.0.9.7
---------
MAJ 0.9.7
	- Sur l'item "..theme_handler::define->blogPost()" information "COMMENTS" ajouté afin d'afficher le nombre de commentaires
		d'une publication.
	- Désactivation de l'option "Enable CSRF Protection" sur la classe INPUT. afin d'autoriser l'utilisation de certains
		caractères autrefois interdit tels que "<>#{}" etc.
	- Réduction et début d'annotation du code.
	- Individualisation des paramètres. désormais le changement de thèmes, de l'affichage ou non des statistiques sont individuels et propre à chaque utilisateur.
	- Ajout raccourcis vers application Tendoo
	- Ajout de nouveaux jeux de couleurs (5 jeux de couleurs sont désormais disponible).
	- Accès aux paramètres accésibles à tous les utilisateurs, certains paramètres leur sont masqués et interdit. Sont autorisés :
		- la modification du thème pour les simples administrateurs ou utilisateur ayant un privilège qui permet l'accès à 
		l'espace administration.
	- Ajout de deux nouvelles méthodes dans la classe "file".
		- js_push_if_not_exists() // ajoute un fichier js à la liste des js css chargés si ce fichier n'a pas encore été chargé.
		- css_push_if_not_exists() // ajoute un fichier css à la liste des fichiers css chargés si ce fichier n'a pas encore été chargé.