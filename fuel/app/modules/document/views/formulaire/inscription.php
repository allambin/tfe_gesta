<?php echo render('partials/_titre_document.php'); ?>

<?php echo Form::open(array('action' => 'document/document/inscription', 'class' => 'form-horizontal')); ?>

<fieldset>
    <legend>Impression de l'attestation d'inscription</legend>

    <div class="control-group">
        <?php echo Form::label('Années', 'annee', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('annee', '', $annee) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Trimestre', 'trimestre', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('Trimestre', '', $trimestre) ?>
        </div>
    </div>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Suivant</button>
</div>

<?php echo Form::close(); ?>
<p><?php echo Html::anchor('document', '<i class="icon-step-backward"></i> Retour', array('class' => 'btn pull-right')); ?></p>
<div class="clear"></div>