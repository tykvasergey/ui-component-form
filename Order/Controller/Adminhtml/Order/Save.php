<?php


namespace BroSolutions\Order\Controller\Adminhtml\Order;

use Exception;
use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{

    public function __construct(
        Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \BroSolutions\Order\Model\Order $orderModel
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->orderModel = $orderModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $expectation = $this->getRequest()->getParam('expectation');
        if($expectation && !empty($expectation['entity_id'])) {
            $ordedId = $expectation['entity_id'];
            if(isset($expectation['expected_date'])) {
                $expectedDate = $expectation['expected_date'];

                try {
                    if (empty($expectedDate)) {
                        $dateFormat = NULL;
                    } else {
                        $date = new \DateTime($expectedDate);
                        $dateFormat = $date->format('Y-m-d');
                    }
                    $this->orderModel->updateOrder($ordedId, 'expected_date', $dateFormat);

                } catch(Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            }
            if(isset($expectation['next_contact_date'])) {
                $nextContactDate = $expectation['next_contact_date'];

                try {

                    if (empty($nextContactDate)) {
                        $dateFormat = NULL;
                    } else {
                        $date = new \DateTime($nextContactDate);
                        $dateFormat = $date->format('Y-m-d');
                    }

                    $this->orderModel->updateOrder($ordedId, 'next_contact_date', $dateFormat);

                } catch(Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('sales/order/view', array('order_id' => $ordedId));
    }

}