<?php echo render($partial_dir.'_titre_type_cedefop.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    
    <legend><?php echo $action; ?> un type de cedefop</legend>
    
    <div class="control-group">
        <?php echo Form::label('Nom', 't_nom', array('t_nom' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_nom', Input::post('t_nom', isset($type_cedefop) ? $type_cedefop->t_nom : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Code', 'icode', array('i_code' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('i_code', Input::post('i_code', isset($type_cedefop) ? $type_cedefop->i_code : '')); ?>
        </div>
    </div>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver le type</button>
</div>

<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_types_cedefop'))); ?>