<?php echo render($partial_dir.'_titre_groupes.php'); ?>


<fieldset>
    
    <a href="ajouter_groupe" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter un groupe</a>
        
    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th>Responsable</th>
            <th>Filière</th>
            <th>Lundi</th>
            <th>Mardi</th>
            <th>Mercredi</th>
            <th>Jeudi</th>
            <th>Vendredi</th>
            <th>Samedi</th>
            <th>Dimanche</th>
            <th class="actions"></th>

        </tr>
        <?php
        $time = new \Maitrepylos\Timetosec();
        \Debug::dump($groupes);
        foreach ($groupes as $groupe):
        ?>
        <tr>
            <td><?php echo $groupe->t_nom; ?></td>
            <td><?php echo $groupe->user->username; ?></td>
            <td class="valeur"><?php echo isset($groupe) ? $groupe->filieres->t_nom : '' ; ?></td>
            <td><?php echo $time->TimeToString($groupe['i_lundi']) ?></td>
            <td><?php echo $time->TimeToString($groupe['i_mardi']) ?></td>
            <td><?php echo $time->TimeToString($groupe['i_mercredi']) ?></td>
            <td><?php echo $time->TimeToString($groupe['i_jeudi']) ?></td>
            <td><?php echo $time->TimeToString($groupe['i_vendredi']) ?></td>
            <td><?php echo $time->TimeToString($groupe['i_samedi']) ?></td>
            <td><?php echo $time->TimeToString($groupe['i_dimanche']) ?></td>
            <td class="text-right">
                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create($view_dir.'modifier_groupe/'.$groupe['id_groupe']); ?>" ><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create($view_dir.'supprimer_groupe/'.$groupe['id_groupe']); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce groupe ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        endforeach;
        ?>
    </table>
</fieldset>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>