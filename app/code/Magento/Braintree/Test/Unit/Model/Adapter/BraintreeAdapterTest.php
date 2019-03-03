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
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BraintreeAdapterTest extends TestCase
{
    /**
     * @var BraintreeGatewayFactory|MockObject
     */
    private $braintreeGatewayFactoryMock;

    /**
     * @var BraintreeAdapter
     */
    private $object;

    /**
     * @var Gateway|MockObject
     */
    private $braintree;

    protected function setUp()
    {
        $publicKey = 'public_key';
        $privateKey = 'private_key';
        $environment = 'production';
        $merchantId = 'merchant_id';

        $this->braintreeGatewayFactoryMock = $this->getMockBuilder(BraintreeGatewayFactory::class)
            ->setMethods(['create'])
            ->getMock();

        $this->braintree = $this->getMockBuilder(Gateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['clientToken', 'creditCard', 'transaction', 'paymentMethodNonce'])
            ->getMock();

        $this->braintreeGatewayFactoryMock->method('create')
            ->willReturn($this->braintree);

        $this->object = new BraintreeAdapter(
            $merchantId,
            $publicKey,
            $privateKey,
            $environment,
            $this->braintreeGatewayFactoryMock
        );
    }

    public function testGenerate(): void
    {
        $expected = 'string';
        $params = ['key' => 'value'];

        $clientTokenMock = $this->getMockBuilder(ClientTokenGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['generate'])
            ->getMock();

        $clientTokenMock->expects($this->once())
            ->method('generate')
            ->with($params)
            ->willReturn($expected);

        $this->braintree->expects($this->once())
            ->method('clientToken')
            ->willReturn($clientTokenMock);

        $this->assertInstanceOf(BraintreeAdapter::class, $this->object);
        $this->assertEquals($expected, $this->object->generate($params));
    }

    public function testGenerateNull(): void
    {
        $params = ['key' => 'value'];

        $clientTokenMock = $this->getMockBuilder(ClientTokenGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['generate'])
            ->getMock();

        $clientTokenMock->expects($this->once())
            ->method('generate')
            ->with($params)
            ->will($this->throwException(new \InvalidArgumentException()));

        $this->braintree->expects($this->once())
            ->method('clientToken')
            ->willReturn($clientTokenMock);

        $this->assertNull($this->object->generate($params));
    }

    public function testFind(): void
    {
        $expected = 'string';
        $token = 'token';

        $creditCardGateway = $this->getMockBuilder(CreditCardGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $creditCardGateway->expects($this->once())
            ->method('find')
            ->with($token)
            ->willReturn($expected);

        $this->braintree->expects($this->once())
            ->method('creditCard')
            ->willReturn($creditCardGateway);

        $this->assertEquals($expected, $this->object->find($token));
    }

    public function testFindNull(): void
    {
        $token = 'token';

        $creditCardGateway = $this->getMockBuilder(CreditCardGateway::class)
            ->disableOriginalConstructor()
            ->setMethods(['find'])
            ->getMock();

        $creditCardGateway->expects($this->once())
            ->method('find')
            ->with($token)
            ->will($this->throwException(new \InvalidArgumentException()));

        $this->braintree->expects($this->once())
            ->method('creditCard')
            ->willReturn($creditCardGateway);

        $this->assertNull($this->object->find($token));
    }

    public function testSearch(): void
    {
        $filters = ['filter1', 'filter2'];

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

        $this->braintree->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $this->assertEquals($resourceCollectionMock, $this->object->search($filters));
    }

    public function testCreateNonce(): void
    {
        $token = 'token';

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

        $this->braintree->expects($this->once())
            ->method('paymentMethodNonce')
            ->willReturn($paymentMethodNonceGatewayMock);


        $this->assertEquals($successfulMock, $this->object->createNonce($token));
    }

    public function testSale(): void
    {
        $attributes = ['attribute1', 'attribute2'];

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

        $this->braintree->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $this->assertEquals($resourceCollectionMock, $this->object->sale($attributes));
    }

    public function testSubmitForSettlement(): void
    {
        $transactionId = 'transaction_id';
        $amount = 0.01;

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

        $this->braintree->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $this->assertEquals($successfulMock, $this->object->submitForSettlement($transactionId, $amount));
    }

    public function testVoid(): void
    {
        $transactionId = 'transaction_id';

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

        $this->braintree->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $this->assertEquals($successfulMock, $this->object->void($transactionId));
    }

    public function testRefund(): void
    {
        $transactionId = 'transaction_id';
        $amount = 0.01;

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

        $this->braintree->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $this->assertEquals($successfulMock, $this->object->refund($transactionId, $amount));
    }

    public function testCloneTransaction(): void
    {
        $transactionId = 'transaction_id';
        $attributes = ['attribute1', 'attribute2'];

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

        $this->braintree->expects($this->once())
            ->method('transaction')
            ->willReturn($transactionGatewayMock);

        $this->assertEquals($successfulMock, $this->object->cloneTransaction($transactionId, $attributes));
    }
}
