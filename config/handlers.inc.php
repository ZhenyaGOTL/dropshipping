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
        if (!empty($config['token'])){
            $request    = new \RS\Http\Request();
            $id = $request->get('id',TYPE_INTEGER,0);
            $helper['bottomToolbar']->addItem(
                        new ToolbarButton\Button(\RS\Router\Manager::obj()->getAdminUrl('drop', ['order_id' => $id, 're'=>\RS\Router\Manager::obj()->getAdminUrl()], 'dropshipping-send'), t('Передать заказ ДРОПШИПИНГ'), [
                            'noajax' => true,
                            'attr' => [
                                'class' => 'btn btn-alt btn-primary m-l-30',
                            ]
                        ])
            );
        }
    }
}