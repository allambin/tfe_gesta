<table class="form">
    <tr>
        <td>
            <table class="form_left">
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Nom*', 't_nom', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_nom', Input::post('t_nom', isset($participant) ? $participant->t_nom : '')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Prénom*', 't_prenom', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_prenom', Input::post('t_prenom', isset($participant) ? $participant->t_prenom : '')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Date de naissance', 'd_date_naissance', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('d_date_naissance', Input::post('d_date_naissance', isset($participant) ? ($participant->d_date_naissance != NULL) ? date('d-m-Y', strtotime($participant->d_date_naissance)) : ''  : ''), array('placeholder' => 'dd-mm-yyyy')); ?>
                            <span id="age">coucou</span>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Lieu de naissance', 't_lieu_naissance', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_lieu_naissance', Input::post('t_lieu_naissance', isset($participant) ? $participant->t_lieu_naissance : '')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Sexe', 't_sexe', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::select('t_sexe', Input::post('t_sexe', isset($participant) ? $participant->t_sexe : ''), array('' => '', 'M' => 'Homme', 'F' => 'Femme')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Nationalité', 't_nationalite', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::select('t_nationalite', Input::post('t_nationalite', isset($participant) ? $participant->t_nationalite : ''), Cranberry\MyXML::getPaysAsSelect()) ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Email', 't_email', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_email', Input::post('t_email', isset($participant) ? $participant->t_email : '')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('GSM', 't_gsm', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_gsm', Input::post('t_gsm', isset($participant) ? $participant->t_gsm : '')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <table class="form_right">
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('GSM2', 't_gsm2', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_gsm2', Input::post('t_gsm2', isset($participant) ? $participant->t_gsm2 : '')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Etat civil', 't_etat_civil', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::select('t_etat_civil', Input::post('t_etat_civil', isset($participant) ? $participant->t_etat_civil : ''), array('' => '', 'Célibataire' => 'Célibataire', 'Marié(e)' => 'Marié(e)', 'Veuf(ve)' => 'Veuf(ve)')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Registre national', 't_registre_national', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_registre_national', Input::post('t_registre_national', isset($participant) ? $participant->t_registre_national : '')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Compte bancaire', 't_compte_bancaire', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_compte_bancaire', Input::post('t_compte_bancaire', isset($participant) ? $participant->t_compte_bancaire : '')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Moyen de transport', 't_moyen_transport', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::select('t_moyen_transport', Input::post('t_moyen_transport', isset($participant) ? $participant->t_moyen_transport : ''), array('' => '', 'TEC' => 'Transports en commun', 'Voiture/scooter/vélo' => 'Voiture/scooter/vélo', 'Rien' => 'Rien')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Pointure', 't_pointure', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_pointure', Input::post('t_pointure', isset($participant) ? $participant->t_pointure : '')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <?php echo Form::label('Taille (cm)', 't_taille', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo Form::input('t_taille', Input::post('t_taille', isset($participant) ? $participant->t_taille : '')); ?>
                            </div>  
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<script type="text/javascript">
$(document).ready(function() 
{
    var date_string = $('#form_d_date_naissance').val();

    var age = getAge(date_string);
    $('#age').text(age+" ans");
});
</script>