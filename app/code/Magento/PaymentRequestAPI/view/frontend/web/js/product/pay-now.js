/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'uiComponent',
    'Magento_PaymentRequestAPI/js/init'
], function ($, Component, PaymentRequest) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magento_PaymentRequestAPI/product/pay-now'
        },

        buyNow: function () {
            PaymentRequest().show()
                .then(function (paymentResponse) {
                    console.log(paymentResponse);
                    /**
                     * @TODO return fail for testing purposes
                     */
                    return paymentResponse.complete('fail');
                })
                .catch(function (error) {
                    switch (error.name) {
                        case 'AbortError':
                            console.log('Payment Request dialog was closed by user: ' + error.message);
                            break;
                        case 'InvalidStateError':
                            console.error('Invalid Payment Request state: ' + error.message);
                            break;
                        default:
                            console.error(error)
                    }
                });
        }
    });
});