<script type="text/javascript">
    $(function () {
        var projects = [
            <?php foreach($participants as $participant): ?>
            {
                value: '<?php echo $participant->id_participant; ?>',
                label: '<?php echo $participant->t_nom.' '.$participant->t_prenom; ?>'
            },
            <?php endforeach; ?>
        ];

        $('#form_t_nom').autocomplete({
            minLength: 0,
            source: projects,
            select: function (event, ui) {
                $('#form_t_nom').val(ui.item.label);
                $('#form_idparticipant').val(ui.item.value);
                return false;
            }
        })

    });
</script>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>
<fieldset>
    <?php if ($action == 'modifier'): ?>
        <legend>Modifier un participant</legend>
    <?php elseif ($action == 'supprimer'): ?>
        <legend>Supprimer un participant</legend>
    <?php else : ?>
        <legend>Choisir un participant</legend>
    <?php endif; ?>
    <div class="control-group">
        <?php echo Form::label('Nom', 't_nom', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_nom', '', array('id' => 'form_t_nom')); ?>
        </div>
        <?php echo Form::hidden('idparticipant', '', array('id' => 'form_idparticipant')); ?>
    </div>
</fieldset>
<p>
    <?php if ($action == 'modifier'): ?>
    <div class="form-actions">
        <button type="submit" class="btn btn-success">Modifier le participant</button>
    </div>
<?php elseif ($action == 'supprimer'): ?>
    <div class="form-actions">
        <button type="submit" class="btn btn-success" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce participant ?')"">Supprimer le participant</button>
    </div>
<?php else : ?>
    <div class="form-actions">
        <button type="submit" class="btn btn-success">Suivant</button>
    </div>
<?php
endif; ?>
</p>
<?php echo Form::close(); ?>




