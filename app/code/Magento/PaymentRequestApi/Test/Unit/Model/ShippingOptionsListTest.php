<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Test\Unit\Model;

use Magento\PaymentRequestApi\Api\Data\AddressInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\PaymentRequestApi\Model\ShippingOptionsList;
use PHPUnit\Framework\TestCase;

class ShippingOptionsListTest extends TestCase
{
    /** @var ShippingOptionsList */
    private $shippingOptionsList;

    /** @var AddressInterface | \PHPUnit_Framework_MockObject_MockObject */
    private $addressMock;

    protected function setUp()
    {
        $this->addressMock = $this->getMockBuilder(AddressInterface::class)->getMock();
    }

    public function testGetWithEmptyCountry()
    {
        $this->shippingOptionsList = (new ObjectManager($this))->getObject(
            ShippingOptionsList::class, []
        );

        $this->shippingOptionsList->get($this->addressMock);
    }

}