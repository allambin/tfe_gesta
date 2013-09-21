<h2>Liste Stagiaire</h2>

<?php echo Form::open(array('action' => 'document/document/liste', 'class' => 'form-horizontal')); ?>


<fieldset>
    <legend>Choisissez un document à imprimer</legend>
    
    <div class="control-group">
        <?php echo Form::label('Groupe', 'groupe', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('groupe', '', $groupe) ?>
        </div>
    </div>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Suivant</button>
</div>

<?php echo Form::close(); ?>
<?php echo Html::anchor('statistique', '<i class="icon-arrow-left"></i> Retour',array('class' => "btn btn-sucess pull-right")); ?>
<div class="clear"></div>
