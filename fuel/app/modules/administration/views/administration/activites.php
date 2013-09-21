<?php echo render($partial_dir.'_titre_activites.php'); ?>

<fieldset>

    <a href="ajouter_activite" class="btn btn-success pull-right"><i class="icon-white icon-plus"></i> Ajouter une activité</a>

    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th>Schéma</th>
            <th class="actions"></th>
        </tr>
        </table>
    <table class="table table-striped table-top" id="table_activite">
        <?php

        foreach ($activites as $value):
            ?>
            <tr id="<?php echo $value->id_activite?>">
                <td><?php echo $value->t_nom; ?></td>
                <td class="valeur"><?php echo $value->t_schema; ?></td>
                <td class="text-right">
                    <a class="btn btn-mini btn-warning"
                       href="<?php echo Uri::create($view_dir.'modifier_activite/' . $value->id_activite); ?>" > <i class="icon-edit icon-white"></i></a>
                </td>
            </tr>
            <?php
            endforeach;
        ?>
    </table>
</fieldset>

<h2>Explications des schémas</h2>

<table>
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th colspan="3">documents R.W. : L.2 et L.3</th>
        <th rowspan="2"> h.non subsid.</th>
        <th rowspan="2" colspan="2">fiche mensuelle prestations</th>
        <th rowspan="2" colspan="3">suivi interne des pr&eacute;sences</th>
        <th rowspan="2">&nbsp;</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th colspan="3">heures subsidi&eacute;es (col.13a des statist. trimestrielles)1</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>sigles</td>
        <td>Sch&eacute;ma d'heures</td>
        <td>Heures EFT</td>
        <td>Heure org. conv.</td>
        <td>heure stage</td>
        <td>heures assimil&eacute;es</td>
        <td>Heures pay&eacute;es</td>
        <td>Compteur</td>
        <td>P</td>
        <td>A A J</td>
        <td>A S J</td>
        <td>type de pr&eacute;sence : 'item' (sans accent)</td>
    </tr>
    <tr>
        <td>+</td>
        <td>Heures normales</td>
        <td>oui</td>
        <td></td>
        <td></td>
        <td></td>
        <td>oui</td>
        <td>+</td>
        <td>x</td>
        <td></td>
        <td></td>
        <td>atelier ; accompagnement ; debriefing</td>
    </tr>
    <tr>
        <td>@</td>
        <td>Formation org. conv.</td>
        <td></td>
        <td>oui</td>
        <td></td>
        <td></td>
        <td>oui</td>
        <td>+</td>
        <td>x</td>
        <td></td>
        <td></td>
        <td>jardin</td>
    </tr>
    <tr>
        <td>=</td>
        <td>Stage</td>
        <td></td>
        <td></td>
        <td>oui</td>
        <td></td>
        <td>oui</td>
        <td>+</td>
        <td>x</td>
        <td></td>
        <td></td>
        <td>Stage (en entreprise).</td>
    </tr>
    <tr>
        <td>/</td>
        <td>Heures assimilables</td>
        <td></td>
        <td></td>
        <td></td>
        <td>oui</td>
        <td></td>
        <td></td>
        <td></td>
        <td>x</td>
        <td></td>
        <td>maladie (< 1 mois), demarches (sociales)</td>
    </tr>
    <tr>
        <td>%</td>
        <td>Absences justifi&eacute;es</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>x</td>
        <td></td>
        <td>conge, FUNOC, PHOENIX...</td>
    </tr>
    <tr>
        <td>*</td>
        <td>Absence non justifi&eacute;e</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>x</td>
        <td>absent (sans justificatif)</td>
    </tr>
    <tr>
        <td>-</td>
        <td>R&eacute;cup</td>
        <td>oui</td>
        <td></td>
        <td></td>
        <td></td>
        <td>oui</td>
        <td>-</td>
        <td></td>
        <td>x</td>
        <td></td>
        <td>recup</td>
    </tr>
    <tr>
        <td>$</td>
        <td>Heures pay&eacute;es</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>oui</td>
        <td></td>
        <td>x</td>
        <td></td>
        <td></td>
        <td>Cefa</td>
    </tr>
    <tr>
        <td>#</td>
        <td>Formation externe</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>x</td>
        <td></td>
        <td></td>
        <td>PST3</td>
    </tr>
    </tbody>
</table>

<?php echo Asset::js('jquery.tablednd.0.7.min.js'); ?>

<script type="text/javascript">
    $('#table_activite').tableDnD({
        onDrop: function(table,row) {
            var order = $.tableDnD.serialize();
            $.post('liste_activites', order);
        }
    });
</script>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>