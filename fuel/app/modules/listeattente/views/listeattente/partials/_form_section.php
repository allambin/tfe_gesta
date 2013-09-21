<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend><?php echo $action; ?> une section</legend>
    
    <div class="control-group">
        <?php echo Form::label('Nom de la section', 't_nom', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_nom', Input::post('t_nom', isset($checklist_section) ? $checklist_section->t_nom : ''), array('class' => 'span6')); ?>
        </div>
    </div>
    
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver la section</button>
</div>

<?php echo Form::close(); ?>