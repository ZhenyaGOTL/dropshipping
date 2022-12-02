<?php
namespace DropShipping\Controller\Admin;
use Shop\Model\Cart;

class Send extends \RS\Controller\Admin\Front{
    function actionDrop()
    { 
        $id = $this->url->request('order_id', TYPE_STRING, 0);
        $order_api = new \Shop\Model\OrderApi();
        $order = $order_api->getElement();
        $order->load($id);
        $cart = $order->getCart();
        $order_data = $cart->getOrderData(true, false);
        $products = [];
        foreach ($order_data['items'] as $n => $item){
            $products[] = $item['cartitem']->barcode.'-'.$item['cartitem']->amount.'-'.(int)$item['cartitem']->single_cost;
        }
        $config = \RS\Config\Loader::byModule('dropshipping');
        $c = curl_init('http://api.ds-platforma.ru/ds_order.php');
        $user = $order->getUser();
        $post = [
            'ApiKey' => $config['token'],
            'order' => implode(',',$products),
            'TestMode' => $config['test'],
            'ExtOrderID' => $id,
            'dsFio' => $user->getFio(),
            'dsMobPhone' => $user['phone'],
            'dsEmail' => $user['e_mail'],
            'ExtOrderPaid' => $order->is_payed,
            'dsDelivery' => $config['drop'.$order->delivery],
            'ExtDeliveryCost' => (int)$order->user_delivery_cost,
            'dsPickUpId' => 'KTN1',
            
        ];
        var_dump($post);
        $header = [
            'Content-type: application/json',
        ];
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($c, CURLOPT_HTTPHEADER, $header);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($c);
        var_dump($res);
        curl_close($c);
        $this->result->setSuccess(true);
        $this->result->setSuccessText(t('Заказ отправлен'));
    }
}