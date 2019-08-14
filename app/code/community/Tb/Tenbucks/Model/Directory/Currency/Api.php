<?php

/**
 * Tenbucks
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hello@tenbucks.io so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Tenbucks to newer
 * versions in the future.
 *
 * @category   Tenbucks
 * @package    Tb_Tenbucks
 * @copyright  Copyright (c) 2016 Tenbucks. (https://www.tenbucks.io)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author      Tenbucks <hello@tenbucks.io>
 */
class Tb_Tenbucks_Model_Directory_Currency_Api extends Mage_Api_Model_Resource_Abstract {

    /**
     * Retrieve currency rates
     *
     * @return array
     */
    public function getRates() {
        
        $_results = array();
        // Get the base currency
        $baseCurrencyCode = Mage::app()->getBaseCurrencyCode();
        // get all allowed currency codes
        $allowedCurrencies = Mage::getSingleton('directory/currency')
                ->getConfigAllowCurrencies();	
        
        foreach (Mage::getSingleton('directory/currency')
                ->getCurrencyRates($baseCurrencyCode, array_values($allowedCurrencies))
                as $currency => $rate)
        {
            $_results[] = array(
                'base_currency' => $baseCurrencyCode,
                'to_currency'   => $currency,
                'rate'          => $rate
            );
        }
        return $_results;
    }

}
