<p>Voulez-vous réactiver <?php echo $participant->t_nom.' '.$participant->t_prenom; ?> ?</p>

<p>
    <?php echo Html::anchor($view_dir . 'reactiver/'.$participant->id_participant.'/rea', 'Reactiver') ?> - <?php echo Html::anchor('participant', 'Abandonner') ?>
</p>