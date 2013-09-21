<h2>Insertion agrément</h2>


<?php echo Form::open(array('class' => 'form-horizontal')); ?>



<fieldset>

    <legend></legend>

    <div class="control-group">
        <?php echo Form::label('Agrément', 't_agrement', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_agrement', Input::post('t_agrement', isset($agrement) ? $agrement->t_agrement : '')); ?>
        </div>
    </div>    
    <div class="control-group">
        <?php echo Form::label('Origine Agrément', 't_origine_agrement', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_origine_agrement', Input::post('t_origine_agrement', isset($agrement) ? $agrement->t_origine_agrement : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Responsable ', 'users_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('users_id', Input::post('users_id', isset($agrement) ? $agrement->users->username : ''), $users); ?>

        </div>
    </div>    
    <div class="control-group">
        <?php echo Form::label('Centre ', 'centre_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('centre_id', Input::post('centre_id', isset($agrement) ? $agrement->centres->t_nom_centre : ''), $centre); ?>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success">Sauver l'agrément</button>
    </div>



</fieldset>