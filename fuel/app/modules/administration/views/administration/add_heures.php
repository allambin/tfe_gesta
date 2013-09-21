<?php echo render($partial_dir.'_titre_prestations.php'); ?>

<?php $time = new \MaitrePylos\timeToSec(); ?>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>

<fieldset>
    <legend><?php echo $action; ?> une année</legend>
    
    <table class="form">
        <tr>
            <td>
                <table class="form-left">
                    <tr>
                        <td>
                            <?php echo Form::label('Année', 'annee'); ?>
                            <?php echo Form::input('annee', Input::post('annee', isset($heures) ? $heures->annee : ''), array('tabindex' => 1)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>                
                            <?php echo Form::label('Janvier', 'janvier'); ?>
                            <?php echo Form::input('janvier', Input::post('janvier', isset($heures) ? $time->TimeToString($heures->janvier) : ''), array('tabindex' => 2)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>                
                            <?php echo Form::label('Février', 'fevrier'); ?>
                            <?php echo Form::input('fevrier', Input::post('fevrier', isset($heures) ? $time->TimeToString($heures->fevrier) : ''), array('tabindex' => 3)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>                
                            <?php echo Form::label('Mars', 'mars'); ?>
                            <?php echo Form::input('mars', Input::post('mars', isset($heures) ? $time->TimeToString($heures->mars) : ''), array('tabindex' => 4)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>                
                            <?php echo Form::label('Avril', 'avril'); ?>
                            <?php echo Form::input('avril', Input::post('avril', isset($heures) ? $time->TimeToString($heures->avril) : ''), array('tabindex' => 5)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>                
                            <?php echo Form::label('Mai', 'mai'); ?>
                            <?php echo Form::input('mai', Input::post('mai', isset($heures) ? $time->TimeToString($heures->mai) : ''), array('tabindex' => 6)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>                
                            <?php echo Form::label('Juin', 'juin'); ?>
                            <?php echo Form::input('juin', Input::post('juin', isset($heures) ? $time->TimeToString($heures->juin) : ''), array('tabindex' => 7)); ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="form-right">
                    <tr>
                        <td>
                            <?php echo Form::label('Juillet', 'juillet'); ?>
                            <?php echo Form::input('juillet', Input::post('juillet', isset($heures) ? $time->TimeToString($heures->juillet) : ''), array('tabindex' => 8)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Form::label('Août', 'aout'); ?>
                            <?php echo Form::input('aout', Input::post('aout', isset($heures) ? $time->TimeToString($heures->aout) : ''), array('tabindex' => 9)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Form::label('Septembre', 'septembre'); ?>
                            <?php echo Form::input('septembre', Input::post('septembre', isset($heures) ? $time->TimeToString($heures->septembre) : ''), array('tabindex' => 10)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Form::label('Octobre', 'octobre'); ?>
                            <?php echo Form::input('octobre', Input::post('octobre', isset($heures) ? $time->TimeToString($heures->octobre) : ''), array('tabindex' => 11)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Form::label('Novembre', 'novembre'); ?>
                            <?php echo Form::input('novembre', Input::post('novembre', isset($heures) ? $time->TimeToString($heures->novembre) : ''), array('tabindex' => 12)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Form::label('Décembre', 'decembre'); ?>
                            <?php echo Form::input('decembre', Input::post('decembre', isset($heures) ? $time->TimeToString($heures->decembre) : ''), array('tabindex' => 13)); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</fieldset>

<div class="form-actions">
    <button type="submit" class="btn btn-success">Suivant</button>
</div>

<?php echo Form::close(); ?>

<?php echo render($partial_dir.'_back.php', array('url' => Uri::create($view_dir))); ?>