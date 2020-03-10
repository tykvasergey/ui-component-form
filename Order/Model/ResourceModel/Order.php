<?php


namespace BroSolutions\Order\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\VersionControl\AbstractDb;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

class Order extends AbstractDb
{
    const TABLE_NAME = 'sales_order';

    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, 'entity_id');
    }

    public function updateOrder($orderId, $paramName, $value)
    {
        $data = [$paramName=>$value];
        $where = ['entity_id = ?' => (int)$orderId];
        $result = $this->getConnection()->update($this->getMainTable(), $data, $where);

        return $result;
    }

}