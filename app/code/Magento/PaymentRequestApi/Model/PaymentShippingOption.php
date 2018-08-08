<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;

use Magento\Framework\DataObject;
use Magento\PaymentRequestApi\Api\Data\PaymentCurrencyAmountInterface;
use Magento\PaymentRequestApi\Api\Data\PaymentShippingOptionInterface;

/**
 * @inheritdoc
 */
class PaymentShippingOption extends DataObject implements PaymentShippingOptionInterface
{
    /**
     * @inheritdoc
     */
    public function setId(string $id): void
    {
        $this->setData(self::ID, $id);
    }

    /**
     * @inheritdoc
     */
    public function getId(): string
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritdoc
     */
    public function setLabel(string $label): void
    {
        $this->setData(self::LABEL, $label);
    }

    /**
     * @inheritdoc
     */
    public function getLabel(): string
    {
        return $this->getData(self::LABEL);
    }

    /**
     * @inheritdoc
     */
    public function setAmount(PaymentCurrencyAmountInterface $amount): void
    {
        $this->setData(self::AMOUNT, $amount);
    }

    /**
     * @inheritdoc
     */
    public function getAmount(): PaymentCurrencyAmountInterface
    {
        return $this->getData(self::AMOUNT);
    }
}
