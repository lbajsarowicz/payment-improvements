<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Test
 * @api
 */
interface AddressInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    public const COUNTRY = 'country';
    public const REGION_CODE = 'regionCode';
    /**#@-*/

    /**
     * @param string $country
     * @return void
     */
    public function setCountry(string $country): void;

    /**
     * @return string
     */
    public function getCountry(): string;

    /**
     * @param string $regionCode
     * @return void
     */
    public function setRegionCode(string $regionCode): void;

    /**
     * @return string
     */
    public function getRegionCode(): string;
}
