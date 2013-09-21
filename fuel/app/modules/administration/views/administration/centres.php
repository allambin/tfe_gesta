<?php echo render($partial_dir.'_titre_centres.php'); ?>

<fieldset>
    
    <a href="ajouter_centre" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un centre</a>

    <table class="table table-striped table-top">
        <tr>

            <th>Nom</th>
            <th>Localisation</th>
            <th>Statut</th>
            <th class="actions"></th>

        </tr>
    </table>
    
    <table class="table table-striped table-top" id="table_activite" >

        <?php
        foreach ($centres as $centre):
        ?>
        <tr id="<?php echo $centre->id_centre ?>">
            <td><?php echo $centre->t_responsable; ?></td>
            <td><?php echo $centre->t_nom_centre; ?></td>
            <td class="denomination"><?php echo $centre->t_denomination; ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-primary" href="<?php echo Uri::create('administration/liste_agrement/'); ?>"><i class="icon-eye-open icon-white"></i></a>
                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create('administration/modifier_centre/'.$centre->id_centre); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create('administration/supprimer_centre/'.$centre->id_centre); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce centre ?')"><i class="icon-remove-sign icon-white"></i></a>
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
<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>