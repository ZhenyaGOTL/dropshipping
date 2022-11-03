<?php
namespace DropShipping\Controller\Admin;

class Send extends \RS\Controller\Admin\Front{
    function actionDrop()
    { 
        $id = $this->url->request('id', TYPE_STRING, 0);
        $order_api = new \Shop\Model\OrderApi;
        $order = $order_api->getElement();
        $order->load($id);
        var_dump($order['warehouse']);
        $config = \RS\Config\Loader::byModule('dropshipping');
        $c = curl_init('http://api.ds-platforma.ru/ds_order.php');
        $post = [
            'ApiKey' => $config['token'],
            'TestMode' => 1,
            'ExtOrderID' => $id,
            'dsFio' => $order,
        ];
        $this->result->setSuccess(true);
        $this->result->setSuccessText(t('Изменения успешно сохранены'));
    }
}