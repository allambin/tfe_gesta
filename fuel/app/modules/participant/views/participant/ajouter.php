<?php echo render($partial_dir . '_titre_participant.php'); ?>

<script>
    // Fonction datepicker pour la date de naissance
    $(function(){
        $('#form_d_date_naissance').datepicker({
            dateFormat: 'dd-mm-yy',
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
            firstDay: 1,
            yearRange: '-100:+10'
        });
    });
</script>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend>Ajouter un participant</legend>
    
    <ul id="gestaTab" class="nav nav-pills">
        <li class="active"><a href="#signaletique" data-toggle="tab" onclick="fill_hidden_input('signaletique')">Signalétique</a></li>
    </ul>
    
    <div id="gestaTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="signaletique">        
            <div id="signaletique">
                <div class="control-group">
                    <?php echo Form::label('Nom*', 't_nom', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo Form::input('t_nom', Input::post('t_nom', isset($participant) ? $participant->t_nom : '')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Form::label('Prénom*', 't_prenom', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo Form::input('t_prenom', Input::post('t_prenom', isset($participant) ? $participant->t_prenom : '')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Form::label('Date de naissance', 'd_date_naissance', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo Form::input('d_date_naissance', Input::post('d_date_naissance', isset($participant) ? $participant->d_date_naissance : ''), array('placeholder' => 'dd-mm-yyyy')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Form::label('Lieu de naissance', 't_lieu_naissance', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo Form::input('t_lieu_naissance', Input::post('t_lieu_naissance', isset($participant) ? $participant->t_lieu_naissance : '')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Form::label('Sexe', 't_sexe', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo Form::select('t_sexe', Input::post('t_sexe', isset($participant) ? $participant->t_sexe : ''), array('' => '', 'M' => 'Homme', 'F' => 'Femme')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo Form::label('Nationalité', 't_nationalite', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo Form::select('t_nationalite', Input::post('t_nationalite', isset($participant) ? $participant->t_nationalite : ''), Cranberry\MyXML::getPaysAsSelect()); ?>
                    </div>
                </div>
                    <div class="control-group">
                    <?php echo Form::label('GSM', 't_gsm', array('class' => 'control-label')); ?>
                        <div class="controls">
                    <?php echo Form::input('t_gsm', Input::post('t_gsm', isset($participant) ? $participant->t_gsm : '')); ?>
                        </div>
                </div>
                <div class="control-group">
                    <?php echo Form::label('GSM 2', 't_gsm2', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php echo Form::input('t_gsm2', Input::post('t_gsm2', isset($participant) ? $participant->t_gsm2 : '')); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</fieldset>
        
<div class="form-actions">
    <button type="submit" class="btn btn-success">Ajouter le participant</button>
</div>

<?php echo Form::close(); ?>

<p><?php echo Html::anchor('/', '<i class="icon-step-backward"></i> Retour', array('class' => 'btn pull-right')); ?></p>
<div class="clear"></div>