<?php echo render($partial_dir.'_titre_enseignements.php'); ?>

<a href="ajouter_enseignement" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un item</a>
<div class="wrapper spacer"></div>

<?php foreach ($types_enseignement as $type_enseignement): ?>
<fieldset>
    <a href="ajouter_enseignement/<?php echo $type_enseignement->id_type_enseignement ?>" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un item</a>
    <legend><?php echo $type_enseignement->t_nom ?></legend>    
   
    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th>Valeur</th>

            <th class="actions"></th>
        </tr>
        <?php
        if(isset($type_enseignement->enseignements)) foreach ($type_enseignement->enseignements as $item):
        ?>
        <tr>
            <td><?php echo $item->t_nom; ?></td>
            <td class="small"><?php echo $item->t_valeur; ?></td>

            <td class="text-right">
                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create($view_dir.'modifier_enseignement/'.$item->id_enseignement); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_enseignement/'.$item->id_enseignement); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer cet item ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php endforeach; ?>
    </table>
    
</fieldset>
<?php endforeach; ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>