<script>
    $(function () {
        $('.jour').datepicker({
            dateFormat:'dd/mm/yy',
            selectOtherMonths:true,
            changeMonth:true,
            changeYear:true,
            dayNamesMin:['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
            firstDay:1,
            yearRange:'c-2:c+4',
            onSelect:function (dateText, inst) {
                $('#form_id').submit();
            }
        })

    });
</script>

<script type="text/javascript">

    function InactiveCheckBox(Quoi,Qui){
        document.getElementById(Quoi).checked = false ;
        document.getElementById(Qui).checked = false ;
    }
</script>



<div class="row">
    <div class="span4">
        <h2 class="smaller">Semaine du <?php echo $date[0]->format('d-m-Y') . ' <br />au ' . $date[4]->format('d-m-Y') ?></h2>
    </div>
    
    <div class="span4 offset2">
        <?php echo Form::open(array('action' => 'tableau/', 'class' => 'form_heures right','id'=>'form_id')); ?>

        <?php echo Form::label('Changement de semaine'); ?>
        <?php echo Form::input('change', '', array('class' => 'jour control-group', 'required' => 'required')) ?>

        <?php echo Form::close(); ?>
    </div>
</div>

<div class="row bottom-space">
        <?php echo Form::open(array('action' => 'tableau/', 'class' => 'inline')); ?>
        <?php echo Form::hidden('change', $pre);?>
        <?php echo Form::submit('submit_choix', 'Semaine précédente', array('class' => "btn btn-small btn-previous")); ?>
        <?php echo Form::close();?>
    
        <?php echo Form::open(array('action' => 'tableau/', 'class' => 'inline')); ?>

        <?php echo Form::hidden('change', $next); ?>
        <?php echo Form::submit('submit_choix', 'Semaine suivante', array('class' => "btn btn-small btn-next")); ?>
        <?php echo Form::close();?>
</div>


<div class="row">
    <div class="span12">
        <ul class="nav nav-pills">
            <li>P : Présence : <?php echo Asset::img(array('default.png'));?> &nbsp;&nbsp;</li>
            <li>J : Absence justifié : <?php echo Asset::img(array('jaune.png'));?> &nbsp;&nbsp;</li>
            <li>A : Absence <b>non</b> justifié : <?php echo Asset::img(array('excla.png'));?> </li>
        </ul>
    </div>
</div>


<?php foreach ($groupe as $groupes): ?>
<table class="table form-inline table-striped table-inner-bordered table-top table-condensed">

    <?php echo Form::open(array('action' => 'tableau/')); ?>
    <?php

    /**
     * Le champs caché suivant va permettre de retourner sur le tableau où nous avons modifier les heures formateurs
     */
    echo Form::hidden('affiche', $date[0]->format('d-m-Y')); ?>

    <thead>
        <tr>
            <th class="text-center tdark tbigger" colspan="6"><?php echo $groupes['t_nom']; ?></th>
        </tr>
        <tr>
            <th>Stagiaires</th>
            <th class="text-center">L</th>
            <th class="text-center">M</th>
            <th class="text-center">M</th>
            <th class="text-center">J</th>
            <th class="text-center">V</th>
        </tr>
    </thead>
    
    <tbody>
        <tr>
            <td></td>
            <?php foreach ($date as $value): ?>
            <td class="text-center"><?php echo $value->format('j/n/y') ?></td>
            <?php endforeach; ?>
        </tr>

        <?php $a = 0; ?>
        <?php foreach ($groupes['participant'] as $participant):?>
        <?php if (in_array(true, $participant['contrat'])): ?>
        
        <tr>
            <td><?php echo $participant['t_nom'].' '.$participant['t_prenom']; ?></td>

            <?php $i = 0; ?>
            <?php foreach ($participant['contrat'] as $contrat): ?>
                <?php if ($contrat[0] !== false): ?>
                    <?php $h = '7:30';
                    if ($i === 4) {
                        $h = '6:30';
                    } ?>

                    <?php if ($contrat[1] == '+'): ?>

                        <td class="text-center"><?php echo Asset::img(array('default.png'));?></td>

                    <?php elseif ($contrat[1] == '*'): ?>

                        <td class="text-center"><?php echo Asset::img(array('excla.png'));?></td>

                    <?php elseif ($contrat[1] == '0'): ?>

                        <td class="text-center">
                                <?php echo Form::label('P', 'action'); ?>
                                <?php echo Form::checkbox('action[]', $date[$i]->format('Y-m-d') . '/' .
                                $participant['id_participant'] . '/' . $participant[(string)$i] . '/+/' . $participant['id_contrat'][0]['id_contrat'] . '/Travail',
                                array('id'=>'check'.$i.$a,'onclick'=>"InactiveCheckBox('chick$i$a','chock$i$a');")) ?>
                                <br />
                                <?php echo Form::label('J', 'action'); ?>
                                <?php echo Form::checkbox('action[]', $date[$i]->format('Y-m-d') . '/' .
                                $participant['id_participant'] . '/' . $participant[(string)$i] . '/%/' . $participant['id_contrat'][0]['id_contrat'] . '/Absence à Justifier',
                                array('id'=>'chick'.$i.$a,'onclick'=>"InactiveCheckBox('check$i$a','chock$i$a');")) ?>
                                <br />
                                <?php echo Form::label('A', 'action'); ?>
                                <?php echo Form::checkbox('action[]', $date[$i]->format('Y-m-d') . '/' .
                                $participant['id_participant'] . '/' . $participant[(string)$i] . '/*/' . $participant['id_contrat'][0]['id_contrat'] . '/Absence',
                                array('id'=>'chock'.$i.$a,'onclick'=>"InactiveCheckBox('check$i$a','chick$i$a');")) ?>


                        </td>
                          
                    <?php else : ?>

                        <td class="text-center"><?php echo Asset::img(array('jaune.png'));?></td>

                    <?php endif; ?>

                    <?php else : ?>
                        <td></td>
                    <?php endif; ?>
                    <?php $i++; ?>
                    <?php $a++; ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </tr>

        <?php endforeach; ?>

        <tr>
            <th colspan="6" class="text-right tdark"><?php echo Form::submit('submit_choix', 'Enregistrer présences', array('class' => "btn btn-success btn-mini")); ?></th>
        </tr>
    </tbody>
</table>


<?php echo Form::close(); ?>
<br/>
<?php endforeach;




