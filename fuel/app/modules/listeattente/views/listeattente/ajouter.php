<?php echo render($partial_dir . '_titre_listeattente.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>
<fieldset>
    <legend>Informations</legend>
<div class="control-group">
    <?php echo Form::label('Section', 'groupe_id', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::select('groupe_id', 'none', array(
        'none' => '',
        'Section' => $groupes,
    )); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Nom', 't_nom', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_nom', Input::post('t_nom', isset($listeattente) ? $listeattente->t_nom : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Prénom', 't_prenom', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_prenom', Input::post('t_prenom', isset($listeattente) ? $listeattente->t_prenom : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Date de naissance', 'd_date_naissance', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('d_date_naissance', Input::post('d_date_naissance', isset($listeattente) ? $listeattente->d_date_naissance : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Date entretien', 'd_date_entretien', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('d_date_entretien', Input::post('d_date_entretien', isset($listeattente) ? $listeattente->d_date_entretien : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Contact', 't_contact', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_contact', Input::post('t_contact', isset($listeattente) ? $listeattente->t_contact : '')); ?>
    </div>
</div>
</fieldset>
<fieldset>
    <legend>Adresse</legend>
<div class="control-group">
    <?php echo Form::label('Rue', 't_nom_rue', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_nom_rue', Input::post('t_nom_rue', isset($listeattente) ? $listeattente->adresse->t_nom_rue : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Boite', 't_bte', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_bte', Input::post('t_bte', isset($listeattente) ? $listeattente->adresse->t_bte : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Code postal', 't_code_postal', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_code_postal', Input::post('t_code_postal', isset($listeattente) ? $listeattente->adresse->t_code_postal : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Commune', 't_commune', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_commune', Input::post('t_nom_centre', isset($listeattente) ? $listeattente->adresse->t_commune : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Téléphone', 't_telephone', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_telephone', Input::post('t_telephone', isset($listeattente) ? $listeattente->adresse->t_telephone : '')); ?>
    </div>
</div>
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Ajouter le stagiaire</button>
</div>
<?php echo Form::close(); ?>


<script type="text/javascript">
    $.datepicker.setDefaults({
        dateFormat: 'dd-mm-yy',
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
        firstDay: 1
    });
    $(function(){
        $('#form_d_date_naissance').datepicker({
            yearRange: '-100:+10'
        }).attr("readonly","readonly");
    });
    $(function(){
        $('#form_d_date_entretien').datepicker({
            yearRange: '-10:+10'
        }).attr("readonly","readonly");
    });
</script>