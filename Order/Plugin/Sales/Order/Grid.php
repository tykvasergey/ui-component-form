<?php


namespace BroSolutions\Order\Plugin\Sales\Order;


class Grid
{
    public static $table = 'sales_order_grid';
    public static $leftJoinTable = 'sales_order';

    public function afterSearch($intercepter, $collection)
    {
        if ($collection->getMainTable() === $collection->getConnection()->getTableName(self::$table)) {

            $leftJoinTableName = $collection->getConnection()->getTableName(self::$leftJoinTable);

            $collection
                ->getSelect()
                ->joinLeft(
                    ['co'=>$leftJoinTableName],
                    "co.entity_id = main_table.entity_id",
                    [
                        'expected_date' => 'co.expected_date',
                        'next_contact_date' => 'co.next_contact_date',
                        'total_due' => 'co.total_due'
                    ]
                );
            $where = $collection->getSelect()->getPart(\Magento\Framework\DB\Select::WHERE);
            $collection->getSelect()->setPart(\Magento\Framework\DB\Select::WHERE, $where);
        }
        return $collection;
    }
}