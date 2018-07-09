/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([], function () {
    if(!window.PaymentRequest) {
        alert('Payment Request API is not supported.');
    }

    var googlePayPaymentMethod = {
        supportedMethods: 'https://google.com/pay',
        data: {
            'environment': 'TEST',
            'apiVersion': 1,
            'allowedPaymentMethods': ['CARD', 'TOKENIZED_CARD'],
            'paymentMethodTokenizationParameters': {
                'tokenizationType': 'PAYMENT_GATEWAY',
                'parameters': {}
            },
            'cardRequirements': {
                'allowedCardNetworks': ['AMEX', 'DISCOVER', 'MASTERCARD', 'VISA'],
                'billingAddressRequired': true,
                'billingAddressFormat': 'MIN'
            },
            'phoneNumberRequired': true,
            'emailRequired': true,
            'shippingAddressRequired': true
        }
    };
    var supportedPaymentMethods = [
        googlePayPaymentMethod,
        {
            supportedMethods: 'basic-card'
        }
    ];
    var paymentDetails = {
        total: {
            label: 'Total',
            amount:{
                currency: 'USD',
                value: 0
            }
        }
    };

    var paymentRequest = new PaymentRequest(supportedPaymentMethods, paymentDetails);
    try {
        paymentRequest.show();
    } catch (e) {
        console.log(e);
    }
});