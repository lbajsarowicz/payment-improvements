# Repository dedicated to Payment Improvements

## Improvements

* Payment is now using the facade pattern what is very cool. Only the assignData should have implemented a command rather then an observer. Now you need to create an observer to just pass data from front-end to the payment information. Basically this is just a copy past method so maybe this can be done already automatically.
 
* A lot of duplicate ids in the core templates that are being loaded in the payment step. We use default templates (license agreement, billing address data)  that are using fixed ids inside the different components, this is causing errors in the console log. The IDs should be unique or do not use any ids but classes.

** Question: What should be changed in core to allow that?
 
* we need to extend the Adapter because it is missing the updateBillingAgreementStatus method.
 
* Make it easier to redirect to external page for alternative payment methods without the need to change core code for order placement.
 
* Orders that do not complete on the payment page are remain open orders in magento. Is there an solution to this ?

* Braintree and other module replace the getting qoute from session to quote_id_mask 
	example : Magento\Braintree\Controller\Paypal\PlaceOrde
  
* Add fee to payment module, some time merchant wants customer to pay fee for using payment method, some modules provides this functionality. 

* To method canUseForCurrency() of intereface Magento\Payment\Model\MethodInterface add additional param 


## MFTF tests coverage
