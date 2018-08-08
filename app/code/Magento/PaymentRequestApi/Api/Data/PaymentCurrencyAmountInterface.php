<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Api\Data;

/**
 * Represents PaymentCurrencyAmount is used to supply monetary amounts for
 * the PaymentRequestApi.
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser.
 *
 * @api
 */
interface PaymentCurrencyAmountInterface
{

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @param string $currency
     * @return void
     */
    public function setCurrency(string $currency): void;

    /**
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void;

    /**
     * @return string
     */
    public function getValue(): string;

}