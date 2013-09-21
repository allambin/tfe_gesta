<h2>Ajouter un groupe</h2>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>
<div class="control-group">
    <?php echo Form::label('Nom', 't_nom', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_nom', Input::post('t_nom', isset($groupe) ? $groupe->t_nom : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('CEDEFOP', 'tcodecedefop', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_code_cedefop', Input::post('t_code_cedefop', isset($groupe) ? $groupe->t_code_cedefop : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Localisation', 'centre', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::select('centre', Input::post('centre'), $centre); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Responsable Groupe', 'login', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::select('login', Input::post('login'), $users); ?>
    </div>
</div>
<div class="control-group">
    <h2>Horaire habituel</h2>

</div>

<div class="control-group">
    <?php echo Form::label('Lundi', 'lundi', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo Form::input('lundi', Input::post('lundi', isset($groupe) ? $groupe->lundi : '07:30')) ?>
    </div>
</div><div class="control-group">
    <?php echo Form::label('Mardi', 'mardi', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo Form::input('mardi', Input::post('mardi', isset($groupe) ? $groupe->mardi : '07:30')) ?>
    </div>
</div><div class="control-group">
    <?php echo Form::label('Mercredi', 'mercredi', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo Form::input('mercredi', Input::post('mercredi', isset($groupe) ? $groupe->mercredi : '07:30')) ?>
    </div>
</div><div class="control-group">
    <?php echo Form::label('Jeudi', 'jeudi', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo Form::input('jeudi', Input::post('jeudi', isset($groupe) ? $groupe->jeudi : '07:30')) ?>
    </div>
</div><div class="control-group">
    <?php echo Form::label('Vendredi', 'vendredi',  array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo Form::input('vendredi', Input::post('vendredi', isset($groupe) ? $groupe->vendredi : '06:30')) ?>
    </div>
</div><div class="control-group">
    <?php echo Form::label('Samedi', 'samedi', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo Form::input('samedi', Input::post('samedi', isset($groupe) ? $groupe->samedi : '00:00')) ?>
    </div>
</div><div class="control-group">
    <?php echo Form::label('Dimanche', 'dimanche', array('class' => 'control-label')) ?>
    <div class="controls">
    <?php echo Form::input('dimanche', Input::post('dimanche', isset($groupe) ? $groupe->dimanche : '00:00')) ?>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver le groupe</button>
</div>
<?php echo Form::close(); ?>

<?php echo render($view_dir.'/back', array('url' => Uri::create($view_dir.'liste_groupes'))); ?>