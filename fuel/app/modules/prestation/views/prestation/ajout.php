<?php //echo render('prestation/partials/_titre_prestation.php'); ?>

<?php echo Form::open(array('name' => 'formateur',
'action' => 'prestation/ajout/' . $id . '/' . $date, 'class' => 'form_heures')); ?>


<table class="table_heures_details table-striped table-top table-bordered table-condensed">
    <tr>
        <th colspan="2"><h2>Ajout des heures pour <?php echo $participant." (". \Maitrepylos\Date::db_to_date($date).")"  ?></h2></th>

    </tr>
    <tr>
        <td><strong>Motif</strong></td>

        <td><?php echo Form::select('motif', '', $motifs) ?></td>
    </tr>
    <tr>
        <td><strong>Heures</strong></td>
        <td> <?php echo Form::input('heuresprester', '07:30', array('size' => '5')) ?></td>
    </tr>
    <tr>
        <td><?php echo Form::label('Contrat', 't_typecontrat'); ?></td>
        <td><?php echo Form::select('t_typecontrat', '', $contrats) ?></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo Form::submit('submit_choix', 'Appliquer'); ?> </td>
    </tr>
    <?php echo Form::close(); ?>


</table>

<?php
$time = new \Maitrepylos\Timetosec();
?>
<h3>Heures déjà insérées</h3>
<table class="table_heures_details table-striped table-top table-bordered table-condensed">
    <tbody>
    <tr>
        <th>Dates</th>
        <th>Heures</th>
        <th>Motifs</th>
        <th>Contrats</th>
        <th>Formateur</th>
        <th>Supprimer</th>
    </tr>

    <?php foreach($heure as $value): ?>





        <tr style="text-align: center">
            <!--        <td class="del">-->
            <!--            --><?php //echo Html::anchor('prestation/ajout/' . $value['participant'] . '/' . $value['d_date']
            //            , '<i class="icon-plus-sign icon-white"></i>', array('class' => "btn btn-mini btn-success"));
            //            ?>
            <!--        </td>-->

            <td><?php echo \Maitrepylos\Date::db_to_date($value['d_date']);  ?></td>
            <td><?php echo $time->TimeToString($value['i_secondes'])  ?></td>
            <td><?php echo $value['t_motif'] ?></td>
            <td><?php echo $value['t_type_contrat'] ?></td>
            <td><?php echo $value['username']?></td>
            <td class="del"><?php echo Html::anchor('prestation/delete_details/' . $value['id_heures'] . '/' . $value['participant_id'] . '/' .
            $value['d_date'], '<i class="icon-remove-sign icon-white"></i>',
                    array('onclick' => "return confirm('Etes-vous sûr de vouloir supprimer ces heures ?')", 'class' => "btn btn-mini btn-danger"));?></td>
        </tr>



    <?php endforeach; ?>

</table>

<p><?php echo Html::anchor('prestation/modifier_participant', '<i class="icon-step-backward"></i> Retour', array('class' => 'btn pull-right')); ?></p>
<div class="clear"></div>