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
        $post = [
            'order' => implode(',',$products),
            'ApiKey' => $config['token'],
            'TestMode' => $config['test'],
            'ExtOrderID' => $id,
            'dsFio' => $order->user_fio,
            'dsMobPhone' => $order->user_phone,
            'dsEmail' => $order->user_email,
            'ExtOrderPaid' => $order->is_payed,
            'dsDelivery' => $config['drop'.$order->delivery],
            'ExtDeliveryCost' => (int)$order->user_delivery_cost,
            'dsPickUpId' => $order->getSelectedPvz()->id,
            
        ];
        $header = [
            'Content-type: application/json',
        ];
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($c, CURLOPT_HTTPHEADER, true);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_exec($c);
        curl_close($c);
        $this->result->setSuccess(true);
        $this->result->setSuccessText(t('Заказ отправлен'));
    }
}