<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;

use Magento\PaymentRequestApi\Api\Data\PaymentCurrencyAmountInterface;
use Magento\PaymentRequestApi\Api\Data\PaymentShippingOptionInterface;

/**
 * @inheritdoc
 */
class PaymentShippingOption implements PaymentShippingOptionInterface
{

    /**
     * @inheritdoc
     */
    public function setId(string $id): void
    {
        // TODO: Implement setId() method.
    }

    /**
     * @inheritdoc
     */
    public function getId(): string
    {
        // TODO: Implement getId() method.
    }

    /**
     * @inheritdoc
     */
    public function setLabel(string $label): void
    {
        // TODO: Implement setLabel() method.
    }

    /**
     * @inheritdoc
     */
    public function getLabel(): string
    {
        // TODO: Implement getLabel() method.
    }

    /**
     * @inheritdoc
     */
    public function setAmount(PaymentCurrencyAmountInterface $amount): void
    {
        // TODO: Implement setAmount() method.
    }

    /**
     * @inheritdoc
     */
    public function getAmount(): PaymentCurrencyAmountInterface
    {
        // TODO: Implement getAmount() method.
    }
}