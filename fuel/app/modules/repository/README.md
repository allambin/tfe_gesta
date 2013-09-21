Pour que ce module fonctionne, il faut faire au minimum 3 actions :

- Ajouter un fichier repository.php dans le dossier fuel/app/config qui contient (à adapter) :

return array(
    'path' => '/home/cranberry/www/gesta-local.be/'
);

- Dans le dossier .git/, il y a un fichier FETCH_HEAD. Il faut que le groupe www-data ait les droits d'écriture dessus.

- Finalement, l'url du repository doit être le git (read-only) et non pas ni le https, ni le ssh. Il y a sans doute moyen de les utiliser, mais je n'ai pas réussi à faire en sorte de passer le nom d'utilisateur et le mot de passe dans l'url.
