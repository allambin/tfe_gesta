<?php echo render($partial_dir.'_titre_listeattente.php'); ?>

<a href="<?php echo $view_dir; ?>ajouter" class="btn btn-success pull-right"><i class="icon-user icon-white"></i> Ajouter un stagiaire</a>
<a href="<?php echo $view_dir; ?>section" class="btn btn-success pull-right"><i class="icon-tag icon-white"></i> Gérer les sections</a>
<a href="<?php echo $view_dir; ?>valeur" class="btn btn-success pull-right"><i class="icon-list icon-white"></i> Gérer les valeurs</a>

<table class="table table-striped table-top">
    <thead>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Groupe</th>
    <th>Date naissance</th>
    <th>Adresse</th>
    <th>Contact</th>
    <th>Date entretien</th>
    <th></th>
    </thead>
    <tbody>
        <?php foreach ($stagiaires as $stagiaire): ?>
        <tr>
            <td><?php echo $stagiaire->t_nom; ?></td>
            <td><?php echo $stagiaire->t_prenom; ?></td>
            <td><?php echo $stagiaire->groupe->t_nom; ?></td>
            <td><?php echo date('d-m-Y', strtotime($stagiaire->d_date_naissance)); ?></td>
            <td><?php echo $stagiaire->adresse->getFullAddress(); ?></td>
            <td><?php echo $stagiaire->t_contact; ?></td>
            <td><?php echo date('d-m-Y', strtotime($stagiaire->d_date_entretien)); ?></td>
            <td>
                <a class="btn btn-mini btn-success" title="Valider le stagiaire" href="<?php echo Uri::create($view_dir . 'confirmer/'.$stagiaire->id_liste_attente); ?>"><i class="icon-ok icon-white"></i></a>
                <a class="btn btn-mini btn-danger" title="Supprimer le stagiaire" href="<?php echo Uri::create($view_dir . 'supprimer/'.$stagiaire->id_liste_attente); ?>"><i class="icon-remove-sign icon-white"></i></a>
                <a class="btn btn-mini btn-info" title="Editer la checklist" href="<?php echo Uri::create($view_dir . 'checklist/'.$stagiaire->id_liste_attente); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-warning" title="Imprimer la checklist" href="<?php echo Uri::create($view_dir . 'print_checklist/'.$stagiaire->id_liste_attente); ?>"><i class="icon-print icon-white"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

