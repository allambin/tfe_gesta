<?php echo render('partials/_titre_document.php'); ?>

<script type="text/javascript">
    jQuery(function($){
        $("#dateinput").datepicker();
        $("#dateoutput").datepicker();

    });
</script>

<?php echo Form::open(array('action' => 'document/document/prestation', 'class' => 'form-horizontal')); ?>

<fieldset>
    <legend>Impression du document Etat de prestation - FOREM</legend>
    
    <div class="control-group">
        <?php echo Form::label('Merci de choisir une p&eacute;riode de 15 jours ', 'periode', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('date', $date,array('id'=>'dateinput')); ?>
            <?php echo Form::input('date2',$date2,array('id'=>'dateoutput')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Chercher un groupe') ?>
        <?php echo Form::select('groupe','none',$groupe)?>
    </div>
    
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Suivant</button>
</div>

<?php echo Form::close(); ?>
<p><?php echo Html::anchor('document', '<i class="icon-step-backward"></i> Retour', array('class' => 'btn pull-right')); ?></p>
<div class="clear"></div>