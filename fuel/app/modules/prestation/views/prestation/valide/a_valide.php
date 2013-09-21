
<p>

    <?php foreach($s['tableau'] as $value): ?>

    <?php echo Html::anchor('prestation?valide=1&date='.$value['date']
        , '<span class="info">Valider le mois de '.$value['mois'].' ' .$value['annee'].'</span>',
        array('class' => 'btn btn-success')) ?> <br />


    <?php endforeach; ?>




</p>