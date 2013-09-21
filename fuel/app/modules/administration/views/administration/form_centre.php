<?php echo render($partial_dir.'_titre_centres.php'); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend><?php echo $action; ?> une localisation</legend>    
    
    <table class="form">
        <tr>
            <td>
                <table class="form-left">
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Responsable', 't_responsable', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_responsable', Input::post('t_responsable', isset($centre) ? $centre->t_responsable : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Statut', 't_statut', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_statut', Input::post('t_statut', isset($centre) ? $centre->t_statut : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Dénomination', 't_denomination', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_denomination', Input::post('t_denomination', isset($centre) ? $centre->t_denomination : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Nom de la localisation', 't_nom_centre', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_nom_centre', Input::post('t_nom_centre', isset($centre) ? $centre->t_nom_centre : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Objet social', 't_objet_social', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_objet_social', Input::post('t_objet_social', isset($centre) ? $centre->t_objet_social : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Agrégation', 't_agregation', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_agregation', Input::post('t_agregation', isset($centre) ? $centre->t_agregation : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Agence', 't_agence', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_agence', Input::post('t_agence', isset($centre) ? $centre->t_agence : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Adresse', 't_adresse', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_adresse', Input::post('t_adresse', isset($centre) ? $centre->t_adresse : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Code postal', 't_code_postal', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_code_postal', Input::post('t_code_postal', isset($centre) ? $centre->t_code_postal : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="form-right">
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Localité', 't_localite', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_localite', Input::post('t_localite', isset($centre) ? $centre->t_localite : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Téléphone', 't_telephone', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_telephone', Input::post('t_telephone', isset($centre) ? $centre->t_telephone : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Email', 't_email', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_email', Input::post('t_email', isset($centre) ? $centre->t_email : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('TVA', 't_tva', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_tva', Input::post('t_tva', isset($centre) ? $centre->t_tva : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Enregistrement', 't_enregistrement', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_enregistrement', Input::post('t_enregistrement', isset($centre) ? $centre->t_enregistrement : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                   <!-- <tr>
                        <td>
                            <div class="control-group">
                                <?php /*echo Form::label('Agrément', 't_agrement', array('class' => 'control-label')); */?>
                                <div class="controls">
                                <?php /*echo Form::input('t_agrement', Input::post('t_agrement', isset($centre) ? $centre->t_agrement : '')); */?>
                                </div>
                            </div>
                        </td>
                    </tr>-->
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Responsable pédagogique', 't_responsable_pedagogique', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_responsable_pedagogique', Input::post('t_responsable_pedagogique', isset($centre) ? $centre->t_responsable_pedagogique : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="control-group">
                                <?php echo Form::label('Secrétaire', 't_secretaire', array('class' => 'control-label')); ?>
                                <div class="controls">
                                <?php echo Form::input('t_secretaire', Input::post('t_secretaire', isset($centre) ? $centre->t_secretaire : '')); ?>
                                </div>
                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>    

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Sauver le centre</button>
</div>

<?php echo Form::close(); ?>
    
<?php echo render($partial_dir.'/_back.php', array('url' => Uri::create($view_dir.'liste_centres'))); ?>