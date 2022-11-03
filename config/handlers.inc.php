<?php
namespace DropShipping\Config;

use RS\Html\Toolbar\Button as ToolbarButton;

class Handlers extends \RS\Event\HandlerAbstract
{
    function init(){
        $this->bind('controller.exec.shop-admin-orderctrl.edit');
    }

    public static function controllerExecShopAdminOrderctrlEdit($helper){
        $config = \RS\Config\Loader::byModule('dropshipping');
        if (!empty($token)){
            $id = $helper->url->request('id', TYPE_STRING, 0);
            $toolbar = $helper['bottomToolbar']->getItems();
            $toolbar->addItem(
                    [
                        'title' => t('Передать заказ ДРОПШИПИНГ'),
                        'attr' => [
                            'href' => \RS\Router\Manager::obj()->getAdminUrl('drop', ['order_id' => $id], 'dropshipping-send'),
                            'class' => 'btn btn-alt btn-primary m-l-30'
                        ]
                    ]
            );
        }
    }
}