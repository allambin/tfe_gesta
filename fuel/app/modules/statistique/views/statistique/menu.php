<?php echo render('statistique/partials/_titre_statistique.php'); ?>

<?php echo Form::open(array('action' => $route, 'class' => 'form-horizontal')); ?>

<fieldset>
    <legend><?php echo $titre ?></legend>
    
    <div class="control-group">
        <?php echo Form::label('Année', 'annee', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('annee', '', $annee) ?>
        </div>
    </div>
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Suivant</button>
</div>

<?php echo Form::close(); ?>
<?php echo Html::anchor('statistique', '<i class="icon-arrow-left"></i> Retour',array('class' => "btn btn-sucess pull-right")); ?>
<div class="clear"></div>
