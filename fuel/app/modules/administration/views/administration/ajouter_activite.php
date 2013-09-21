<?php echo render($partial_dir.'_titre_activites.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend>Ajouter une activité</legend>
    
    <div class="control-group">
        <?php echo Form::label('Nom', 't_nom', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_nom', Input::post('nom', isset($activite) ? $activite->t_nom : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Schéma', 't_schema', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php echo Form::input('t_schema', Input::post('valeur', isset($activite) ? $activite->t_schema : '')); ?>
        </div>
    </div>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver l'activité</button>
</div>

<?php echo Form::close(); ?>

<h1>Explications des schémas</h1>

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

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir.'liste_activites'))); ?>