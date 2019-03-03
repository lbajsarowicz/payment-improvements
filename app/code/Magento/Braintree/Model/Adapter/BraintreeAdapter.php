<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Braintree\Model\Adapter;

use Braintree\CreditCard;
use Braintree\ResourceCollection;
use Braintree\Result\Successful;
use Braintree\Result\Error;
use Magento\Braintree\Model\Adminhtml\Source\Environment;

/**
 * Class BraintreeAdapter
 * Use \Magento\Braintree\Model\Adapter\BraintreeAdapterFactory to create new instance of adapter.
 */
class BraintreeAdapter
{
    /**
     * @var \Braintree\Gateway
     */
    private $braintreeGateway;

    /**
     * BraintreeAdapter constructor.
     * @param $merchantId
     * @param $publicKey
     * @param $privateKey
     * @param $environment
     * @param BraintreeGatewayFactory|null $braintreeGatewayFactory
     */
    public function __construct(
        $merchantId,
        $publicKey,
        $privateKey,
        $environment,
        BraintreeGatewayFactory $braintreeGatewayFactory
    ) {
        $this->braintreeGateway = $braintreeGatewayFactory->create([
            'environment' => $environment === Environment::ENVIRONMENT_PRODUCTION ?
                Environment::ENVIRONMENT_PRODUCTION :
                Environment::ENVIRONMENT_SANDBOX,
            'merchantId' => $merchantId,
            'publicKey' => $publicKey,
            'privateKey' => $privateKey
        ]);
    }

    /**
     * @param array $params
     * @return string|null
     */
    public function generate(array $params = [])
    {
        try {
            return $this->braintreeGateway->clientToken()->generate($params);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param string $token
     * @return CreditCard|null
     */
    public function find($token)
    {
        try {
            return $this->braintreeGateway->creditCard()->find($token);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param array $filters
     * @return ResourceCollection
     */
    public function search(array $filters)
    {
        return $this->braintreeGateway->transaction()->search($filters);
    }

    /**
     * @param $token
     * @return Successful
     */
    public function createNonce($token)
    {
        return $this->braintreeGateway->paymentMethodNonce()->create($token);
    }

    /**
     * @param array $attributes
     * @return \Braintree\Result\Error|\Braintree\Result\Successful
     */
    public function sale(array $attributes)
    {
        return $this->braintreeGateway->transaction()->sale($attributes);
    }

    /**
     * @param string $transactionId
     * @param null|float $amount
     * @return \Braintree\Result\Error|\Braintree\Result\Successful
     */
    public function submitForSettlement($transactionId, $amount = null)
    {
        return $this->braintreeGateway->transaction()->submitForSettlement($transactionId, $amount);
    }

    /**
     * @param string $transactionId
     * @return Error|Successful
     */
    public function void($transactionId)
    {
        return $this->braintreeGateway->transaction()->void($transactionId);
    }

    /**
     * @param string $transactionId
     * @param null|float $amount
     * @return Error|Successful
     */
    public function refund($transactionId, $amount = null)
    {
        return $this->braintreeGateway->transaction()->refund($transactionId, $amount);
    }

    /**
     * @param string $transactionId
     * @param array $attributes
     * @return Error|Successful
     */
    public function cloneTransaction($transactionId, array $attributes)
    {
        return $this->braintreeGateway->transaction()->cloneTransaction($transactionId, $attributes);
    }
}
