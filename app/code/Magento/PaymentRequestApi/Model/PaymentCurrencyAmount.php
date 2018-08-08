<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;


use Magento\PaymentRequestApi\Api\Data\PaymentCurrencyAmountInterface;

/**
 * @inheritdoc
 */
class PaymentCurrencyAmount implements PaymentCurrencyAmountInterface
{

    /**
     * @inheritdoc
     */
    public function getCurrency(): string
    {
        // TODO: Implement getCurrency() method.
    }

    /**
     * @inheritdoc
     */
    public function setCurrency(string $currency): void
    {
        // TODO: Implement setCurrency() method.
    }

    /**
     * @inheritdoc
     */
    public function setValue(string $value): void
    {
        // TODO: Implement setValue() method.
    }

    /**
     * @inheritdoc
     */
    public function getValue(): string
    {
        // TODO: Implement getValue() method.
    }
}
