<?php foreach ($checklist_sections as $section): ?>
<h3><?php echo $section->t_nom; ?></h3>
<?php foreach($section->valeurs as $valeur): ?>
<p>
    <?php echo $valeur->t_nom; ?>
    <?php
    if (isset($checklist) && in_array($valeur->id_checklist_valeur, $checklist))
    {
        echo Form::checkbox('liste[]', $valeur->id_checklist_valeur, array('checked' => 'checked'));
    }
    else
    {
        echo Form::checkbox('liste[]', $valeur->id_checklist_valeur);
    }
    ?>
</p>
<?php endforeach; ?>
<?php endforeach; ?>