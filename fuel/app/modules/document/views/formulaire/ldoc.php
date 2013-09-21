<?php echo render('partials/_titre_document.php'); ?>

<script type="text/javascript">
    jQuery(function ($) {
        $("#dateinput").datepicker({dateFormat: 'dd-mm-yy'});
        $("#dateoutput").datepicker({dateFormat: 'dd-mm-yy'});


    });
</script>

<?php echo Form::open(array('action' => 'document/document/l1/', 'class' => 'form-horizontal')); ?>


<fieldset>
    <legend>Impression du document L1</legend>

    <div class="control-group">
        <?php echo Form::label('Merci de choisir une période de 5 jours', 'periode', array('class' => 'control-label')); ?>

            <?php echo Form::input('date',$date1,array('id'=>'dateinput')); ?>
            <?php echo Form::input('date2',$date2,array('id'=>'dateoutput')); ?>
    </div>
    <br /><br />
    <div class="control-group">
        <?php echo Form::label('Groupe', 'groupe', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('groupe', '', $groupe) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Choisir L1', 'doc', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('doc', '', $doc) ?>
        </div>
    </div>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Suivant</button>
</div>

<?php echo Form::close(); ?>
<p><?php echo Html::anchor('document', '<i class="icon-step-backward"></i> Retour', array('class' => 'btn pull-right')); ?></p>
<div class="clear"></div>