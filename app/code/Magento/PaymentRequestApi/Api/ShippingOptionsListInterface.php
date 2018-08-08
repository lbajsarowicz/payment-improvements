<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Api;


interface ShippingOptionsListInterface
{
    /**
     * @param \Magento\PaymentRequestApi\Api\AddressInterface $addressInit
     * @return \Magento\PaymentRequestApi\Api\PaymentShippingOptionInterface[]
     */
    public function get(AddressInterface $addressInit): array;
}
