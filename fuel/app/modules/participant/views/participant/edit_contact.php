<h1>Modifier un contact</h1> 
<?php echo Form::open($view_dir . 'modifier_contact/'.$contact->id_contact); ?> 
<p>
    <?php echo Form::label('Type', 't_type'); ?>
    <?php echo Form::input('t_type', Input::post('t_type', isset($contact) ? $contact->t_type : '')); ?>
</p>
<p>
    Pro. <?php
    if (in_array('urgence', $contact->t_cb_type)) {
        echo Form::checkbox('t_cb_type[]', 'pro', array('checked' => 'checked'));
    } else {
        echo Form::checkbox('t_cb_type[]', 'pro');
    }
    ?> 
    Famille <?php
    if (in_array('famille', $contact->t_cb_type)) {
        echo Form::checkbox('t_cb_type[]', 'famille', array('checked' => 'checked'));
    } else {
        echo Form::checkbox('t_cb_type[]', 'famille');
    }
    ?> 
    Urgence <?php
    if (in_array('urgence', $contact->t_cb_type)) {
        echo Form::checkbox('t_cb_type[]', 'urgence', array('checked' => 'checked'));
    } else {
        echo Form::checkbox('t_cb_type[]', 'urgence');
    }
    ?> 
</p>
<p>
    <?php echo Form::label('Civilité', 't_civilite'); ?>
    <?php echo Form::select('t_civilite', Input::post('t_civilite', isset($contact) ? $contact->t_civilite : ''), array('' => '', 'Monsieur' => 'Monsieur', 'Madame' => 'Madame')); ?>
</p>
<p>
    <?php echo Form::label('Nom', 't_nom'); ?>
    <?php echo Form::input('t_nom', Input::post('t_nom', isset($contact) ? $contact->t_nom : '')); ?>
</p>
<p>
    <?php echo Form::label('Prénom', 't_prenom'); ?>
    <?php echo Form::input('t_prenom', Input::post('t_prenom', isset($contact) ? $contact->t_prenom : '')); ?>
</p>
<p>
    <?php echo Form::label('Rue', 't_nom_rue'); ?>
    <?php echo Form::input('t_nom_rue', Input::post('t_nom_rue', isset($contact) ? $contact->adresse->t_nom_rue : '')); ?>
</p>
<p>
    <?php echo Form::label('Bte', 't_bte'); ?>
    <?php echo Form::input('t_bte', Input::post('t_bte', isset($contact) ? $contact->adresse->t_bte : '')); ?>
</p>
<p>
    <?php echo Form::label('CP', 't_code_postal'); ?>
    <?php echo Form::input('t_code_postal', Input::post('t_code_postal', isset($contact) ? $contact->adresse->t_code_postal : '')); ?>
</p>
<p>
    <?php echo Form::label('Commune', 't_commune'); ?>
    <?php echo Form::input('t_commune', Input::post('t_commune', isset($contact) ? $contact->adresse->t_commune : '')); ?>
</p>
<p>
    <?php echo Form::label('Téléphone', 't_telephone'); ?>
    <?php echo Form::input('t_telephone', Input::post('t_telephone', isset($contact) ? $contact->adresse->t_telephone : '')); ?>
</p>
<div class="form-actions">
    <button type="submit" class="btn btn-success">Modifier le contact</button>
</div>
<?php echo Form::close(); ?>