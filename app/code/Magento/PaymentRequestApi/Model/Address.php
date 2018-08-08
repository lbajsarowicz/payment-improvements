<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;

use Magento\Framework\DataObject;
use Magento\PaymentRequestApi\Api\Data\AddressInterface;

/**
 * @inheritdoc
 */
class Address extends DataObject implements AddressInterface
{
    /**
     * @inheritdoc
     */
    public function getCountry(): string
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * @inheritdoc
     */
    public function setCountry(string $country): void
    {
        $this->setData(self::COUNTRY, $country);
    }

    /**
     * @inheritdoc
     */
    public function setRegionCode(string $regionCode): void
    {
        $this->setData(self::REGION_CODE, $regionCode);
    }

    /**
     * @inheritdoc
     */
    public function getRegionCode(): string
    {
        return $this->getData(self::REGION_CODE);
    }
}
