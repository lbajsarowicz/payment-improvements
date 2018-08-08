<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;

use Magento\Framework\Api\CustomAttributesDataInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\PaymentRequestApi\Api\Data\AddressInterface;

/**
 * @inheritdoc
 */
class Address extends AbstractExtensibleModel implements AddressInterface
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
}
