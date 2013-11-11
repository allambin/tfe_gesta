<?php echo render($partial_dir.'_titre_photogramme.php'); ?>

<?php echo Form::open(); ?>

<fieldset>
    <legend>Editer un item</legend>

    <div class="control-group">
        <?php echo Form::label('Nom', 'nom', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('nom', $nom); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Valeur', 'valeur', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo $item; ?>
        </div>
    </div>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Modifier le photogramme</button>
</div>

<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'photogramme_xml'))); ?>