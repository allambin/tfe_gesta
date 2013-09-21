<?php echo render($partial_dir . '_titre_listeattente.php'); ?>

<h3>Valeurs de la liste d'attente</h3>

<a class="btn btn-success pull-right" href="<?php echo Uri::create('listeattente/ajouter_valeur'); ?>"><i class="icon-tag icon-white"></i> Nouvelle valeur</a>

<table class="table table-striped table-top">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Section</th>
            <th class="actions"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($valeurs as $valeur): ?>		
            <tr>
                <td><?php echo $valeur->t_nom; ?></td>
                <td><?php echo $valeur->section->t_nom; ?></td>
                <td class="text-right">
                    <a class="btn btn-mini btn-warning" href="<?php echo Uri::create($view_dir . 'modifier_valeur/' . $valeur->id_checklist_valeur); ?>"><i class="icon-edit icon-white"></i></a>
                    <a class="btn btn-mini btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette valeur ?')" href="<?php echo Uri::create($view_dir . 'supprimer_valeur/' . $valeur->id_checklist_valeur); ?>"><i class="icon-remove-sign icon-white"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>	
    </tbody>
</table>

<?php echo render($partial_dir . '_back.php'); ?>