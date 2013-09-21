<?php echo render($partial_dir.'_titre_logins.php'); ?>

<fieldset>
    
    <a href="ajouter_login" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un login</a>
    
    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th>Niveau</th>
            <th>Nom</th>
            <th>Pr&eacute;nom</th>
            <th>Fonction</th>
            <th class="actions"></th>
        </tr>
        <?php
        foreach ($users as $user):
        ?>
        <tr>
            <td><?php echo $user->username; ?></td>
            <td><?php echo $groupes[$user->group]['name']; ?></td>
            <td><?php echo $user->t_nom; ?></td>
            <td><?php echo $user->t_prenom; ?></td>
            <td><?php echo $user->t_acl; ?></td>

            <td class="text-right">
                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create($view_dir.'modifier_login/'.$user->id); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_login/'.$user->id); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce login ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        endforeach;
        ?>
    </table>
    
</fieldset>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>