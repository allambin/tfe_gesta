<?php echo render('partials/_titre_document.php'); ?>

<?php echo Form::open(array('action' => 'document/document/l2/', 'class' => 'form-horizontal')); ?>

<fieldset>
    <legend>Impression du document L2</legend>

    <div class="control-group">
        <?php echo Form::label('Filière', 'filiere', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('filiere', '', $groupe) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Mois', 'mois', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('mois', '', $mois) ?>
        </div>
    </div>
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