<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend><?php echo $action; ?> une valeur</legend>
    
    <div class="control-group">
        <?php echo Form::label('Nom', 't_nom', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_nom', Input::post('t_nom', isset($checklist_valeur) ? $checklist_valeur->t_nom : ''), array('class' => 'span6')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Section', 'section_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('section_id', Input::post('section_id', isset($checklist_valeur) ? $checklist_valeur->section : ''), array("Choisissez" => $sections)); ?>
        </div>
    </div>
    
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver la valeur</button>
</div>

<?php echo Form::close(); ?>