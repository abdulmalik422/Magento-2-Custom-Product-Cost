<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Amweb\CustomOptions\Api\Data;

/**
 * Interface CustomOptionInterface
 * @api
 * @since 100.0.2
 */
interface CustomCostOptionInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**#@+
     * Constants
     */
    const OPTION_LABEL = 'label';
    const OPTION_VALUE = 'value';
    const OPTION_COST = 'cost';
    const OPTION_PRICE = 'price';
    /**#@-*/

    /**
     * Get option id
     *
     * @return string
     */
    public function getOptionLabel();

    /**
     * Set option id
     *
     * @param string $value
     * @return bool
     */
    public function setOptionLabel($value);

    /**
     * Get option value
     *
     * @return string
     */
    public function getOptionValue();

    /**
     * Set option value
     *
     * @param string $value
     * @return bool
     */
    public function setOptionValue($value);

    /**
     * Get option cost
     *
     * @return string
     */
    public function getOptionCost();

    /**
     * Set option cost
     *
     * @param string $value
     * @return bool
     */
    public function setOptionCost($value);

    /**
     * Get option price
     *
     * @return string
     */
    public function getOptionPrice();

    /**
     * Set option price
     *
     * @param string $value
     * @return bool
     */
    public function setOptionPrice($value);
}
