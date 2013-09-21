<?php echo render($partial_dir . '_titre_listeattente.php'); ?>

<h3>Sections de la liste d'attente</h3>

<a class="btn btn-success pull-right" href="<?php echo Uri::create($view_dir . 'ajouter_section'); ?>"><i class="icon-tag icon-white"></i> Nouvelle section</a>

<?php if ($checklist_sections): ?>
    <table class="table table-striped table-top">
        <thead>
            <tr>
                <th>Nom</th>
                <th class="actions"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($checklist_sections as $checklist_section): ?>		
                <tr>
                    <td><?php echo $checklist_section->t_nom; ?></td>
                    <td class="text-right">
                        <a class="btn btn-mini btn-warning" href="<?php echo Uri::create($view_dir . 'modifier_section/' . $checklist_section->id_checklist_section); ?>"><i class="icon-edit icon-white"></i></a>
                        <a class="btn btn-mini btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette section ?')" href="<?php echo Uri::create($view_dir . 'supprimer_section/' . $checklist_section->id_checklist_section); ?>"><i class="icon-remove-sign icon-white"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>	
        </tbody>
    </table>

<?php else: ?>
    <p>Aucune section n'a encore été crée.</p>

<?php endif; ?>

<?php echo render($partial_dir . '_back.php'); ?>