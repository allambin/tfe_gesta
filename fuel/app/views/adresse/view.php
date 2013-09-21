<h2>Viewing #<?php echo $adresse->id; ?></h2>

<p>
	<strong>Idadresse:</strong>
	<?php echo $adresse->idadresse; ?></p>
<p>
	<strong>Tnomrue:</strong>
	<?php echo $adresse->tnomrue; ?></p>
<p>
	<strong>Tbte:</strong>
	<?php echo $adresse->tbte; ?></p>
<p>
	<strong>Tcodepostal:</strong>
	<?php echo $adresse->tcodepostal; ?></p>
<p>
	<strong>Tcommune:</strong>
	<?php echo $adresse->tcommune; ?></p>
<p>
	<strong>Ttelephone:</strong>
	<?php echo $adresse->ttelephone; ?></p>
<p>
	<strong>Temail:</strong>
	<?php echo $adresse->temail; ?></p>
<p>
	<strong>Tcourrier:</strong>
	<?php echo $adresse->tcourrier; ?></p>

<?php echo Html::anchor('adresse/edit/'.$adresse->id, 'Edit'); ?> |
<?php echo Html::anchor('adresse', 'Back'); ?>