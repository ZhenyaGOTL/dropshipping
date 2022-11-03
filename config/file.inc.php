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
    }
}