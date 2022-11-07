<?php
namespace DropShipping\Config;
use \RS\Orm\Type;

class File extends \RS\Orm\ConfigObject{
    function _init(){
        parent::_init()->append(array(
            'token' => new Type\Varchar(array(
                'description' => t('Токен для работы с дропшиппингом')
            ))
        ));
        $delivery_type = new \Shop\Model\DeliveryApi;
        $delivery_type->setFilter('public', 1);
        $deliveries = $delivery_type->getListAsArray();
        foreach ($deliveries as $delivery){
            parent::_init()->append(array(
                'drop'.$delivery['id'] => new Type\Integer(array(
                    'description' => t($delivery['title']),
                )),
            ));
        }
    }
}