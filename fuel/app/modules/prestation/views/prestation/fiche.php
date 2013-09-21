<script type="text/javascript">
    $(function () {
        var projects = [
            <?php foreach ($participants_autocomplete as $participants): ?>
            {
                value: '<?php echo $participants->id_participant; ?>',
                label: '<?php echo $participants->t_nom . ' ' . $participants->t_prenom; ?>'
            },
            <?php endforeach; ?>
        ];

        $('#form1_nom').autocomplete({
            minLength: 0,
            source: projects,
            select: function (event, ui) {
                $('#form1_nom').val(ui.item.label);
                $('#form1_idparticipant').val(ui.item.value);
                return false;
            }
        })

    });
</script>

<?php //echo render('prestation/partials/_titre_prestation.php'); ?>

<div class="row-fluid">
<?php echo Form::open(array('action' => 'prestation/change_participant', 'class' => 'form_heures right')); ?>


    <div class="span4" style="font-size: 16px">Gestion des heures de <?php echo Html::anchor('participant/modifier/' .
            $id_participant, $participant) ?></div>
    <div class="span4">
        <?php $date = \Session::get('date_prestation'); ?>
        <?php echo Form::label('Autre mois', 'participant'); ?>
        <?php echo Form::select('mois',null, array(
                '01' => 'Janvier',
                '02' => 'Février',
                '03' => 'Mars',
                '04' => 'Avril',
                '05' => 'Mai',
                '06' => 'Juin',
                '07' => 'Juillet',
                '08' => 'Aout',
                '09' => 'Septembre',
                '10' => 'Octobre',
                '11' => 'Novembre',
                '12' => 'Décembre'
        )); ?>

        <?php echo Form::hidden('idparticipant', $id_participant); ?>
        <?php echo Form::hidden('annee',$date->format('Y')); ?>

        <?php echo Form::submit('submit_choix', 'Suivant', array('class' => 'btn btn-success btn-mini')); ?>
        <?php echo Form::close(); ?>
    </div>

    <div class="span4">
    <?php echo Form::open(array('action' => 'prestation/', 'class' => 'form_heures right')); ?>


    <?php echo Form::label('Autre participant', 'participant'); ?>
        <?php echo Form::input('nom', '', array('required' => 'required','id'=>'form1_nom')); ?>
        <?php echo Form::hidden('idparticipant', '',array('id'=>'form1_idparticipant')); ?>
        <?php echo Form::hidden('annee',$date->format('Y')); ?>
        <?php echo Form::hidden('mois', $date->format('m')); ?>

        <?php echo Form::submit('submit_choix', 'Suivant', array('class' => 'btn btn-success btn-mini')); ?>
        <?php echo Form::close(); ?>
    </div>
</div>




<table class="table table-striped table-top">
    <thead>
    <tr>
        <th>Heures à effectuer ce mois (en fonction de son temps de travail)</th>
        <th>Heures Prestées ce mois</th>
        <th>Heures à prester/récupérer</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo Html::anchor('prestation/modifier', Asset::img('edit.png')) ?> <?php echo $heure_prester ?> </td>
        <td><?php echo $total_heures_prester ?></td>
        <td><?php echo \Maitrepylos\Helper::time()->TimeToString($total_heures_recup) ?></td>
    </tr>
    </tbody>
</table>

