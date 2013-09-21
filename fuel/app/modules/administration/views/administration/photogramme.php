<?php echo render($partial_dir.'_titre_photogramme.php'); ?>

<fieldset>
    <legend>Liste des items</legend>
    
    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th>Valeur</th>
            <th class="actions"></th>
        </tr>
        <?php
        $i = 0;
        foreach ($photogramme as $key => $item):
        ?>
        <tr>
            <td><?php echo $item; ?></td>
            <td class="valeur"><?php echo $key; ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create($view_dir.'modifier_photogramme_xml/'.$key); ?>"><i class="icon-edit icon-white"></i></a>
            </td>
        </tr>    
        <?php
        $i++;
        endforeach;
        ?>
    </table>
    
</fieldset>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>