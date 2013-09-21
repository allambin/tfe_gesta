<h2>Ajouter un login</h2>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>
<div class="control-group">
    <?php echo Form::label('Login', 'username', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('username', Input::post('username', isset($user) ? $user->username : '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Mot de passe', 'password', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('password', ''); ?> <?php echo Form::checkbox('required_password', 1); ?> Reset
    </div>
</div>
<div class="control-group">
    <?php echo Form::label('Droits', 'group', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::select('group', Input::post('group', isset($user) ? $user->group : ''), $droits); ?>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn btn-success">Modifier le login</button>
    </div>
<?php echo Form::close(); ?>