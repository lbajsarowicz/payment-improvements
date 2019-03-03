<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Braintree\Model\Adapter;

use Braintree\Gateway;

/**
 * The BraintreeGatewayFactory class creates a new instance of a Braintree\Gateway
 * with the configuration parameters provided via $config argument.
 */
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
