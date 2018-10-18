/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
        'jquery',
        'ko',
        'uiComponent',
        'Magento_PaymentRequestApi/js/payment-request-factory',
        'mage/url',
        'mage/storage'
    ],
    function ($, ko, Component, PaymentRequest, url, storage) {
        'use strict';
        var quoteId = ko.observable(null);

        return Component.extend({
            defaults: {
                template: 'Magento_PaymentRequestApi/buy-now'
            },

            /**
             * Checks id Payment Request API is available
             * @returns {Boolean}
             */
            isAvailable: function () {

                // eslint-disable-next-line
                // @TODO should check availability from PaymentRequest
                return true;
            },

            /**
             * Handler for `Buy Now` button
             */
            buyNow: function () {
                PaymentRequest().show()
                    .then(function (paymentResponse) {
                        console.log(paymentResponse);

                        // eslint-disable-next-line
                        // @TODO return fail for testing purposes
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
                                console.error(error);
                        }
                    });
            },
            applePay: function () {
                var self = this;

                var shippingMethods = [];

                var paymentRequest = {
                    currencyCode: "USD",
                    countryCode: "US",
                    total: {
                        label: "Test",
                        amount: 100
                    },
                    supportedNetworks: ["amex", "discover", "masterCard", "visa"],
                    merchantCapabilities: ["supports3DS"],
                    shippingMethods: shippingMethods,
                    shippingType: "shipping", // options are: shipping, delivery, storePickup, servicePickup
                    requiredBillingContactFields: ["postalAddress", "phone", "email", "name"],
                    requiredShippingContactFields: ["postalAddress", "phone", "email", "name"],
                };


                var session = new ApplePaySession(1, paymentRequest);
                session.onvalidatemerchant = function (event) {
                    var promise = self.performValidation(event.validationURL);

                    promise.then(function (merchantSession) {
                        session.completeMerchantValidation(merchantSession);
                    });
                }


                session.onshippingoptionchange = function (event) {
                    // Compute new payment details based on the selected shipping option.
                    debugger;
                    ;
                };
                // });

                session.onshippingaddresschange = function (event) {
                    debugger;
                    ;
                };

                session.onshippingmethodselected = function (event) {


                    var quoteMaskedId = quoteId();
                    var shippingCode = event.shippingMethod.identifier;
                    // set shippingMethod
                    var promiseRetrieveTotals = self.calculateTotals(quoteMaskedId, shippingCode);
                    promiseRetrieveTotals.then(function (totals) {

                        var newTotal = {
                            label: "Grand Total",
                            amount: totals.base_grand_total
                        };

                        var newLineItems = [];
                        totals.items.forEach(function (totalLine) {
                            newLineItems.push({
                                type: "final",
                                label: totalLine.name,
                                amount: totalLine.base_price
                            })
                        });

                        session.completeShippingMethodSelection(
                            ApplePaySession.STATUS_SUCCESS,
                            newTotal,
                            newLineItems
                        );
                    });



                }

                session.onshippingcontactselected = function (event) {
                    // create quote here


                    var promise = self.createEmptyCart();
                    promise.then(function (quoteMaskedId) {

                        quoteId(quoteMaskedId);

                        var promisAddTocart = self.addProductToCart(quoteMaskedId);
                        promisAddTocart.then(function (productItem) {

                            var shippingContract = event.shippingContact;
                            var promiseCreateShippingAddress = self.createShippingAddress(quoteMaskedId, shippingContract);
                            promiseCreateShippingAddress.then(function (addressId) {

                                // retrieve shipping methods
                                var promiseRetrieveShippingMethods = self.retrieveShippingMethods(quoteMaskedId);
                                promiseRetrieveShippingMethods.then(function (shippingMethodsResult) {

                                    var status = session.STATUS_SUCCESS;
                                    var shippingMethods = [];
                                    var defaultShippingCode = null;

                                    shippingMethodsResult.forEach(function (shippingMethodResult, index) {
                                        // store first item
                                        if(index==0){
                                            defaultShippingCode = shippingMethodResult.method_code;
                                        }

                                        var shippingMethod = {
                                            "label": shippingMethodResult.carrier_title,
                                            "detail": "",
                                            "amount": shippingMethodResult.amount,
                                            "identifier": shippingMethodResult.method_code
                                        };
                                        shippingMethods.push(shippingMethod);
                                    });

                                    var promiseRetrieveTotals = self.calculateTotals(quoteMaskedId, defaultShippingCode);
                                    promiseRetrieveTotals.then(function (totals) {

                                        var newTotal = {
                                            label: "Grand Total",
                                            amount: totals.base_grand_total
                                        };

                                        var newLineItems = [];
                                        totals.items.forEach(function (totalLine) {
                                            newLineItems.push({
                                                type: "final",
                                                label: totalLine.name,
                                                amount: totalLine.base_price
                                            })
                                        });

                                        session.completeShippingContactSelection(status, shippingMethods, newTotal, newLineItems);
                                    });
                                });
                            });
                        });
                    });
                }

                session.begin();
            },
            performValidation: function (validationURL) {
                // Return a new promise.
                return new Promise(function (resolve, reject) {

                    // retrieve payment methods
                    var serviceUrl = url.build('rest/V1/paymentrequestapi/requestMerchantSession');

                    storage.get(
                        serviceUrl
                    ).done(
                        function (response) {
                            var data = JSON.parse(response);
                            resolve(data);
                        }
                    ).fail(function (error) {
                        console.log(JSON.stringify(error));
                        reject(Error("Network Error"));
                    });
                });
            },
            createEmptyCart: function () {
                // Return a new promise.
                return new Promise(function (resolve, reject) {

                    // retrieve payment methods
                    var serviceUrl = url.build('rest/V1/guest-carts');

                    storage.post(
                        serviceUrl
                    ).done(
                        function (quoteMaskedId) {
                            resolve(quoteMaskedId);
                        }
                    ).fail(function (error) {
                        console.log(JSON.stringify(error));
                        reject(Error("Network Error"));
                    });
                });
            },
            addProductToCart: function (quoteId) {
                // productId
                var productId = $('#sku-value').val();


                return new Promise(function (resolve, reject) {
                    // retrieve payment methods
                    // var serviceUrl = url.build('rest/default/V1/carts/mine/items');
                    var endpoint = 'rest/V1/guest-carts/' + quoteId + '/items';
                    var serviceUrl = url.build(endpoint);

                    var data =
                        {
                            cartItem: {
                                "qty": '1',
                                "sku": productId,
                                "quoteId": quoteId
                            }
                        };

                    storage.post(
                        serviceUrl,
                        JSON.stringify(data)
                    ).done(
                        function (result) {
                            resolve(result);
                        }
                    ).fail(function (error) {
                        console.log(JSON.stringify(error));
                        reject(Error("Network Error"));
                    });
                });

            },
            createShippingAddress: function (quoteId, shippingContract) {

                return new Promise(function (resolve, reject) {
                    // retrieve payment methods
                    // var serviceUrl = url.build('rest/default/V1/carts/mine/items');
                    // /V1/guest-carts/{cartId}/billing-address
                    var endpoint = 'rest/V1/guest-carts/' + quoteId + '/billing-address';
                    var serviceUrl = url.build(endpoint);

                    var data = {
                        address: {
                            region_code: shippingContract.administrativeArea,
                            country_id: shippingContract.countryCode,
                            street: [
                                shippingContract.locality
                            ],
                            postcode: shippingContract.postalCode
                        },
                        useForShipping: true
                    }

                    storage.post(
                        serviceUrl,
                        JSON.stringify(data)
                    ).done(
                        function (result) {
                            resolve(result);
                        }
                    ).fail(function (error) {
                        console.log(JSON.stringify(error));
                        reject(Error("Network Error"));
                    });
                });
            },
            retrieveShippingMethods: function (quoteId) {

                return new Promise(function (resolve, reject) {
                    // retrieve payment methods
                    // var serviceUrl = url.build('rest/default/V1/carts/mine/items');
                    var endpoint = 'rest/V1/guest-carts/' + quoteId + '/shipping-methods';
                    var serviceUrl = url.build(endpoint);

                    storage.get(
                        serviceUrl
                    ).done(
                        function (result) {
                            resolve(result);
                        }
                    ).fail(function (error) {
                        console.log(JSON.stringify(error));
                        reject(Error("Network Error"));
                    });
                });


            },
            calculateTotals: function (quoteId, shippingMethodCode) {

                return new Promise(function (resolve, reject) {
                    // retrieve payment methods
                    // var serviceUrl = url.build('rest/default/V1/carts/mine/items');
                    var endpoint = 'rest/V1/guest-carts/' + quoteId + '/collect-totals';
                    var serviceUrl = url.build(endpoint);

                    var data = {
                        shippingMethodCode: shippingMethodCode,
                        shippingCarrierCode: shippingMethodCode,
                        paymentMethod: {
                            method: "checkmo"
                        }
                    };

                    storage.put(
                        serviceUrl,
                        JSON.stringify(data)
                    ).done(
                        function (result) {
                            resolve(result);
                        }
                    ).fail(function (error) {
                        console.log(JSON.stringify(error));
                        reject(Error("Network Error"));
                    });
                });
            }
        });
    });
