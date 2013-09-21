<?php echo render($partial_dir.'_titre_pays.php'); ?>

<fieldset>
    <legend>Gestion des pays européens</legend>
    
    <a href="ajouter_pays_xml/europe" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un pays</a>
    
    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th>Valeur</th>
            <th class="actions"></th>
        </tr>
        <?php
        $i = 0;
        foreach ($pays['Europe'] as $p):
        ?>
        <tr>
            <td><?php echo $p->nom; ?></td>
            <td class="valeur"><?php echo $p->valeur; ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_pays_xml/europe/'.$i); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce pays ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        $i++;
        endforeach;
        ?>
    </table>
    
</fieldset>

<fieldset>
    <legend>Gestion des pays non-européens</legend>
    
    <a href="ajouter_pays_xml/hors_europe" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un pays</a>
    
    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th>Valeur</th>
            <th class="actions"></th>
        </tr>
        <?php
        $i = 0;
        foreach ($pays['Hors Europe'] as $p):
        ?>
        <tr>
            <td><?php echo $p->nom; ?></td>
            <td class="valeur"><?php echo $p->valeur; ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_pays_xml/hors_europe/'.$i); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce pays ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        $i++;
        endforeach;
        ?>
    </table>
</fieldset>

<fieldset>
    <legend>Gestion des autres situations</legend>
    
    <a href="ajouter_pays_xml/autre" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un pays</a>
    
    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th>Valeur</th>
            <th class="actions"></th>
        </tr>
        <?php
        $i = 0;
        foreach ($pays['Autre'] as $p):
        ?>
        <tr>
            <td><?php echo $p->nom; ?></td>
            <td class="valeur"><?php echo $p->valeur; ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_pays_xml/autre/'.$i); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce pays ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        $i++;
        endforeach;
        ?>
    </table>
</fieldset>

<fieldset>
    <legend>Gestion de la Belgique</legend>
    
    <a href="ajouter_pays_xml/belgique" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un pays</a>
    
    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th>Valeur</th>
            <th class="actions"></th>
        </tr>
        <?php
        $i = 0;
        foreach ($pays['Belgique'] as $p):
        ?>
        <tr>
            <td><?php echo $p->nom; ?></td>
            <td class="valeur"><?php echo $p->valeur; ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_pays_xml/belgique/'.$i); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce pays ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        $i++;
        endforeach;
        ?>
    </table>
</fieldset>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>