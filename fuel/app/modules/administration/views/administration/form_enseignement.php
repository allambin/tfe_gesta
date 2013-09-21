<?php echo render($partial_dir.'_titre_enseignements.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend><?php echo $action ?> un item</legend>
    
    <div class="control-group">
        <?php echo Form::label('Nom', 't_nom', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_nom', Input::post('t_nom', isset($enseignement) ? $enseignement->t_nom : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Valeur', 't_valeur', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_valeur', Input::post('t_valeur', isset($enseignement) ? $enseignement->t_valeur : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Type d\'enseignement', 'type_enseignement_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('type_enseignement_id', Input::post('type_enseignement_id', isset($enseignement) ? $enseignement->type_enseignement_id : $id_type), $types); ?>
        </div>
    </div>


</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver l'item</button>
</div>

<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_enseignements'))); ?>