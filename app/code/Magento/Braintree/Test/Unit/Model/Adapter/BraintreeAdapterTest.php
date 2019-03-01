<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Braintree\Test\Unit\Model\Adapter;

use Braintree\ClientTokenGateway;
use Braintree\CreditCardGateway;
use Braintree\Gateway;
use Braintree\PaymentMethodNonceGateway;
use Braintree\ResourceCollection;
use Braintree\Result\Successful;
use Braintree\TransactionGateway;
use Magento\Braintree\Model\Adapter\BraintreeAdapter;
use Magento\Braintree\Model\Adapter\BraintreeGatewayFactory;
use PHPUnit\Framework\TestCase;

class BraintreeAdapterTest extends TestCase
{
    public function testGenerate(): void
    {
        $expected = 'string';
        $params = ['key' => 'value'];

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['clientToken'])
            ->getMock();

        $clientTokenMock = $this->getMockBuilder(ClientTokenGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['generate'])
            ->getMock();

        $clientTokenMock->expects($this->once())
            ->method('generate')
            ->with($params)
            ->willReturn($expected);

        $braintreeMock->expects($this->once())
            ->method('clientToken')
            ->willReturn($clientTokenMock);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertEquals($expected, $object->generate($params));
    }

    public function testGenerateNull(): void
    {
        $params = ['key' => 'value'];

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['clientToken'])
            ->getMock();

        $clientTokenMock = $this->getMockBuilder(ClientTokenGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['generate'])
            ->getMock();

        $clientTokenMock->expects($this->once())
            ->method('generate')
            ->with($params)
            ->will($this->throwException(new \InvalidArgumentException()));

        $braintreeMock->expects($this->once())
            ->method('clientToken')
            ->willReturn($clientTokenMock);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertNull($object->generate($params));
    }

    public function testFind(): void
    {
        $expected = 'string';
        $token = 'token';

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['creditCard'])
            ->getMock();

        $creditCardGateway = $this->getMockBuilder(CreditCardGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $creditCardGateway->expects($this->once())
            ->method('find')
            ->with($token)
            ->willReturn($expected);

        $braintreeMock->expects($this->once())
            ->method('creditCard')
            ->willReturn($creditCardGateway);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertEquals($expected, $object->find($token));
    }

    public function testFindNull(): void
    {
        $token = 'token';

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['creditCard'])
            ->getMock();

        $creditCardGateway = $this->getMockBuilder(CreditCardGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $creditCardGateway->expects($this->once())
            ->method('find')
            ->with($token)
            ->will($this->throwException(new \InvalidArgumentException()));

        $braintreeMock->expects($this->once())
            ->method('creditCard')
            ->willReturn($creditCardGateway);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertNull($object->find($token));
    }

    public function testSearch(): void
    {
        $filters = ['filter1', 'filter2'];

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['transaction'])
            ->getMock();

        $transactionGatewayMock = $this->getMockBuilder(TransactionGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['search'])
            ->getMock();

        $resourceCollectionMock = $this->getMockBuilder(ResourceCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $transactionGatewayMock->expects($this->once())
            ->method('search')
            ->with($filters)
            ->willReturn($resourceCollectionMock);

        $braintreeMock->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertEquals($resourceCollectionMock, $object->search($filters));
    }

    public function testCreateNone(): void
    {
        $token = 'token';

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['paymentMethodNonce'])
            ->getMock();
        $paymentMethodNonceGatewayMock = $this->getMockBuilder(PaymentMethodNonceGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $successfulMock = $this->getMockBuilder(Successful::class)
            ->disableOriginalConstructor()
            ->getMock();

        $paymentMethodNonceGatewayMock->expects($this->once())
            ->method('create')
            ->with($token)
            ->willReturn($successfulMock);

        $braintreeMock->expects($this->once())
            ->method('paymentMethodNonce')
            ->willReturn($paymentMethodNonceGatewayMock);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertEquals($successfulMock, $object->createNonce($token));
    }

    public function testSale(): void
    {
        $attributes = ['attribute1', 'attribute2'];

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['transaction'])
            ->getMock();

        $transactionGatewayMock = $this->getMockBuilder(TransactionGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['sale'])
            ->getMock();

        $resourceCollectionMock = $this->getMockBuilder(ResourceCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $transactionGatewayMock->expects($this->once())
            ->method('sale')
            ->with($attributes)
            ->willReturn($resourceCollectionMock);

        $braintreeMock->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertEquals($resourceCollectionMock, $object->sale($attributes));
    }

    public function testSubmitForSettlement(): void
    {
        $transactionId = 'transaction_id';
        $amount = 0.01;

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['transaction'])
            ->getMock();

        $transactionGatewayMock = $this->getMockBuilder(TransactionGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['submitForSettlement'])
            ->getMock();

        $successfulMock = $this->getMockBuilder(Successful::class)
            ->disableOriginalConstructor()
            ->getMock();

        $transactionGatewayMock->expects($this->once())
            ->method('submitForSettlement')
            ->with($transactionId, $amount)
            ->willReturn($successfulMock);

        $braintreeMock->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertEquals($successfulMock, $object->submitForSettlement($transactionId, $amount));
    }

    public function testVoid(): void
    {
        $transactionId = 'transaction_id';

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['transaction'])
            ->getMock();

        $transactionGatewayMock = $this->getMockBuilder(TransactionGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['void'])
            ->getMock();

        $successfulMock = $this->getMockBuilder(Successful::class)
            ->disableOriginalConstructor()
            ->getMock();

        $transactionGatewayMock->expects($this->once())
            ->method('void')
            ->with($transactionId)
            ->willReturn($successfulMock);

        $braintreeMock->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertEquals($successfulMock, $object->void($transactionId));
    }

    public function testRefund(): void
    {
        $transactionId = 'transaction_id';
        $amount = 0.01;

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['transaction'])
            ->getMock();

        $transactionGatewayMock = $this->getMockBuilder(TransactionGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['refund'])
            ->getMock();

        $successfulMock = $this->getMockBuilder(Successful::class)
            ->disableOriginalConstructor()
            ->getMock();

        $transactionGatewayMock->expects($this->once())
            ->method('refund')
            ->with($transactionId, $amount)
            ->willReturn($successfulMock);

        $braintreeMock->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertEquals($successfulMock, $object->refund($transactionId, $amount));
    }

    public function testCloneTransaction(): void
    {
        $transactionId = 'transaction_id';
        $attributes = ['attribute1', 'attribute2'];

        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $braintreeMock = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['transaction'])
            ->getMock();

        $transactionGatewayMock = $this->getMockBuilder(TransactionGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['cloneTransaction'])
            ->getMock();

        $successfulMock = $this->getMockBuilder(Successful::class)
            ->disableOriginalConstructor()
            ->getMock();

        $transactionGatewayMock->expects($this->once())
            ->method('cloneTransaction')
            ->with($transactionId, $attributes)
            ->willReturn($successfulMock);

        $braintreeMock->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $braintreeGatewayFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($braintreeMock);

        $object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $braintreeGatewayFactoryMock
        );

        $this->assertEquals($successfulMock, $object->cloneTransaction($transactionId, $attributes));
    }
}
