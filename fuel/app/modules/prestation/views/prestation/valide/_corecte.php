<p><b>Nous sommes dans une situation correcte concernant les heures, vous pouvez valider !.</b></p>

<?php // echo Html::anchor('prestation/valider/'.$id.'/'.$heure_ajouter.'/'.$date->format('Y-m-d'), '<span class="add">Valider</span>',
//    array('class' => 'button')) ?>
<?php // echo Html::anchor('prestation/modifier_participant', '<span class="delete">Annuler</span>',
//    array('class' => 'button')) ?>

<a class="btn btn-success" href="<?php echo \Fuel\Core\Uri::create('prestation/valider/'.$id.'/'.$heure_ajouter.'/'.$date->format('Y-m-d')) ?>"><i class="icon-thumbs-up icon-white"></i> Valider</a>
<a class="btn btn-danger" href="<?php echo \Fuel\Core\Uri::create('prestation/modifier_participant') ?>"><i class="icon-thumbs-down icon-white"></i> Annuler</a>
