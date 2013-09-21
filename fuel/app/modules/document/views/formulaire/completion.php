<?php echo render('partials/_titre_document.php'); ?>

<script type="text/javascript">
    $(function () {
        var projects = [
        <?php foreach ($participants as $participant): ?>
            {
                value:'<?php echo $participant->id_participant; ?>',
                label:'<?php echo $participant->t_nom . ' ' . $participant->t_prenom; ?>'
            },
            <?php endforeach; ?>
        ];

        $('#form_nom').autocomplete({
            minLength:0,
            source:projects,
            select:function (event, ui) {
                $('#form_nom').val(ui.item.label);
                $('#form_idparticipant').val(ui.item.value);
                return false;
            }
        })

    });
</script>

<?php echo Form::open(array('action' => 'document/formulaire/formulaire/' . $formulaire), array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend>Impression du document <?php echo $titre_document; ?></legend>
    
    <div class="control-group">
        <?php echo Form::label('Nom', 'nom', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('nom', ''); ?>
        </div>
        <?php echo Form::hidden('idparticipant', ''); ?>
    </div>
    <?php if ($formulaire == 2): ?>
    Si vous laissez le champ vide, cela généra l'ensemble des C98
    <div class="control-group">
        <?php echo Form::label('Centre', 'centre', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::select('centre', '', $centre) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Groupe', 'groupe', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::select('groupe', '', $groupe) ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="control-group">
        <?php echo Form::label('Année', 'annee', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::select('annee', date('Y'), $annees) ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Mois', 'mois', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::select('mois', '', $mois) ?>
        </div>
    </div>
    
</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Suivant</button>
</div>
<?php echo Form::close(); ?>
<p><?php echo Html::anchor('document', '<i class="icon-step-backward"></i> Retour', array('class' => 'btn pull-right')); ?></p>
<div class="clear"></div>