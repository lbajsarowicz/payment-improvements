<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;

use Magento\PaymentRequestApi\Api\Data\AddressInterface;
use Magento\PaymentRequestApi\Api\ShippingOptionsListInterface;

/**
 * @inheritdoc
 */
class ShippingOptionsList implements ShippingOptionsListInterface
{
    /**
     * @inheritdoc
     */
    public function get(AddressInterface $address): array
    {
        return [];
    }
}