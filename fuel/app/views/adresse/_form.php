<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Idadresse', 'idadresse'); ?>

			<div class="input">
				<?php echo Form::input('idadresse', Input::post('idadresse', isset($adresse) ? $adresse->idadresse : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tnomrue', 'tnomrue'); ?>

			<div class="input">
				<?php echo Form::input('tnomrue', Input::post('tnomrue', isset($adresse) ? $adresse->tnomrue : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tbte', 'tbte'); ?>

			<div class="input">
				<?php echo Form::input('tbte', Input::post('tbte', isset($adresse) ? $adresse->tbte : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tcodepostal', 'tcodepostal'); ?>

			<div class="input">
				<?php echo Form::input('tcodepostal', Input::post('tcodepostal', isset($adresse) ? $adresse->tcodepostal : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tcommune', 'tcommune'); ?>

			<div class="input">
				<?php echo Form::input('tcommune', Input::post('tcommune', isset($adresse) ? $adresse->tcommune : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Ttelephone', 'ttelephone'); ?>

			<div class="input">
				<?php echo Form::input('ttelephone', Input::post('ttelephone', isset($adresse) ? $adresse->ttelephone : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Temail', 'temail'); ?>

			<div class="input">
				<?php echo Form::input('temail', Input::post('temail', isset($adresse) ? $adresse->temail : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tcourrier', 'tcourrier'); ?>

			<div class="input">
				<?php echo Form::input('tcourrier', Input::post('tcourrier', isset($adresse) ? $adresse->tcourrier : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>