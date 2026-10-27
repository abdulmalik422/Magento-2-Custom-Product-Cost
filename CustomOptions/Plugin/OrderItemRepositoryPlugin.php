<?php
namespace Amweb\CustomOptions\Plugin;

use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Api\Data\OrderItemExtensionFactory;
use Magento\Sales\Api\Data\OrderItemSearchResultInterface;
use Magento\Sales\Api\OrderItemRepositoryInterface;

class OrderItemRepositoryPlugin
{
    protected $orderItemExtensionFactory;
    protected $_customCostOptionFactory;

    public function __construct(
        OrderItemExtensionFactory $orderItemExtensionFactory,
        \Amweb\CustomOptions\Model\CustomCostOptionFactory $customCostOptionFactory
    ) {
        $this->_customCostOptionFactory = $customCostOptionFactory;
        $this->orderItemExtensionFactory = $orderItemExtensionFactory;
    }

    public function afterGetList(
        OrderItemRepositoryInterface $subject,
        OrderItemSearchResultInterface $result
    ) {
        foreach ($result->getItems() as $orderItem) {
            $this->setCustomOptionsAttributes($orderItem);
        }
        return $result;
    }

    protected function setCustomOptionsAttributes(OrderItemInterface $orderItem)
    {
        $existingOptions = $orderItem->getProductOptions();
        $optionDataView = []; $customOption = $this->_customCostOptionFactory->create();

        $customOption->setOptionCost($optionData['product_cost'] ?? 'test');

        if(isset($existingOptions['options'])){
            foreach ($existingOptions['options'] as $optionData) {
                $customOption = $this->_customCostOptionFactory->create();
                $customOption->setOptionLabel($optionData['label'] ?? '');
                $customOption->setOptionValue($optionData['value'] ?? '');
                $customOption->setOptionCost($optionData['product_cost'] ?? '0');
                $customOption->setOptionPrice($optionData['product_price'] ?? '');
                $optionDataView[] = $customOption;
            }
        }

        $extensionAttributes = $orderItem->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->orderItemExtensionFactory->create();
        $extensionAttributes->setDetailedCustomOptions($optionDataView);
        $orderItem->setExtensionAttributes($extensionAttributes);

        return $orderItem;
    }

}

