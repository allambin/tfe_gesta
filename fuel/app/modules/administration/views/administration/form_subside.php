<?php echo render($partial_dir.'_titre_types_subside.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend><?php echo $action; ?> un subside</legend>

    <div class="control-group">
        <?php echo Form::label('Subside', 'subside', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_nom', isset($subside) ? $subside->t_nom : ''); ?>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver le subside</button>
</div>

<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_subsides'))); ?>