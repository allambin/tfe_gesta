<?php echo render($partial_dir.'_titre_types_enseignement.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    
    <legend><?php echo $action; ?> un type d'enseignement</legend>
    
    <div class="control-group">
        <?php echo Form::label('Nom', 't_nom', array('t_nom' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_nom', Input::post('t_nom', isset($type) ? $type->t_nom : '')); ?>
        </div>
    </div>
    
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver le type</button>
</div>

<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_types_enseignement'))); ?>