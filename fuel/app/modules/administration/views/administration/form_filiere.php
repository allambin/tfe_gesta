<h2>Insertion Filière</h2>


<?php echo Form::open(array('class' => 'form-horizontal')); ?>



<fieldset>

    <legend></legend>

    <div class="control-group">
        <?php echo Form::label('Filière', 't_nom', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_nom', Input::post('t_nom', isset($filiere) ? $filiere->t_nom : '')); ?>
        </div>
    </div>    
    <div class="control-group">
        <?php echo Form::label('Code Forem', 't_code_forem', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_code_forem', Input::post('t_code_forem', isset($filiere) ? $filiere->t_code_forem : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Cedefop', 'i_code_cedefop', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('i_code_cedefop', Input::post('i_code_cedefop', isset($filiere) ? $filiere->i_code_cedefop : ''), $cedefop); ?>

        </div>
    </div>    
    <div class="control-group">
        <?php echo Form::label('Agrément ', 'agrement_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('agrement_id', Input::post('agrement_id', isset($filiere) ? $filiere->agrements->t_agrement : ''), $agrement); ?>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success">Sauver la filière</button>
    </div>



</fieldset>
<?php echo Html::anchor('administration/liste_filiere', '<i class="icon-arrow-left"></i> Retour', array('class' => "btn btn-sucess pull-right")); ?>
<div class="clear"></div>