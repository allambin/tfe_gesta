<?php

$time = new \Maitrepylos\Timetosec();
?>

<?php echo render('prestation/partials/_titre_prestation.php'); ?>

<h3>Gestion des heures de <?php echo $participant ?></h3>

<table class="table_heures_details table-striped table-top table-bordered table-condensed">
    <thead>
        <tr>

            <th>Dates</th>
            <th>Heures</th>
            <th>Motifs</th>
            <th>Contrat</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($heure as $value): ?>
            <tr style="text-align: center">

                <td><?php echo \Maitrepylos\Date::db_to_date($value['d_date']);  ?></td>
                <td><?php echo $time->TimeToString($value['i_secondes'])  ?></td>
                <td><?php echo $value['t_motif'] ?></td>
                <td><?php echo $value['t_type_contrat'] ?></td>
                <td class="del"><?php echo Html::anchor('prestation/delete_details/'.$value['id_heures'].'/'.$value['participant'].'/'.
                        $value['d_date'], Asset::img('remove.png')); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><?php echo Html::anchor('prestation/modifier_participant', '<i class="icon-step-backward"></i> Retour', array('class' => 'btn pull-right')); ?></p>
<div class="clear"></div>