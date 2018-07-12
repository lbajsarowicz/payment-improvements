/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'uiComponent'
], function ($, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Magento_PaymentRequestAPI/product/pay-now'
        },

        buyNow: function () {
            alert('Pay');
        }
    });
});