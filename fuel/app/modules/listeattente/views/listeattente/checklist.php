<h1>Checklist</h1>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<?php foreach ($checklist_sections as $section_id => $section): ?>
<h3><?php echo $section; ?></h3>
<?php foreach ($checklist_valeurs as $valeur): ?>

    <?php if ($valeur->section_id == $section_id): ?>
        <p>
            <?php echo $valeur->t_nom; ?>
            <?php
            if (isset($checklist) && in_array($valeur->id_checklist_valeur, $checklist)) {
                echo Form::checkbox('list[]', $valeur->id_checklist_valeur, array('checked' => 'checked'));
            } elseif (isset($checklist)) {
                echo Form::checkbox('list[]', $valeur->id_checklist_valeur);
            }
            else {

            }
            ?>
        </p>
        <?php endif ?>

    <?php endforeach; ?>
<?php endforeach; ?>

<?php echo Form::submit('submit', 'Confirmer la checklist', array('class' => 'btn btn-success')); ?>

<?php echo Form::close(); ?>