<?php

class Observer_Delete extends Orm\Observer
{
    
    public function before_delete(Orm\Model $model)
    {
        switch (get_class($model))
        {
            case 'Model_Contact':
                $adresses = Model_Adresse::find('all', array(
                    'where' => array(
                        array('contact_id', $model->id_contact),
                    )
                ));
                
                foreach ($adresses as $adresse)
                    $adresse->delete();
                
                break;
            case 'Model_Contrat':
                $formations = Model_Formation::find('all', array(
                    'where' => array(
                        array('contrat_id', $model->id_contrat),
                    )
                ));
                
                foreach ($formations as $formation)
                    $formation->delete();
                
                $heures = Model_Heures::find('all', array(
                    'where' => array(
                        array('contrat_id', $model->id_contrat),
                    )
                ));
                
                foreach ($heures as $heure)
                    $heure->delete();
                
                break;
            case 'Model_Participant':
                $adresses = Model_Adresse::find('all', array(
                    'where' => array(
                        array('participant_id', $model->id_participant),
                    )
                ));
                
                foreach ($adresses as $adresse)
                    $adresse->delete();
                
                $contacts = Model_Contact::find('all', array(
                    'where' => array(
                        array('participant_id', $model->id_participant),
                    )
                ));
                
                foreach ($contacts as $contact)
                    $contact->delete();
                
                $contrats = Model_Contrat::find('all', array(
                    'where' => array(
                        array('participant_id', $model->id_participant),
                    )
                ));
                
                foreach ($contrats as $contrat)
                    $contrat->delete();
                
                \DB::delete('ajout_deplacement')->where('participant_id', '=', $model->id_participant)->execute();
                \DB::delete('heures')->where('participant_id', '=', $model->id_participant)->execute();
                \DB::delete('heures_fixer')->where('participant_id', '=', $model->id_participant)->execute();
                \DB::delete('valider_heure')->where('participant_id', '=', $model->id_participant)->execute();
                
                break;
            default:
                break;
        }
    }

}

?>
