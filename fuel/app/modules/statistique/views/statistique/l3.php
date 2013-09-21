<?php echo render('statistique/partials/_titre_statistique.php'); ?>

<h3>Statistiques L3  <?php echo $annee ?></h3>


<div>
    <ul class="nav nav-tabs nav-pills">
        <?php for($i = 0; $i < $compteur; $i++): ?>
            <li><a href="#fragment-<?php echo $i ?>" data-toggle="tab"><?php echo $nom_groupe[$i]['t_nom'] ?></a></li>
        <?php endfor; ?>
    </ul>

    <div class="tab-content">

        <?php for($i = 0; $i < $compteur; $i++): ?>
            <div class="tab-pane" id="fragment-<?php echo $i ?>">
                <table cellspacing="0" cellpadding="0" width="80%" border="1" align="center">
                    <tr style="text-align: center">
                        <td rowspan='3'>Date</td>
                        <td colspan='5'>Heures de Formations</td>
                    </tr>
                    <tr style="text-align: center">

                        <td colspan='4'>Effectivement suivies aupr&egrave;s de</td>

                        <td rowspan='3'>Assimil&eacute;es (5)</td>
                    </tr>
                    <tr style="text-align: center">

                        <td>EFT/OISP</td>
                        <td colspan='2'>ORG.CONVENT</td>

                        <td>Ent. Dans le cadre du stage (4)</td>

                    </tr>
                    <tr style="text-align: center">
                        <td></td>
                        <td></td>
                        <td>Gratuit(2)</td>
                        <td>Payant(3)</td>
                        <td></td>

                    </tr>
                    <?php for($z = 0; $z < 12; $z++): ?>
                        <tr align="center">
                            <td><?php echo \Maitrepylos\Utils::mois($z + 1) ?></td>
                            <?php $tableau = $data[$nom_groupe[$i]['t_nom']][Maitrepylos\Utils::mois($z + 1)]  ?>
                            <td><?php echo ($tableau['eft'] != null) ? $tableau['eft'] : '00:00:00' ?></td>
                            <td><?php echo ($tableau['gratuit'] != null) ? $tableau['gratuit'] : '00:00:00' ?></td>
                            <td><?php echo ($tableau['payant'] != null) ? $tableau['payant'] : '00:00:00' ?></td>
                            <td><?php echo ($tableau['stage'] != null) ? $tableau['stage'] : '00:00:00' ?></td>
                            <td><?php echo ($tableau['assimile'] != null) ? $tableau['assimile'] : '00:00:00' ?></td>


                        </tr>
                    <?php endfor; ?>
                    <tr style="text-align: center">
                        <td>Total</td>
                        <td><?php echo ($data[$nom_groupe[$i]['t_nom']]['totaleft'] != null) ? $data[$nom_groupe[$i]['t_nom']]['totaleft'] : '00:00:00' ?></td>
                        <td><?php echo ($data[$nom_groupe[$i]['t_nom']]['totalgratuit'] != null) ? $data[$nom_groupe[$i]['t_nom']]['totalgratuit'] : '00:00:00' ?></td>
                        <td><?php echo ($data[$nom_groupe[$i]['t_nom']]['totalpayant'] != null) ? $data[$nom_groupe[$i]['t_nom']]['totalpayant'] : '00:00:00' ?></td>
                        <td><?php echo ($data[$nom_groupe[$i]['t_nom']]['totalstage'] != null) ? $data[$nom_groupe[$i]['t_nom']]['totalstage'] : '00:00:00' ?></td>
                        <td><?php echo ($data[$nom_groupe[$i]['t_nom']]['totalassimile'] != null) ? $data[$nom_groupe[$i]['t_nom']]['totalassimile'] : '00:00:00' ?></td>

                    </tr>
                    <tr style="text-align: center">
                        <td>Total g&eacute;n&eacute;ral</td>
                        <td colspan="4"><?php echo $data[$nom_groupe[$i]['t_nom']]['totalgeneral'] ?></td>
                        <td></td>
                    </tr>
                </table>

            </div>

        <?php endfor; ?>
    </div>

    <?php    echo Html::anchor('statistique/', 'Retour'); ?>


</div>

