<?php echo render($partial_dir.'_titre_prestations.php'); ?>

<?php echo Form::open(); ?>

<fieldset>
    <legend>Choisir un groupe</legend>

    <div class="control-group">
        <?php echo Form::label('Groupe', 'groupe'); ?>
        <div class="controls">
        <?php echo Form::select('groupe', '', $groupes); ?>
        </div>
    </div>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Choisir le groupe</button>
</div>
    
<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>