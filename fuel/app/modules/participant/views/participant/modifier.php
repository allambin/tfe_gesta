<?php echo render($partial_dir . '_titre_participant.php'); ?>

<?php echo render($partial_dir . '_form_edit'); ?>

<p><?php echo Html::anchor('gesta/choisir/modifier', '<i class="icon-step-backward"></i> Retour', array('class' => 'btn pull-right')); ?></p>
<div class="clear"></div>

<script type="text/javascript">
function getAge(dateString) 
{
    dateString = dateString.split('-');
    dateString = dateString[2]+","+dateString[1]+","+dateString[0];
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}
</script>