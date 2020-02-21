<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\TestFramework\CodingStandard\Tool;

/**
 * Implements a wrapper around `phpcs` for usage with the `PHPCompatibility` sniffs against a specific PHP version.
 */
class PhpCompatibility extends CodeSniffer implements CompatibilityInterface
{
    /**
     * Sets the version against which to test code.
     *
     * @param string $version
     * @return void
     */
    public function setTestVersion(string $version)
    {
        \PHP_CodeSniffer\Config::setConfigData('testVersion', $version);
    }
}
