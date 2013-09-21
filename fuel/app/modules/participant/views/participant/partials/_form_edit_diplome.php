<div class="control-group">
    <?php echo Form::label('Type enseignement', 't_type_etude', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::select('t_type_etude', Input::post('t_type_etude', isset($participant) ? $participant->t_type_etude : ''), $types); ?>
    </div>
</div>      
<div class="control-group">
    <?php echo Form::label('Diplôme', 't_diplome', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::select('t_diplome', Input::post('t_diplome', isset($participant) ? $participant->t_diplome : ''), $diplomes); ?>
    </div>
</div>      
<div class="control-group">
    <?php echo Form::label('Année étude', 't_annee_etude', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::select('t_annee_etude', Input::post('t_annee_etude', isset($participant) ? $participant->t_annee_etude : ''), Cranberry\MyXML::get_annee_etude()); ?>
    </div>
</div>      
<div class="control-group">
    <?php echo Form::label('Date fin étude', 'd_fin_etude', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php echo Form::input('d_fin_etude', Input::post('d_fin_etude', isset($participant) ? ($participant->d_fin_etude != NULL) ? date('d-m-Y', strtotime($participant->d_fin_etude)) : ''  : '')); ?>
    </div>
</div>      
<div class="control-group">
    <?php echo Form::label('Attestation non réussite', 'b_attestation_reussite', array('class' => 'control-label')); ?>
    <div class="controls">
    <?php 
    if(isset($participant)):
    if(isset($participant) AND $participant->b_attestation_reussite == 1):
        echo Form::checkbox('b_attestation_reussite', '1', array('checked' => 'checked')); 
    else :
        echo Form::checkbox('b_attestation_reussite', '1');
    endif;
    else:
        echo Form::checkbox('b_attestation_reussite', '1');
    endif;
    ?>
    </div>
</div>