<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Api;

/**
 * @todo  write meaningfully desciption
 *
 * @api
 */
interface ShippingOptionsListInterface
{
    /**
     * @param \Magento\PaymentRequestApi\Api\Data\AddressInterface $address
     * @return \Magento\PaymentRequestApi\Api\Data\PaymentShippingOptionInterface[]
     */
    public function get(\Magento\PaymentRequestApi\Api\Data\AddressInterface $address): array;
}
