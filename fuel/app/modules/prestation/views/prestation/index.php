<script type="text/javascript">
$(function() {
    var projects = [
        <?php foreach($participants as $participant): ?>
        {
            value: '<?php echo $participant->id_participant; ?>',
            label: '<?php echo $participant->t_nom.' '.$participant->t_prenom; ?>'
        },
        <?php endforeach; ?>
    ];

    $('#form_nom').autocomplete({
        minLength: 0,
        source: projects,
        select: function(event, ui) {
            $('#form_nom').val(ui.item.label);
            $('#form_idparticipant').val(ui.item.value);
            return false;
        }
    })

});
</script>

<?php echo render('prestation/partials/_titre_prestation.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

    <fieldset>
        <legend>Choisir un participant</legend>

        <div class="control-group">
            <?php echo Form::label('Nom', 'nom', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php echo Form::input('nom', '',array('required'=>'required')); ?>
            </div>
            <?php echo Form::hidden('idparticipant', ''); ?>
        </div>
        
        <div class="control-group">
            <?php echo Form::label('Année', 'annee', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php echo Form::select('annee', date('Y'), $annees) ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Form::label('Mois', 'mois', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php echo Form::select('mois', date('m'), $mois) ?>
            </div>
        </div>
        
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn btn-success">Suivant</button>
    </div>

<?php echo Form::close(); ?>