<div class="row-fluid">
    <div class="span8">

        <?php if ($control === 0): ?>

            <?php echo Form::open(array('name' => 'ajout', 'class' => 'form_heures')); ?>

            <strong>Modifieur</strong> DU
            <?php echo Form::input('date[]', isset($modifieur->date1) ? $modifieur->date1 : '' , array('size' => '2', 'id' => "date")) ?>
            AU
            <?php echo Form::input('date[]', isset($modifieur->date2) ? $modifieur->date2 : '', array('size' => '2')) ?>
            <strong>Motif</strong>
            <?php echo Form::select('motif', isset($modifieur->motif) ? $modifieur->motif : '', $motifs) ?>
            <strong>Heures</strong>
            <?php echo Form::input('heuresprester', isset($modifieur->heureprester) ? $modifieur->heureprester : '', array('size' => '5')) ?>

            <p>

                <?php echo Form::radio('action', '1', array('checked' => 'checked')) ?>
                <?php echo Form::label('Ajouter', 'action'); ?>

                <?php echo Form::radio('action', '0') ?>
                <?php echo Form::label('Remplacer', 'action'); ?>

                <?php // echo Form::checkbox('heures_formateurs', '1') ?>
                <?php // echo Form::label('Heures formateurs', 'heures_formateurs'); ?>

                <?php echo Form::select('t_typecontrat', '', $contrats) ?>
                <?php echo Form::label('Contrat', 't_typecontrat'); ?>
                <?php echo Form::submit('submit_choix', 'Appliquer', array('class' => 'btn btn-success btn-mini')); ?>
            </p>
            <?php echo Form::close(); ?>
            <div>

                <?php echo Html::anchor('prestation/est_valide', '<i class="icon-ok icon-white"></i> Valider le mois',
                    array('class' => 'btn btn-success')) ?>
                <?php echo Html::anchor('prestation/est_valide_formateur', '<i class="icon-user icon-white"></i>Valider les heures formateurs',
                    array('class' => 'btn btn-info')) ?>
            </div>
        <?php else: ?>
            <div>
                <h2>Le mois &agrave; &eacute;t&eacute; valid&eacute;.</h2>

                <h2>Vous pouvez modifer en cliquant sur le bouton.</h2>

                <h2>ATTENTION, il faudra re-valider!!!</h2>
                <?php echo Html::anchor('prestation/supprime_valide', '<i class="icon-hand-left icon-white"></i> Acceder',
                    array('class' => 'btn btn-danger')) ?>
                <?php echo \Fuel\Core\Html::anchor('document/fichepaye/' . $prester[1]['id_participant'] . '/' . $prester[1]['date'], '<i class="icon-print icon-white"></i> Impression',
                    array('class' => 'btn btn-info')) ?>

            </div>

        <?php endif; ?>
    </div>

    <div class="span4">

        <?php echo Form::open(array('action' => 'prestation/ajout_deplacement', 'class' => 'form_heures right')); ?>

        <?php echo Form::label('Supplément de déplacement', 'supplement'); ?>
        <?php echo Form::input('supplement', '', array('size' => '5')) ?>€
        <?php echo Form::submit('submit_choix', 'Suivant', array('class' => 'btn btn-success btn-mini')); ?>

        <?php echo Form::close(); ?>
    </div>
</div>

<h3 class="space">Heures prestées ce mois</h3>
<?php $i = 1;
$a = 0;
?>
<?php
foreach($prester as $value):
    $color = 'green';

    if ($value[0]['t_schema'] == '%' || $value[0]['t_schema'] == '-' || $value[0]['t_schema'] == '/') {
        $color = '#c09853';
    } elseif ($value[0]['t_schema'] == '*') {
        $color = 'red';
    } elseif ($value[0]['i_secondes'] == '00:00:00') {
        $color = NULL;
    };

    if ($i % 7 === 1) {
        echo "</tbody>";
        echo "</table>";
        $a = 0;
    }
    if ($a === 0) {
        echo "<table class=\"table_heures table-striped table-top table-bordered table-condensed\">";
        echo "<thead>";
        echo "<tr>";
        echo "<th></th>";
        echo "<th>Jour</th>";
        echo "<th>Dates</th>";
        echo "<th>Heures</th>";
        echo "<th>Actions</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $a = 1;
    }
    ?>



    <tr>

        <td class="text-right">
            <?php if ($control === 0) {

                if ($value[0]['formateur'] === '1') {

                    echo Html::anchor('prestation/formateur/' . $value[0]['participant_id'] . '/' . $value[0]['d_date']
                        , '<i class="icon-user icon-white"></i>', array('class' => 'btn btn-mini btn-info'));
                } elseif ($value[0]['participant_id'] != null) {
                    echo Html::anchor('prestation/ajout/' . $value[0]['participant_id'] . '/' . $value[0]['d_date']
                        , '<i class="icon-edit icon-white"></i>', array('class' => "btn btn-mini btn-warning"));
                } else {


                    echo Html::anchor('prestation/ajout/' . $value['id_participant'] . '/' . \Maitrepylos\Date::date_to_db($value[0]['dateFormater'])
                        , '<i class="icon-plus-sign icon-white"></i>', array('class' => "btn btn-mini btn-success"));
                }
            }
            ?>

        </td>
        <?php
        if ($value[0]['jour'] === 'samedi' || $value[0]['jour'] === 'dimanche') {
            echo "<td style=\"background-color: #90EE90\">" . ucfirst($value[0]['jour']) . "</td>";
        } else {
            echo "<td>" . $value[0]['jour'] . "</td>";
        }
        ?>
        <td><?php echo $value[0]['dateFormater'] ?></td>
        <td style="color: <?php echo $color ?>"><b><?php echo $value[0]['i_secondes'] ?></b></td>
        <td style="text-align: center">
            <?php if ($value[0]['i_secondes'] !== '00:00:00') {
                echo Html::anchor('prestation/supprimer/' . $value[0]['participant_id'] . '/' . $value[0]['d_date'], '<i class="icon-remove-sign icon-white"></i>'
                    , array('onclick' => "return confirm('Etes-vous sûr de vouloir supprimer ces heures ?')", 'class' => "btn btn-mini btn-danger"));
            }
            ?></td>
    </tr>
    <?php $i++ ?>
<?php endforeach; ?>
</tbody>
</table>


<div class="clear"></div>