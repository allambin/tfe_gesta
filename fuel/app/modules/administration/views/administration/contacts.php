<fieldset>
    <legend>Gestion des types de contact</legend>
    
    <a href="administration/ajouter_typesContact" class="btn btn-success"><i class="icon-white icon-plus"></i> Ajouter un type</a>
    
    <table class="table table-striped table-top">
        <tr>
            <th>Nom</th>
            <th></th>
        </tr>
        <?php
        foreach ($types as $type) {
        ?>
        <tr>
            <td><?php echo $type->t_typecontact; ?></td>
            <td class="go-right">
                <a class="btn btn-mini btn-warning" href="<?php echo Uri::create('administration/modifier_typesContact/'.$type->id_type_contact); ?>"><i class="icon-edit icon-white"></i></a>
                <a class="btn btn-mini btn-danger" href="<?php echo Uri::create('administration/supprimer_typesContact/'.$type->id_type_contact); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce type de contact ?')"><i class="icon-remove-sign icon-white"></i></a>
            </td>
        </tr>    
        <?php
        }
        ?>
    </table>
</fieldset>