<?php echo render($view_dir.'/h2/prestations.php'); ?>

<?php echo Form::open(); ?>

<fieldset>
    <legend>Ajouter une année</legend>
    
    <table class="form">
        <tr>
            <td>
                <?php echo Form::label('Année', 'annee'); ?>
                <?php echo Form::input('annee', isset($jours) ? $jours->annee : '', array('tabindex' => 1)); ?>
            </td>
            <td>                
                <?php echo Form::label('Juillet', 'jours_juillet'); ?>
                <?php echo Form::input('jours_juillet', isset($jours) ? $jours->jours_juillet : '', array('tabindex' => 8)); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Form::label('Janvier', 'jours_janvier'); ?>
                <?php echo Form::input('jours_janvier', isset($jours) ? $jours->jours_janvier : '', array('tabindex' => 2)); ?>
            </td>
            <td>
                <?php echo Form::label('Août', 'jours_aout'); ?>
                <?php echo Form::input('jours_aout', isset($jours) ? $jours->jours_aout : '', array('tabindex' => 9)); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Form::label('Février', 'jours_fevrier'); ?>
                <?php echo Form::input('jours_fevrier', isset($jours) ? $jours->jours_fevrier : '', array('tabindex' => 3)); ?>
            </td>
            <td>
                <?php echo Form::label('Septembre', 'jours_septembre'); ?>
                <?php echo Form::input('jours_septembre', isset($jours) ? $jours->jours_septembre : '', array('tabindex' => 10)); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Form::label('Mars', 'jours_mars'); ?>
                <?php echo Form::input('jours_mars', isset($jours) ? $jours->jours_mars : '', array('tabindex' => 4)); ?>
            </td>
            <td>
                <?php echo Form::label('Octobre', 'jours_octobre'); ?>
                <?php echo Form::input('jours_octobre', isset($jours) ? $jours->jours_octobre : '', array('tabindex' => 11)); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Form::label('Avril', 'jours_avril'); ?>
                <?php echo Form::input('jours_avril', isset($jours) ? $jours->jours_avril : '', array('tabindex' => 5)); ?>
            </td>
            <td>
                <?php echo Form::label('Novembre', 'jours_novembre'); ?>
                <?php echo Form::input('jours_novembre', isset($jours) ? $jours->jours_novembre : '', array('tabindex' => 12)); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Form::label('Mai', 'jours_mai'); ?>
                <?php echo Form::input('jours_mai', isset($jours) ? $jours->jours_mai : '', array('tabindex' => 6)); ?>
            </td>
            <td>
                <?php echo Form::label('Décembre', 'jours_decembre'); ?>
                <?php echo Form::input('jours_decembre', isset($jours) ? $jours->jours_decembre : '', array('tabindex' => 13)); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Form::label('Juin', 'jours_juin'); ?>
                <?php echo Form::input('jours_juin', isset($jours) ? $jours->jours_juin : '', array('tabindex' => 7)); ?>
            </td>
            <td>
                
            </td>
        </tr>
    </table>

</fieldset>

<p>
    <?php echo Form::submit('submit_jours', 'Suivant',array('class'=>'btn btn-success')); ?>
</p>
<?php echo Form::close(); ?>