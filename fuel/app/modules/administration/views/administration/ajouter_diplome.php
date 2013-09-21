<?php echo render($partial_dir.'_titre_diplomes.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend>Ajouter un type/diplôme</legend>

    <div class="control-group">
        <?php echo Form::label('Nom', 'nom', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('nom', Input::post('nom')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Valeur', 'valeur', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('valeur', Input::post('valeur')); ?>
        </div>
    </div>
    
</fieldset>    
    
<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver le diplôme/le type détudes</button>
</div>

<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_diplomes_xml'))); ?>