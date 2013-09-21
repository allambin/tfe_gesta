<?php echo render($partial_dir.'_titre_logins.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend><?php echo $action ?> un login</legend>

    <div class="control-group">
        <?php echo Form::label('Login', 'username', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('username', Input::post('username', isset($user) ? $user->username : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Mot de passe', 'password', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('password', ''); ?> 
            <?php 
            if($reset_password):
            echo Form::checkbox('required_password', 1); 
            ?> Reset
            <?php endif; ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Nom', 't_nom', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_nom', Input::post('t_nom', isset($user) ? $user->t_nom : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Prénom', 't_prenom', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_prenom', Input::post('t_prenom', isset($user) ? $user->t_prenom : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Fonction', 't_acl', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_acl', Input::post('t_acl', isset($user) ? $user->t_acl : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Droits', 'group', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::select('group', Input::post('group', isset($user) ? $user->group : ''), $droits); ?>
        </div>
    </div>
    
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Ajouter le login</button>
</div>

<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_logins'))); ?>