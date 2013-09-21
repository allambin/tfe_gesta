<?php echo render($partial_dir.'_titre_repository.php'); ?>

<h2>Changements à rapatrier</h2>
<?php if(!empty($portal['incoming_changes'])): ?>
<pre><?php echo $portal['incoming_changes']; ?></pre>
<?php else: ?>
<pre>Aucun nouveau commit</pre>
<?php endif; ?>

<?php if(!empty($portal['modified_files'])): ?>
<h2>Changements locaux</h2>
<pre><?php echo $portal['modified_files']; ?></pre>
<?php endif; ?>

<?php if(!empty($portal['incoming_changes']) && empty($portal['modified_files'])): ?>
<a href="<?php echo $view_dir ?>update" class="btn btn-success pull-right">Mettre à jour !</a>
<?php elseif(!empty($portal['modified_files'])): ?>
<a href="#" class="btn btn-danger pull-right disabled">Impossible de mettre à jour !</a>
<?php elseif(empty($portal['incoming_changes'])): ?>
<a href="#" class="btn btn-info pull-right disabled">Rien à mettre à jour !</a>
<?php endif; ?>
<div class="clear"></div>