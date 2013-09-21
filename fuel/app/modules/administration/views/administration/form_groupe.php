<?php echo render($partial_dir.'_titre_groupes.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    
    <legend><?php echo $action; ?> un groupe</legend>
    
    <div class="control-group">
        <?php echo Form::label('Nom', 't_nom', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_nom', Input::post('t_nom', isset($groupe) ? $groupe->t_nom : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Filière', 'tcodecedefop', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php // echo Form::input('t_code_cedefop', Input::post('t_code_cedefop', isset($groupe) ? $groupe->t_code_cedefop : '')); ?>
        <?php echo Form::select('t_filiere', Input::post('t_filiere', isset($groupe) ? $groupe->t_filiere : ''), $filiere); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Localisation', 'centre', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::select('localisation_id', Input::post('localisation_id', isset($groupe) ? $groupe->localisation_id : ''), $centre); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Responsable Groupe', 'login_id', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::select('login_id', Input::post('login_id', isset($groupe) ? $groupe->login_id : ''), $users); ?>
        </div>
    </div>
    
</fieldset>

<fieldset>

    <legend>Horaire habituel</legend>
    <div class="control-group">
        <?php echo Form::label('Lundi', 'lundi', array('class' => 'control-label')) ?>
        <div class="controls">
        <?php echo Form::input('i_lundi', Input::post('i_lundi', isset($groupe) ? $groupe->i_lundi : '07:30')) ?>
        </div>
    </div><div class="control-group">
        <?php echo Form::label('Mardi', 'mardi', array('class' => 'control-label')) ?>
        <div class="controls">
        <?php echo Form::input('i_mardi', Input::post('i_mardi', isset($groupe) ? $groupe->i_mardi : '07:30')) ?>
        </div>
    </div><div class="control-group">
        <?php echo Form::label('Mercredi', 'mercredi', array('class' => 'control-label')) ?>
        <div class="controls">
        <?php echo Form::input('i_mercredi', Input::post('i_mercredi', isset($groupe) ? $groupe->i_mercredi : '07:30')) ?>
        </div>
    </div><div class="control-group">
        <?php echo Form::label('Jeudi', 'jeudi', array('class' => 'control-label')) ?>
        <div class="controls">
        <?php echo Form::input('i_jeudi', Input::post('i_jeudi', isset($groupe) ? $groupe->i_jeudi : '07:30')) ?>
        </div>
    </div><div class="control-group">
        <?php echo Form::label('Vendredi', 'vendredi',  array('class' => 'control-label')) ?>
        <div class="controls">
        <?php echo Form::input('i_vendredi', Input::post('i_vendredi', isset($groupe) ? $groupe->i_vendredi : '06:30')) ?>
        </div>
    </div><div class="control-group">
        <?php echo Form::label('Samedi', 'samedi', array('class' => 'control-label')) ?>
        <div class="controls">
        <?php echo Form::input('i_samedi', Input::post('i_samedi', isset($groupe) ? $groupe->i_samedi : '00:00')) ?>
        </div>
    </div><div class="control-group">
        <?php echo Form::label('Dimanche', 'dimanche', array('class' => 'control-label')) ?>
        <div class="controls">
        <?php echo Form::input('i_dimanche', Input::post('i_dimanche', isset($groupe) ? $groupe->i_dimanche : '00:00')) ?>
        </div>
    </div>
    
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver le groupe</button>
</div>

<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_groupes'))); ?>