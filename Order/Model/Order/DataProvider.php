<?php


namespace BroSolutions\Order\Model\Order;


class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $orderRepository;

    protected $request;

    protected $_loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\App\RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->orderRepository = $orderRepository;

        $this->request = $request;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        return null;
    }

    public function getData()
    {
        if(isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $orderId = $this->request->getParam('order_id');
        $order = $this->orderRepository->get($orderId);
        $orderData = $order->getData();

        $this->_loadedData[$orderId]['expectation'] = $orderData;


        return $this->_loadedData;
    }
}