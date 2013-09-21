<?php
$time = new \Maitrepylos\Timetosec();
?>

<?php //echo render('prestation/partials/_titre_prestation.php'); ?>

    <h3>Modification des heures de <?php echo $participant." (". \Maitrepylos\Date::db_to_date($heure[0]['d_date']).")"  ?></h3>
    <h3>Heures introduites par le formateur (à valider)</h3>
    <table class="table_heures_details table-striped table-top table-bordered table-condensed">
        <tbody>
        <tr>

            <th>Dates</th>
            <th>Heures</th>
            <th>Motifs</th>
            <th>Contrats</th>
            <th>Formateur</th>
            <th></th>
        </tr>

        <?php foreach($heure as $value): ?>


            <?php if ($value['formateur'] == 1): ?>


                <tr style="text-align: center">

                    <td><?php echo \Maitrepylos\Date::db_to_date($value['d_date']);  ?></td>
                    <td><?php echo $time->TimeToString($value['i_secondes'])  ?></td>
                    <td><?php echo $value['t_motif'] ?></td>
                    <td><?php echo $value['t_type_contrat'] ?></td>
                    <td><?php echo $value['username']?></td>
                    <td class="text-right"><?php echo Html::anchor('prestation/delete_details/' . $value['id_heures'] . '/' . $value['participant_id'] . '/' .
                            $value['d_date'], Asset::img('remove.png')); ?></td>
                </tr>
            <?php endif; ?>


        <?php endforeach; ?>

    </table>

<?php foreach($heure as $value): ?>
    <?php if ($value['formateur'] == 1): ?>


        <table class="table_heures_details table-striped table-top table-bordered table-condensed">
            <tr>
                <th colspan="2"><h2>Heures introduites par les formateurs :</h2></th>
                <?php echo Form::open(array('name' => 'formateur', 'class' => 'form_heures',
                    'action' => 'prestation/formateur/' . $value['participant_id'] . '/' . $value['d_date'])); ?>
                <?php echo Form::hidden('id_heures', $value['id_heures']) ?>
            </tr>
            <tr>
                <td><strong>Motif</strong></td>

                <td><?php echo Form::select('motif', '', $motifs) ?></td>
            </tr>
            <tr>
                <td><strong>Heures</strong></td>
                <td><?php echo Form::input('heuresprester', $time->TimeToString($value['i_secondes']), array('size' => '5')) ?></td>
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


    <?php endif; ?>


<?php endforeach; ?>

<h3>Heures déjà introduites</h3>

    <table class="table_heures_details table-striped table-top table-bordered table-condensed">
        <tbody>
        <tr>
<!--            <th>--><?php //echo Html::anchor('prestation/ajout/' . $value['participant_id'] . '/' . $value['d_date']
//                    , '<i class="icon-plus-sign icon-white"></i>', array('class' => "btn btn-mini btn-success"));
//                ?><!--</th>-->
            <th></th>
            <th>Dates</th>
            <th>Heures</th>
            <th>Motifs</th>
            <th>Contrats</th>
            <th>Formateur</th>
            <th></th>
        </tr>

        <?php foreach($heure as $value): ?>


            <?php if ($value['formateur'] == 0): ?>


                <tr style="text-align: center">
                    <td>
                    </td>

                    <td><?php echo \Maitrepylos\Date::db_to_date($value['d_date']);  ?></td>
                    <td><?php echo $time->TimeToString($value['i_secondes'])  ?></td>
                    <td><?php echo $value['t_motif'] ?></td>
                    <td><?php echo $value['t_type_contrat'] ?></td>
                    <td><?php echo $value['username']?></td>
                    <td class="text-right"><?php echo Html::anchor('prestation/delete_details/' . $value['id_heures'] . '/' . $value['participant_id'] . '/' .
                            $value['d_date'], Asset::img('remove.png')); ?></td>
                </tr>
            <?php endif; ?>


        <?php endforeach; ?>

    </table>









<?php
echo Html::anchor('prestation/modifier_participant', 'Retour');


?>