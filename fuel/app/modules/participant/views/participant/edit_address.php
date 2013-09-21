<h1>Modifier une adresse</h1> 
<?php echo Form::open($view_dir . 'modifier_adresse/'.$adresse->id_adresse); ?>
<p>
    <?php echo Form::label('Rue', 't_nom_rue'); ?>
    <?php echo Form::input('t_nom_rue', Input::post('t_nom_rue', isset($adresse) ? $adresse->t_nom_rue : '')); ?>
</p>
<p>
    <?php echo Form::label('Bte', 't_bte'); ?>
    <?php echo Form::input('t_bte', Input::post('t_bte', isset($adresse) ? $adresse->t_bte : '')); ?>
</p>
<p>
    <?php echo Form::label('CP', 't_code_postal'); ?>
    <?php echo Form::input('t_code_postal', Input::post('t_code_postal', isset($adresse) ? $adresse->t_code_postal : '')); ?>
</p>
<p>
    <?php echo Form::label('Commune', 't_commune'); ?>
    <?php echo Form::input('t_commune', Input::post('t_commune', isset($adresse) ? $adresse->t_commune : '')); ?>
</p>
<p>
    <?php echo Form::label('Téléphone', 't_telephone'); ?>
    <?php echo Form::input('t_telephone', Input::post('t_telephone', isset($adresse) ? $adresse->t_telephone : '')); ?>
</p>
<p>
    <?php echo Form::label('Type', 't_type'); ?>
    <?php echo Form::input('t_type', Input::post('t_type', isset($adresse) ? $adresse->t_type : '')); ?>
</p>
<p>
    <?php echo Form::label('Défaut', 't_courrier'); ?>
    <?php echo ($adresse->t_courrier==1) ? Form::checkbox('t_courrier', '1', array('checked' => 'checked')) : Form::checkbox('t_courrier', '1'); ?>
</p>
<div class="form-actions">
    <button type="submit" class="btn btn-success">Modifier l'adresse</button>
</div>
<?php echo Form::close(); ?>