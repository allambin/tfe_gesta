<h2>Se connecter</h2>

<?php echo Form::open('users/login'); ?>

    <p>
        <?php echo Form::label('Login', 'username'); ?>
        <?php echo Form::input('username', '', array('size' => 30)); ?>
    </p>
    <p>
        <?php echo Form::label('Mot de passe', 'password'); ?>
        <?php echo Form::password('password', '', array('size' > 30)); ?>
    </p>
<div class="input submit">
    <?php echo Form::submit('login', 'Login',array('class'=>'btn btn-success')); ?></div>