<?php


namespace BroSolutions\Order\Model;


class Order
{

    public function __construct(
        \BroSolutions\Order\Model\ResourceModel\Order $order
    ){
        $this->order = $order;
    }

    /**
     * @param $orderId
     * @param $paramName
     * @param $value
     */
    public function updateOrder($orderId, $paramName, $value)
    {
        $result = $this->order->updateOrder($orderId, $paramName, $value);

        return $result;
    }

}