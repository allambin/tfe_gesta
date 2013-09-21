<h2>Listes des agréments</h2>



<fieldset>
    
    <a href="<?php echo Uri::create('administration/ajouter_filiere/') ?>" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un agréments</a>

    <table class="table table-striped table-top" id="table_activite">
        <tr>

            <th>Agrément</th>
            <th>Origine</th>
            <th>Responsable</th>
            <th>Centre</th>
            <th class="actions"></th>

        </tr>

        <?php
        foreach ($agrement as $agrements):
            //\Debug::dump($agrements->centres->t_nom_centre)
        ?>
        <tr id="<?php echo $agrements->id_agrement ?>">
            <td><?php echo $agrements->t_agrement; ?></td>
            <td><?php echo $agrements->t_origine_agrement; ?></td>
            <td class="denomination"><?php echo $agrements->users->username; ?></td>
            <td class="denomination"><?php echo $agrements->centres->t_nom_centre; ?></td>
            <td class="text-right">

                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create('administration/modifier_agrement/'.$agrements->id_agrement); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create('administration/supprimer_agrement/'.$agrements->id_agrement); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce centre ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        endforeach;
        ?>
    </table>
    
</fieldset>
<?php echo Asset::js('jquery.tablednd.0.7.min.js'); ?>

    <script type="text/javascript">
        $('#table_activite').tableDnD({
            onDrop: function (table, row) {
                var order = $.tableDnD.serialize();
                $.post('liste_centres', order);
            }
        });
    </script>
<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_centres'))); ?>