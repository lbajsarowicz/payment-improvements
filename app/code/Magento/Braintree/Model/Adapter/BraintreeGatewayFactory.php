<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Braintree\Model\Adapter;

use Braintree\Gateway;

class BraintreeGatewayFactory
{
    /**
     * @param array $config
     * @return Gateway
     */
    public function create(array $config): Gateway
    {
        return new Gateway($config);
    }
}
