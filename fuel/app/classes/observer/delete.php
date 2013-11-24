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
                
                break;
            default:
                break;
        }
    }

}

?>
