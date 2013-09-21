<?php echo Form::open('participant/ajouter_contact/'.$participant->id_participant, array('class' => 'form-horizontal')); ?>
<div class="control-group">
    <?php echo Form::label('Type', 't_type', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_type', Input::post('t_type', isset($contact) ? $contact->t_type : '')); ?>
    </div>
</div>
<div class="control-group">
    Pro. <?php echo Form::checkbox('t_cb_type[]', 'pro', array('class' => 'control-label')); ?> 
    Famille <?php echo Form::checkbox('t_cb_type[]', 'famille'); ?> 
    Urgence <?php echo Form::checkbox('t_cb_type[]', 'urgence'); ?> 
</div>
<div class="control-group">
    <?php echo Form::label('Civilité', 't_civilite', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::select('t_civilite', Input::post('t_civilite', isset($contact) ? $contact->t_civilite : ''), array('' => '', 'Monsieur' => 'Monsieur', 'Madame' => 'Madame')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Nom', 't_nom', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_nom', Input::post('t_nom', isset($contact) ? $contact->t_nom : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Prénom', 't_prenom', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_prenom', Input::post('t_prenom', isset($contact) ? $contact->t_prenom : '')); ?>
    </div>
</div>
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
    <?php echo Form::label('Email', 't_email', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_email', Input::post('t_email', isset($adresse) ? $adresse->t_email : '')); ?>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn btn-success">Créer le contact</button>
</div>
<?php echo Form::close(); ?>