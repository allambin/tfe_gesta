<h2>Insertion Localisation</h2>


<?php echo Form::open(array('class' => 'form-horizontal')); ?>



<fieldset>

    <legend></legend>

    <div class="control-group">
        <?php echo Form::label('Lieu', 't_lieu', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_lieu', Input::post('t_lieu', isset($localisation) ? $localisation->t_lieu : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Rue', 't_nom_rue', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_nom_rue', Input::post('t_nom_rue', isset($localisation) ? $localisation->adresses->t_nom_rue : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Bte', 't_bte', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_bte', Input::post('t_bte', isset($localisation) ? $localisation->adresses->t_bte : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('CP', 't_code_postal', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_code_postal', Input::post('t_code_postal', isset($localisation) ? $localisation->adresses->t_code_postal : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Commune', 't_commune', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_commune', Input::post('t_commune', isset($localisation) ? $localisation->adresses->t_commune : '')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo Form::label('Téléphone', 't_telephone', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Form::input('t_telephone', Input::post('t_telephone', isset($localisation) ? $localisation->adresses->t_telephone : '')); ?>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-success">Sauver la localisation</button>
    </div>
</fieldset>

<?php echo Html::anchor('administration/liste_localisation', '<i class="icon-arrow-left"></i> Retour', array('class' => "btn btn-sucess pull-right")); ?>
<div class="clear"></div>