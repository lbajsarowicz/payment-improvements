<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Api;

interface AddressInterface
{
    /**
     * @param string $country
     */
    public function setCountry(string $country): void;

    /**
     * @return  string
     */
    public function getCountry(): string;
}
