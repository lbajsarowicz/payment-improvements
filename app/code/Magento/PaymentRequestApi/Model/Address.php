<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;

use Magento\Framework\Api\CustomAttributesDataInterface;
use Magento\Framework\DataObject;
use Magento\PaymentRequestApi\Api\Data\AddressInterface;

/**
 * @inheritdoc
 */
class Address implements AddressInterface
{
    /**
     * @var string
     */
    private $country;

    /**
     * @return  string
     */
    public function getCountry(): string
    {

    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {

    }
}
