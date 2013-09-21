<h2>Listes des filères</h2>



<fieldset>
    
    <a href="<?php echo Uri::create('administration/ajouter_filiere/') ?>" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter une filière</a>

    <table class="table table-striped table-top" id="table_activite">
        <tr>

            <th>Filière</th>
            <th>Code Forem</th>
            <th>Code cedefop</th>
            <th>Agrément</th>
            <th class="actions"></th>

        </tr>

        <?php
        foreach ($filiere as $filieres):

        ?>
        <tr id="<?php echo $filieres->id_filiere ?>">
            <td><?php echo $filieres->t_nom; ?></td>
            <td><?php echo $filieres->t_code_forem; ?></td>
            <td class="denomination"><?php echo $filieres->i_code_cedefop; ?></td>
            <td class="denomination"><?php echo $filieres->agrements->t_agrement; ?></td>
            <td class="text-right">

                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create('administration/modifier_filiere/'.$filieres->id_filiere); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create('administration/supprimer_filiere/'.$filieres->id_filiere); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer cette filière ?')"><i class="icon-remove-sign icon-white"></i></a>
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