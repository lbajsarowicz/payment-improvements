<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Api;

/**
 * Represents PaymentShippingOption dictionary describing a shipping option for
 * the PaymentRequestApi.
 *
 * Used fully qualified namespaces in annotations for proper work of WebApi request parser.
 *
 * @api
 */
interface PaymentShippingOptionInterface
{
    /**
     * @param string $id
     * @return void
     */
    public function setId(string $id): void;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $label
     * @return void
     */
    public function setLabel(string $label): void;

    /**
     * @return string
     */
    public function getLabel(): string;

    /**
     * @param \Magento\PaymentRequestApi\Api\PaymentCurrencyAmountInterface $amount
     * @return void
     */
    public function setAmount(PaymentCurrencyAmountInterface $amount): void;

    /**
     * @return \Magento\PaymentRequestApi\Api\PaymentCurrencyAmountInterface
     */
    public function getAmount(): PaymentCurrencyAmountInterface;
}
