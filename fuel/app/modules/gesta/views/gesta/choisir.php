<?php if($action == 'contrat'): ?>
    <h2>Gestion des contrats</h2>
<?php else : ?>
    <h2>Gestion des participants</h2>
<?php endif; ?>



<?php if(isset($errors)) echo $errors; ?>

<?php echo render('gesta/_form_choisir'); ?>