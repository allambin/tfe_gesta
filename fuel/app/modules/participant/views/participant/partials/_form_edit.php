<script>
    $.datepicker.setDefaults({
        dateFormat: 'dd-mm-yy',
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true,
        dayNamesMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
        firstDay: 1
    });
    // Fonction datepicker pour la date de naissance
    $(function(){
        $('#form_d_date_naissance').datepicker({
            yearRange: '-100:+10'
        });
    });
    
    // Fonction datepicker pour la date de naissance
    $(function(){
        $('.dp').datepicker({
            yearRange: '-100:+10'
        }).attr("readonly","readonly");
    });
    
    // Fonction datepicker pour la date de fin des études
    $(function(){
        $('#form_d_fin_etude').datepicker({
            yearRange: '-100:+0'
        }).attr("readonly","readonly");
    });
    
    // Fonction datepicker pour la date du permis théorique
    $(function(){
        $('#form_d_date_permis_theorique').datepicker({
            yearRange: '-100:+0'
        }).attr("readonly","readonly");
    });
    
    // Fonction tabs
    $(function() {
        $( "#tabs" ).tabs();
    });
    
    // Dialog "nouvelle adresse"
    $(function() {
        $("#dialog-adresse").dialog({
            autoOpen: false,
            height: 500,
            width: 400,
            modal: true
        });

        $('#create-adresse')
//        .button()
        .click(function() {
            $('#dialog-adresse').dialog('open');
            return false;
        });
        $("#dialog-contact").dialog({
            autoOpen: false,
            height: 500,
            width: 450,
            modal: true
        });

        $('#create-contact')
//        .button()
        .click(function() {
            $('#dialog-contact').dialog('open');
            return false;
        });



    });
    
    // Fonction maskd input pour les dates
//    jQuery(function($){
//       $("#form_t_registre_national").mask("999999-999.99");
//       $("#form_t_compte_bancaire").mask("999-9999999-99");
//    });

</script>
<legend>
    <?php
    $nom = $participant->t_nom." ".$participant->t_prenom;
    $id = $participant->id_participant;
    $annee = date('Y');
    $mois = date('m');

    ?>

    <?php echo Form::open('prestation/') ?>


    Modifier le participant <?php echo $participant->t_nom." ".$participant->t_prenom; ?> -

    <?php echo Form::hidden('idparticipant',$id) ?>
    <?php echo Form::hidden('nom',$nom) ?>
    <?php echo Form::hidden('annee',$annee) ?>
    <?php echo Form::hidden('mois',$mois) ?>
    <?php echo Form::button('Prestation',Null,array('class'=> 'btn btn-link')); ?>
    <?php echo Form::close(); ?>

</legend>

<?php echo Form::open(array('class' => 'form-horizontal')); ?>
    <fieldset>


        <ul id="gestaTab" class="nav nav-pills">
            <li class="active"><a href="#signaletique" data-toggle="tab" onclick="fill_hidden_input('signaletique')">Signalétique</a></li>
            <li><a href="#adresse" data-toggle="tab" onclick="fill_hidden_input('adresse')">Adresse</a></li>
            <li><a href="#situation" data-toggle="tab" onclick="fill_hidden_input('situation')">Situation</a></li>
            <li><a href="#contact" data-toggle="tab" onclick="fill_hidden_input('contact')">Personne contact</a></li>
            <li><a href="#diplome" data-toggle="tab" onclick="fill_hidden_input('diplome')">Diplôme</a></li>
        <!--    <li><a href="#fin_formation" data-toggle="tab" onclick="fill_hidden_input('fin_formation')">Fin de Formation</a></li>-->
            <li><?php echo Html::anchor('contrat/ajouter/'.$participant->id_participant,'Contrat') ?></li>

            <li><a href="#employabilite" data-toggle="tab" onclick="fill_hidden_input('employabilite')">Employabilité</a></li>

            <li><a href="#checklist" data-toggle="tab" onclick="fill_hidden_input('checklist')">Checklist</a></li>
        </ul>

        <div id="gestaTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="signaletique">
                <?php echo render('participant/partials/_form_edit_signaletique'); ?>
            </div>
            <div class="tab-pane fade" id="adresse">
                <?php echo render('participant/partials/_form_list_adresse'); ?>
            </div>
            <div class="tab-pane fade" id="situation">
                <?php echo render('participant/partials/_form_edit_situation'); ?>
            </div>
            <div class="tab-pane fade" id="contact">
                <?php echo render('participant/partials/_form_list_contact'); ?>
            </div>
            <div class="tab-pane fade" id="diplome">
                <?php echo render('participant/partials/_form_edit_diplome'); ?>
            </div>
        <!--    </div> <div class="tab-pane fade" id="fin_formation">-->
        <!--        --><?php //echo render('participant/_form_edit_fin_formation'); ?>
        <!--    </div>-->
            <div class="tab-pane fade" id="employabilite"></div>


            <div class="tab-pane fade" id="checklist">
                <?php echo render('participant/partials/_form_checklist'); ?>
            </div>
        </div>
    </fieldset>

    <input type="hidden" name="tab" value="" />
    <div class="form-actions">
        <button type="submit" class="btn btn-success">Modifier le participant</button>
    </div>

<?php echo Form::close(); ?>



<div id="dialog-adresse">
    <?php echo render('participant/partials/_form_ajouter_adresse'); ?>
</div>

<div id="dialog-contact">
    <?php echo render('participant/partials/_form_ajouter_contact'); ?>
</div>

<script type="text/javascript">

function fill_hidden_input($value)
{
    $('input[name="tab"]').val($value);
}


</script>