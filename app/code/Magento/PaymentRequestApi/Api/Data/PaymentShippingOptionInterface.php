<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Api\Data;

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
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    public const ID = 'id';
    public const LABEL = 'label';
    public const  AMOUNT = ' amount';
    /**#@-*/

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
     * @param \Magento\PaymentRequestApi\Api\Data\PaymentCurrencyAmountInterface $amount
     * @return void
     */
    public function setAmount(PaymentCurrencyAmountInterface $amount): void;

    /**
     * @return \Magento\PaymentRequestApi\Api\Data\PaymentCurrencyAmountInterface
     */
    public function getAmount(): PaymentCurrencyAmountInterface;
}
