<h2>Listing Adresses</h2>
<br>
<?php if ($adresses): ?>
<table class="zebra-striped">
	<thead>
		<tr>
			<th>Idadresse</th>
			<th>Tnomrue</th>
			<th>Tbte</th>
			<th>Tcodepostal</th>
			<th>Tcommune</th>
			<th>Ttelephone</th>
			<th>Temail</th>
			<th>Tcourrier</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($adresses as $adresse): ?>		<tr>

			<td><?php echo $adresse->idadresse; ?></td>
			<td><?php echo $adresse->tnomrue; ?></td>
			<td><?php echo $adresse->tbte; ?></td>
			<td><?php echo $adresse->tcodepostal; ?></td>
			<td><?php echo $adresse->tcommune; ?></td>
			<td><?php echo $adresse->ttelephone; ?></td>
			<td><?php echo $adresse->temail; ?></td>
			<td><?php echo $adresse->tcourrier; ?></td>
			<td>
				<?php echo Html::anchor('adresse/view/'.$adresse->id, 'View'); ?> |
				<?php echo Html::anchor('adresse/edit/'.$adresse->id, 'Edit'); ?> |
				<?php echo Html::anchor('adresse/delete/'.$adresse->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Adresses.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('adresse/create', 'Add new Adresse', array('class' => 'btn success')); ?>

</p>
