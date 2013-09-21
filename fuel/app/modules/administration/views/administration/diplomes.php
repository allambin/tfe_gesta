<?php echo render($partial_dir.'_titre_diplomes.php'); ?>

<fieldset>
    <legend>Gestion des types d'études</legend>
    
    <a href="ajouter_diplome_xml/type" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un type</a>
    
    <table class="table table-top table-striped">
        <tr>
            <th>Nom</th>
            <th>Valeur</th>
            <th class="actions"></th>
        </tr>
        <?php
        $i = 0;
        foreach ($types as $key => $type):
        ?>
        <tr>
            <td><?php echo $type; ?></td>
            <td class="valeur"><?php echo $key; ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_diplome_xml/type/'.$i); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce statut ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        $i++;
        endforeach;
        ?>
    </table>
    
</fieldset>

<fieldset>
    <legend>Gestion des diplômes</legend>
    
    <a href="ajouter_diplome_xml/diplome" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un diplôme</a>
    
    <table class="table table-top table-striped">
        <tr>
            <th>Nom</th>
            <th>Valeur</th>
            <th class="actions"></th>
        </tr>
        <?php
        $i = 0;
        foreach ($diplomes as $key => $diplome):
        ?>
        <tr>
            <td><?php echo $diplome; ?></td>
            <td class="valeur"><?php echo $key; ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_diplome_xml/diplome/'.$i); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce diplôme ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        $i++;
        endforeach;
        ?>
    </table>
    
</fieldset>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>