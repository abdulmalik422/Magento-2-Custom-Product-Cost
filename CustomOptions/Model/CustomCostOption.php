<?php

namespace Amweb\CustomOptions\Model;

use Amweb\CustomOptions\Api\Data\CustomCostOptionInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

class CustomCostOption extends AbstractExtensibleModel implements CustomCostOptionInterface
{
    /**
     * @inheritDoc
     */
    public function getOptionLabel()
    {
        return $this->getData(self::OPTION_LABEL);
    }

    /**
     * @inheritDoc
     */
    public function setOptionLabel($value)
    {
        return $this->setData(self::OPTION_LABEL, $value);
    }

    /**
     * @inheritDoc
     */
    public function getOptionValue()
    {
        return $this->getData(self::OPTION_VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setOptionValue($value)
    {
        return $this->setData(self::OPTION_VALUE, $value);
    }

    /**
     * @inheritDoc
     */
    public function getOptionCost()
    {
        return $this->getData(self::OPTION_COST);
    }

    /**
     * @inheritDoc
     */
    public function setOptionCost($value)
    {
        return $this->setData(self::OPTION_COST, $value);
    }

    /**
     * @inheritDoc
     */
    public function getOptionPrice()
    {
        return $this->getData(self::OPTION_PRICE);
    }

    /**
     * @inheritDoc
     */
    public function setOptionPrice($value)
    {
        return $this->setData(self::OPTION_PRICE, $value);
    }
}
