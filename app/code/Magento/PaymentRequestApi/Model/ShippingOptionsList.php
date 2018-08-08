<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;

use Magento\PaymentRequestApi\Api\Data\AddressInterface;
use Magento\PaymentRequestApi\Api\Data\PaymentShippingOptionInterfaceFactory as ShippingOptionFactory;
use Magento\PaymentRequestApi\Api\Data\PaymentCurrencyAmountInterfaceFactory as CurrencyAmountFactory;
use Magento\PaymentRequestApi\Api\ShippingOptionsListInterface;

/**
 * @inheritdoc
 */
class ShippingOptionsList implements ShippingOptionsListInterface
{
    /** @var ShippingOptionFactory */
    private $shippingOptionFactory;

    /** @var CurrencyAmountFactory */
    private $currencyAmountFactory;

    public function __construct(
        ShippingOptionFactory $shippingOptionFactory,
        CurrencyAmountFactory $currencyAmountFactory
    ) {
        $this->shippingOptionFactory = $shippingOptionFactory;
        $this->currencyAmountFactory = $currencyAmountFactory;
    }


    /**
     * @inheritdoc
     */
    public function get(AddressInterface $address): array
    {
        // @todo remove dummy implementation
        $shippingOption1 = $this->shippingOptionFactory->create();
        $amount = $this->currencyAmountFactory->create();
        $amount->setCurrency('$');
        $amount->setValue('15.14');

        $shippingOption1->setId('test_1');
        $shippingOption1->setLabel('Test Shipment 1');
        $shippingOption1->setAmount($amount);


        $shippingOption2 = $this->shippingOptionFactory->create();
        $amount2 = $this->currencyAmountFactory->create();
        $amount2->setCurrency('$');
        $amount2->setValue('25.14');

        $shippingOption2->setId('test_2');
        $shippingOption2->setLabel('Test Shipment 2');
        $shippingOption2->setAmount($amount2);

        return [$shippingOption1, $shippingOption2];
    }
}
