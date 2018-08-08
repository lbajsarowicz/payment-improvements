<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;

use Magento\PaymentRequestApi\Api\AddressInterface;
use Magento\PaymentRequestApi\Api\PaymentShippingOptionInterface;
use Magento\PaymentRequestApi\Api\ShippingOptionsListInterface;

/**
 * @inheritdoc
 */
class ShippingOptionsList implements ShippingOptionsListInterface
{

    /** @var PaymentShippingOptionInterfaceFactory */
    private $paymentShippingOptionFactory;

    public function __construct(PaymentShippingOptionInterfaceFactory $paymentShippingOptionFactory)
    {
        $this->paymentShippingOptionFactory = $paymentShippingOptionFactory;
    }

    /**
     * @param \Magento\PaymentRequestApi\Api\AddressInterface $addressInit
     * @return \Magento\PaymentRequestApi\Api\PaymentShippingOptionInterface[]
     */
    public function get(AddressInterface $addressInit): array
    {






    }
}