<h2>Listes des localisations</h2>


<fieldset>
    
    <a href="<?php echo Uri::create('administration/ajouter_localisation/') ?>" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter une localisation</a>

    <table class="table table-striped table-top" id="table_activite">
        <tr>

            <th>Localisation</th>
            <th class="actions"></th>

        </tr>

        <?php
        foreach ($localisation as $localisations):

        ?>
        <tr id="<?php echo $localisations->id_localisation ?>">
            <td><?php echo $localisations->t_lieu; ?></td>

            <td class="text-right">

                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create('administration/modifier_localisation/'.$localisations->id_localisation); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create('administration/supprimer_localisation/'.$localisations->id_localisation); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce centre ?')"><i class="icon-remove-sign icon-white"></i></a>
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
<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'administration'))); ?>