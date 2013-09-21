<?php echo render($partial_dir.'_titre_types_contrat.php'); ?>

<fieldset>
    
    <a href="ajouter_type_contrat" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un type</a>
    
    <table class="table table-top table-striped" >
        <tr>
            <th>Nom</th>
            <th>Heures</th>
            <th>Actif</th>
            <th>Payement</th>
            <th>R&eacute;gion Walonne</th>
            <th class="actions"></th>
        </tr>
        </table>
    <table class="table table-top table-striped" id="table_type_contrat">
        <?php
        $time = new \Maitrepylos\Timetosec();
        foreach ($types as $type):
        ?>
        <tr id="<?php echo $type['id_type_contrat'] ?>">
            <td><?php echo $type['t_type_contrat']; ?></td>
            <td><?php echo $time->TimeToString($type['i_heures']) ?></td>
            <td class="valeur"><?php echo ($type['b_type_contrat_actif'] == 1) ? "Oui" : "Non"; ?></td>

            <td><?php echo ($type['i_paye'] == 1) ? "Oui" : "Non"; ?></td>

            <td><?php echo $type['t_nom'] ; ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create($view_dir.'modifier_type_contrat/'.$type['id_type_contrat']); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_type_contrat/'.$type['id_type_contrat']); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce type de contrat ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        endforeach;
        ?>
    </table>
    
</fieldset>

<?php echo Asset::js('jquery.tablednd.0.7.min.js'); ?>

<script type="text/javascript">
    $('#table_type_contrat').tableDnD({
        onDrop: function(table,row) {
            var order = $.tableDnD.serialize();
            $.post('liste_types_contrat', order);
        }
    });
</script>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>
