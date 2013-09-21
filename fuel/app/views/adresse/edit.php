<h2>Editing Adresse</h2>
<br>

<?php echo render('adresse/_form'); ?>
<p>
	<?php echo Html::anchor('adresse/view/'.$adresse->id, 'View'); ?> |
	<?php echo Html::anchor('adresse', 'Back'); ?></p>
