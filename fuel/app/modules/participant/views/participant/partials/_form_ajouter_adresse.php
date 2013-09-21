<?php echo Form::open('participant/ajouter_adresse/'.$participant->id_participant, array('class' => 'form-horizontal')); ?> 
<div class="control-group">
    <?php echo Form::label('Rue', 't_nom_rue', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_nom_rue', Input::post('t_nom_rue', isset($adresse) ? $adresse->t_nom_rue : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Bte', 't_bte', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_bte', Input::post('t_bte', isset($adresse) ? $adresse->t_bte : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('CP', 't_code_postal', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_code_postal', Input::post('t_code_postal', isset($adresse) ? $adresse->t_code_postal : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Commune', 't_commune', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_commune', Input::post('t_commune', isset($adresse) ? $adresse->t_commune : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Téléphone', 't_telephone', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_telephone', Input::post('t_telephone', isset($adresse) ? $adresse->t_telephone : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Type', 't_type', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_type', Input::post('t_type', isset($adresse) ? $adresse->t_type : '')); ?>
    </div>
</div>
<?php if(empty($alreadyDefault)): ?>
<div class="control-group">
    <?php echo Form::label('Défaut : Adresse domicile officiel.', 't_courrier', array('class' => 'control-label')); ?> 
    <div class="controls">
    <?php echo Form::checkbox('t_courrier', '1'); ?>
    </div>
</div>
<?php endif; ?>
<div class="form-actions">
    <button type="submit" class="btn btn-success">Créer l'adresse</button>
</div>
<?php echo Form::close(); ?>