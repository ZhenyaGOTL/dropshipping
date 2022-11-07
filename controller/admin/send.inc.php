<?php
namespace DropShipping\Controller\Admin;

class Send extends \RS\Controller\Admin\Front{
    function actionDrop()
    { 
        $id = $this->url->request('order_id', TYPE_STRING, 0);
        $order_api = new \Shop\Model\OrderApi();
        $order = $order_api->getElement();
        $order->load($id);
        $config = \RS\Config\Loader::byModule('dropshipping');
        $c = curl_init('http://api.ds-platforma.ru/ds_order.php');
        $post = [
            'ApiKey' => $config['token'],
            'TestMode' => 1,
            'ExtOrderID' => $id,
            'dsFio' => $order->user_fio,
            'dsMobPhone' => $order->user_phone,
            'dsEmail' => $order->user_email,
            'ExtOrderPaid' => 1,
            'dsDelivery' => $order->delivery_type,
        ];
        $this->result->setSuccess(true);
        $this->result->setSuccessText(t('Заказ отправлен'));
    }
}