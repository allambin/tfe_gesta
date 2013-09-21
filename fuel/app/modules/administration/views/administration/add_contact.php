<h2>Ajouter un type de contact</h2>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>
<div class="control-group">
    <?php echo Form::label('Type', 't_typecontact', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('t_typecontact', isset($contact) ? $contact->t_typecontact : ''); ?>
    </div>
</div>
<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver le type de contact</button>
</div>
<?php echo Form::close(); ?>