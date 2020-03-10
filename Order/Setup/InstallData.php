<?php

namespace BroSolutions\Order\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Sales\Model\Order;
use Magento\Eav\Model\Entity\Attribute\Backend\Datetime;
use Magento\Framework\DB\Ddl\Table;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    public function __construct(
        EavSetupFactory $eavSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup,
        \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory,
        \Magento\Quote\Setup\QuoteSetupFactory $quoteSetupFactory

    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
        $this->salesSetupFactory = $salesSetupFactory;
        $this->quoteSetupFactory = $quoteSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $codeAttributes = ['expected_date', 'next_contact_date'];

        foreach ($codeAttributes as $codeAttribute) {

            /** @var SalesSetup $salesSetup */
            $salesSetup = $this->salesSetupFactory->create(['setup' => $setup]);

            $attributeOptions = [
                'type' => Table::TYPE_DATE,
                'label' => 'Expected Arrival Date',
                'input' => 'date',
                'backend' => Datetime::class,
                'required' => false,
                'sort_order' => 5,
                'global' => ScopedAttributeInterface::SCOPE_WEBSITE,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'visible' => true,
                'nullable' => true
            ];

            // sales_order
            $salesSetup->addAttribute('order', $codeAttribute, $attributeOptions);
        }
    }
}
