<?php echo render($partial_dir.'_titre_prestations.php'); ?>

<fieldset>
    
    <legend>Nombres d'heures à prester sur l'année pour le groupe <?php echo $nomGroupe->t_nom; ?></legend>
    
    <a href="../ajouter_heures_prestation/<?php echo $groupe; ?>" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> Ajouter des heures</a>
    
    <table class="table table-top table-striped">
        <tr>
            <th>Année</th>
            <th>Janvier</th>
            <th>Février</th>
            <th>Mars</th>
            <th>Avril</th>
            <th>Mai</th>
            <th>Juin</th>
            <th>Juillet</th>
            <th>Août</th>
            <th>Septembre</th>
            <th>Octobre</th>
            <th>Novembre</th>
            <th>Décembre</th>
            <th class="actions"></th>
        </tr>
        <?php
        $time = new \MaitrePylos\timeToSec();
        foreach ($heures as $heure) {
        ?>
        <tr style="text-align: center">
            <td><?php echo $heure->annee; ?></td>
            <td><?php echo $time->TimeToString($heure->janvier); ?></td>
            <td><?php echo $time->TimeToString($heure->fevrier); ?></td>
            <td><?php echo $time->TimeToString($heure->mars); ?></td>
            <td><?php echo $time->TimeToString($heure->avril); ?></td>
            <td><?php echo $time->TimeToString($heure->mai); ?></td>
            <td><?php echo $time->TimeToString($heure->juin); ?></td>
            <td><?php echo $time->TimeToString($heure->juillet); ?></td>
            <td><?php echo $time->TimeToString($heure->aout); ?></td>
            <td><?php echo $time->TimeToString($heure->septembre); ?></td>
            <td><?php echo $time->TimeToString($heure->octobre); ?></td>
            <td><?php echo $time->TimeToString($heure->novembre); ?></td>
            <td><?php echo $time->TimeToString($heure->decembre); ?></td>
            <td class="text-right">
                <?php echo Html::anchor('administration/modifier_heures_prestation/'.$heure->id_heures_prestations, '<i class="icon-edit icon-white"></i></i>',array('class'=>'btn btn-warning btn-mini')) ?>
                <?php echo Html::anchor('administration/supprimer_heures_prestation/'.$heure->id_heures_prestations, '<i class="icon-remove icon-white"></i>', array('onclick' => "return confirm('Etes-vous sûr de vouloir supprimer cette prestation ?')",'class'=>'btn btn-mini btn-danger')) ?>
            </td>
        </tr>    
        <?php
        }
        ?>
    </table>
    
</fieldset>

<fieldset>
    
    <legend>Nombres de jours à prester sur l'année pour le groupe <?php echo $nomGroupe->t_nom; ?></legend>
    
    <a href="../ajouter_jours_prestation/<?php echo $groupe; ?>" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i>Ajouter des jours</a>
    
    <table class="table table-top table-striped">
        <tr>
            <th>Année</th>
            <th>Janvier</th>
            <th>Février</th>
            <th>Mars</th>
            <th>Avril</th>
            <th>Mai</th>
            <th>Juin</th>
            <th>Juillet</th>
            <th>Août</th>
            <th>Septembre</th>
            <th>Octobre</th>
            <th>Novembre</th>
            <th>Décembre</th>
            <th class="actions"></th>
        </tr>
        <?php
        foreach ($heures as $heure) {
        ?>
        <tr style="text-align: center">
            <td><?php echo $heure->annee; ?></td>
            <td><?php echo $heure->jours_janvier; ?></td>
            <td><?php echo $heure->jours_fevrier; ?></td>
            <td><?php echo $heure->jours_mars; ?></td>
            <td><?php echo $heure->jours_avril; ?></td>
            <td><?php echo $heure->jours_mai; ?></td>
            <td><?php echo $heure->jours_juin; ?></td>
            <td><?php echo $heure->jours_juillet; ?></td>
            <td><?php echo $heure->jours_aout; ?></td>
            <td><?php echo $heure->jours_septembre; ?></td>
            <td><?php echo $heure->jours_octobre; ?></td>
            <td><?php echo $heure->jours_novembre; ?></td>
            <td><?php echo $heure->jours_decembre; ?></td>
            <td class="text-right">
                <?php echo Html::anchor('administration/modifier_jours_prestation/'.$heure->id_heures_prestations, '<i class="icon-edit icon-white"></i>',array('class'=>'btn btn-mini btn-warning')) ?>
                <?php echo Html::anchor('administration/supprimer_heures_prestation/'.$heure->id_heures_prestations, '<i class="icon-remove icon-white"></i>', array('onclick' => "return confirm('Etes-vous sûr de vouloir supprimer cette prestation ?')",'class'=>'btn btn-mini btn-danger')) ?>
            </td>
        </tr>    
        <?php
        }
        ?>
    </table>
    
</fieldset>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>