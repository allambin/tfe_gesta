<script>
    // Fonction datepicker pour la date de naissance
    $(function () {
        $('#datefin').datepicker({
            dateFormat: 'dd/mm/yy',
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
            firstDay: 1,
            yearRange: '-100:+10'
        });
    });
</script>

<h2>Fin de contrat de <?php echo $participant->t_nom.' '.$participant->t_prenom ?> </h2>


<?php echo Form::open() ?>
<div>
    <?php echo Form::label('Fin de formation') ?>
    <?php echo Form::select('t_fin_formation', Input::post('t_fin_formation', isset($formation) ? $formation->t_fin_formation : ''), $select_formation) ?>
    <?php //echo Form::select('t_fin_formation','' , $select_formation) ?>


</div>


<div>
    <?php echo Form::label('Date de sortie') ?>
    <?php echo Form::input('d_date_fin_formation', Input::post('d_date_fin_formation', isset($formation) ? \Maitrepylos\Date::db_to_date($formation->d_date_fin_formation)
    : date('d/m/Y')), array('id'=>'datefin', 'required' => 'required')) ?>
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Fin du contrat</button>
</div>

<?php echo Form::close() ?>