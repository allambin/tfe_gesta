<?php echo render($partial_dir.'_titre_types_subside.php'); ?>

<fieldset>
    
    <a href="ajouter_subside" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un subside</a>
    
    <table class="table table-top table-striped">
        <tr>
            <th>Nom</th>
            <th class="actions"></th>
        </tr>
        <?php

        foreach ($subside as $type):
        ?>
        <tr>
            <td><?php echo $type['t_nom']; ?></td>

            <td class="text-right">
                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create($view_dir.'modifier_subside/'.$type['id_subside']); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_subside/'.$type['id_subside']); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce type de contrat ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        endforeach;
        ?>
    </table>
    
</fieldset>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>