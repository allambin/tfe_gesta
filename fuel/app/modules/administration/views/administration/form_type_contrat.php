<?php echo render($partial_dir.'_titre_types_contrat.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    
    <legend><?php echo $action; ?> un type de contrat</legend>

    <div class="control-group">
        <?php echo Form::label('Type', 't_type_contrat', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_type_contrat', Input::post('t_type_contrat', isset($contrat) ? $contrat->t_type_contrat : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Heure', 'i_heures', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('i_heures', Input::post('i_heures', isset($contrat) ? \Maitrepylos\Helper::time()->timeToString($contrat->i_heures) : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Actif', 'b_type_contrat_actif', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php
        if (isset($contrat)):
            if ($contrat->b_type_contrat_actif == 1):
                echo Form::checkbox('b_type_contrat_actif', '1', array('checked' => 'checked'));
            else:
                echo Form::checkbox('b_type_contrat_actif', '1');
            endif;
        else:
            echo Form::checkbox('b_type_contrat_actif', '1');
        endif;
        ?>
        </div>

    </div>
    <div class="control-group">
        <?php echo Form::label('Payement', 'i_paye', array('class' => 'control-label')) ?>
        <div class="controls">
        <?php
        if (isset($contrat)):
            if ($contrat->i_paye == 1):
                echo Form::checkbox('i_paye', '1', array('checked' => 'checked'));
            else:
                echo Form::checkbox('i_paye', '1');
            endif;
        else:
            echo Form::checkbox('i_paye', '1');
        endif;
        ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Subside', 'subside_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo Form::select('subside_id', Input::post('subside_id'), $subside); ?>
        </div>
    </div>
    
</fieldset>
    
<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver le type de contrat</button>
</div>
<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_types_contrat'))); ?>