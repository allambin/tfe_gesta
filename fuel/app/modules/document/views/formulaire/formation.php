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

<?php echo Form::open(array('action' => $route, 'class' => 'form-horizontal')); ?>

<fieldset>
    <legend><?php echo $titre ?></legend>
    
    <div class="control-group">
        <?php echo Form::label('Nom', 'nom', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('nom', ''); ?>
        </div>
        <?php echo Form::hidden('idparticipant', ''); ?>
    </div>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Suivant</button>
</div>

<?php echo Form::close(); ?>
<p><?php echo Html::anchor('document', '<i class="icon-step-backward"></i> Retour', array('class' => 'btn pull-right')); ?></p>
<div class="clear"></div>