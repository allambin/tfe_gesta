<button class="btn btn-success" id="create-contact"><i class="icon-user icon-white"></i> Nouveau contact</button>

<table class="table table-striped table-top">
    <tr>
        <th>Type</th>
        <th>Civilité</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Rue</th>
        <th>Bte</th>
        <th>CP</th>
        <th>Commune</th>
        <th>Téléphone</th>
        <th class="actions"></th>
    </tr>
    <?php foreach ($participant->contacts as $contact): ?>
        <?php if ($contact instanceof Model_Contact): ?>
            <tr>
                <td><?php echo $contact->t_type ?> <?php echo !empty($contact->t_cb_type) ? "(".$contact->t_cb_type.")" : ''; ?></td>
                <td><?php echo $contact->t_civilite ?></td>
                <td><?php echo $contact->t_nom ?></td>
                <td><?php echo $contact->t_prenom ?></td>
                <td><?php echo $contact->adresse->t_nom_rue ?></td>
                <td><?php echo $contact->adresse->t_bte ?></td>
                <td><?php echo $contact->adresse->t_code_postal ?></td>
                <td><?php echo $contact->adresse->t_commune ?></td>
                <td><?php echo $contact->adresse->t_telephone ?></td>
                <td class="text-right">
                   <a class="btn btn-mini btn-warning" href="<?php echo Uri::create('participant/modifier_contact/'.$contact->id_contact); ?>"><i class="icon-edit icon-white"></i></a>
                    <a class="btn btn-mini btn-danger" href="<?php echo Uri::create('participant/supprimer_contact/'.$contact->id_contact); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer ce contact ?')"><i class="icon-remove-sign icon-white"></i></a>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach ?>        
</table>