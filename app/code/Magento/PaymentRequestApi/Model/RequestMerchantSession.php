<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\PaymentRequestApi\Model;

use Magento\PaymentRequestApi\Api\Data\RequestMerchantSessionInterface;

/**
 * @inheritdoc
 */
class RequestMerchantSession implements RequestMerchantSessionInterface
{

    /**
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        $validationUrl = "https://apple-pay-gateway-nc-pod1.apple.com/paymentservices/startSession";

        // create a new cURL resource
        $ch = curl_init();

        // TODO: Make this variables dynamic and retrieve them from configurations
        $merchantIdentifier = 'merchant.com.adyen.magento2.hackaton.test';
        $domainName = 'magento-225-alessio.seamless-checkout.store';
        $displayName = 'Magento2 demo test';

        $data = '{
            "merchantIdentifier":"' . $merchantIdentifier . '",
            "domainName":"' . $domainName . '",
            "displayName":"' . $displayName . '",
            "initiative":"web",
            "initiativeContext":"' . $domainName . '"
        }';

        curl_setopt($ch, CURLOPT_URL, $validationUrl);

        // location applepay certificates
        // TODO: allow merchant to upload this file through the backoffice
        $fullPathLocationPEMFile = '/var/www/html/apple-pay-cert.pem';

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLCERT, $fullPathLocationPEMFile);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );

        $result = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpStatus != 200 && $result) {
            curl_close($ch);
            $msg = "\n(No Result HTTP error $httpStatus";
            throw new \Exception($msg);
        } elseif (!$result) {
            $errno = curl_errno($ch);
            $message = curl_error($ch);
            curl_close($ch);
            $msg = "\n(Network error [errno $errno]: $message)";
            throw new \Exception($msg);
        }

        // close cURL resource, and free up system resources
        curl_close($ch);

        return $result;
    }
}
