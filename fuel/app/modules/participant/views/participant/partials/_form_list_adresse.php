<button class="btn btn-success" id="create-adresse"><i class="icon-home icon-white"></i> Nouvelle adresse</button>

<table class="table table-striped table-top">
    <tr>
        <th>Rue</th>
        <th>Bte</th>
        <th>CP</th>
        <th>Commune</th>
        <th>Téléphone</th>
        <th>Type</th>
        <th>Défaut</th>
        <th class="actions"></th>
    </tr>
    <?php foreach ($participant->adresses as $adresse): ?>
        <?php if ($adresse instanceof Model_Adresse): ?>
            <tr>
                <td><?php echo $adresse->t_nom_rue ?></td>
                <td><?php echo $adresse->t_bte ?></td>
                <td><?php echo $adresse->t_code_postal ?></td>
                <td><?php echo $adresse->t_commune ?></td>
                <td><?php echo $adresse->t_telephone ?></td>
                <td><?php echo $adresse->t_type ?></td>
                <td class="default">
                <?php if($adresse->t_courrier == 1)
                {
                    echo Asset::img('default.png'); 
                } ?>
                </td>
                <td class="text-right">                   
                    <a class="btn btn-mini btn-warning" href="<?php echo Uri::create('participant/modifier_adresse/'.$adresse->id_adresse); ?>"><i class="icon-edit icon-white"></i></a>
                    <a class="btn btn-mini btn-danger" href="<?php echo Uri::create('participant/supprimer_adresse/'.$adresse->id_adresse); ?>" onclick="return confirm('Etes-vous sûr de vouloir supprimer cette adresse ?')"><i class="icon-remove-sign icon-white"></i></a>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach ?>
</table>