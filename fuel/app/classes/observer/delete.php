<?php

class Observer_Delete extends Orm\Observer
{
    
    public function before_delete(Orm\Model $model)
    {
        \DB::delete('adresse')
                ->where(array('contact_id' => $model->id_contact))
                ->execute();
    }

}

?>
