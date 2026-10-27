<?php

namespace Amweb\CustomOptions\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\ResourceConnection;
use Magento\Catalog\Api\ProductRepositoryInterface;

class AddProductCostToOrderItem implements ObserverInterface
{
    protected $resourceConnection;
    protected $productRepository;

    public function __construct(
        ResourceConnection $resourceConnection,
        ProductRepositoryInterface $productRepository
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->productRepository = $productRepository;
    }

    /**
     * Execute the observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getOrder();
        $quote = $observer->getQuote();

        foreach ($quote->getAllItems() as $quoteItem) {
            $orderItem = $this->getOrderItemByQuoteItem(
                $order,
                $quoteItem
            );
            if ($orderItem) {
                $existingOptions = $orderItem->getProductOptions();
                if(isset($existingOptions['options'])){
                    foreach ($existingOptions['options'] as $optionId => $optionData) {
                        $productCost = $this->getProductCostForOption($optionData['option_value']);
                        $productPrice = $this->getProductPriceForOption($optionData['option_value']);
                        $existingOptions['options'][$optionId]['product_price'] = $productPrice;
                        $existingOptions['options'][$optionId]['product_cost'] = $productCost;
                    }
                    $orderItem->setProductOptions($existingOptions);
                }
            }
        }
    }

    /**
     * Fetch the product cost for a given option ID from the database
     *
     * @param int $optionTypeId
     * @return string|null
     */
    protected function getProductCostForOption($optionTypeId)
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $connection->getTableName(
            "catalog_product_option_type_value"
        );
        $select = $connection
            ->select()
            ->from($tableName, ["product_cost"])
            ->where("option_type_id = ?", $optionTypeId);

        return $connection->fetchOne($select);
    }

    /**
     * Fetch the product price for a given option ID from the database
     *
     * @param int $optionTypeId
     * @return string|null
     */
    protected function getProductPriceForOption($optionTypeId)
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $connection->getTableName(
            "catalog_product_option_type_price"
        );
        $select = $connection
            ->select()
            ->from($tableName, ["price"])
            ->where("option_type_id = ?", $optionTypeId);

        return $connection->fetchOne($select);
    }

    /**
     * Get the corresponding order item for a given quote item
     *
     * @param \Magento\Sales\Model\Order $order
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @return \Magento\Sales\Model\Order\Item|null
     */
    protected function getOrderItemByQuoteItem($order, $quoteItem)
    {
        foreach ($order->getAllItems() as $orderItem) {
            if ($orderItem->getQuoteItemId() == $quoteItem->getId()) {
                return $orderItem;
            }
        }
        return null;
    }
}

