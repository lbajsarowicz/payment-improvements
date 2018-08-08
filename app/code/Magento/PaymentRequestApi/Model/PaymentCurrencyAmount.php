<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;


use Magento\Framework\DataObject;
use Magento\PaymentRequestApi\Api\Data\PaymentCurrencyAmountInterface;

/**
 * @inheritdoc
 */
class PaymentCurrencyAmount extends DataObject implements PaymentCurrencyAmountInterface
{

    /**
     * @inheritdoc
     */
    public function getCurrency(): string
    {
        return $this->getData(self::CURRENCY);
    }

    /**
     * @inheritdoc
     */
    public function setCurrency(string $currency): void
    {
        $this->setData(self::CURRENCY, $currency);
    }

    /**
     * @inheritdoc
     */
    public function setValue(string $value): void
    {
        $this->setData(self::VALUE, $value);
    }

    /**
     * @inheritdoc
     */
    public function getValue(): string
    {
        return $this->getData(self::VALUE);
    }
}
