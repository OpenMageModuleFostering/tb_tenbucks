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
class Tb_Tenbucks_Model_Shipping_Api extends Mage_Checkout_Model_Api_Resource {    

    /**
     * Get list of available shipping methods
     *
     * @param  $store
     * @return array
     */
    public function getShippingMethodsList($store = null) {
        
        $storeId = $this->_getStoreId($store);

        $activeCarriers = Mage::getSingleton('shipping/config')->getActiveCarriers($storeId);
        if (empty($activeCarriers)) {
            $this->_fault("no_shipping_method_active");
        }

        try {

            $shippingMethosdResult = array();

            foreach ($activeCarriers as $carrierCode => $carrierModel) {

                if ($carrierMethods = $carrierModel->getAllowedMethods()) {

                    $carrierTitle = $carrierCode;
                    if (!is_null(Mage::getStoreConfig('carriers/' . $carrierCode . '/title'))) {
                        $carrierTitle = Mage::getStoreConfig('carriers/' . $carrierCode . '/title');
                    }

                    foreach ($carrierMethods as $methodCode => $method) {

                        $shippingMethosdResult[] = array(
                            'code' => $carrierCode . '_' . $methodCode,
                            'carrier' => $carrierCode,
                            'carrier_title' => $carrierTitle,
                            'method' => $methodCode,
                            'method_title' => $method
                        );
                    }
                }
            }
        } catch (Mage_Core_Exception $e) {
            $this->_fault('shipping_methods_list_could_not_be_retrieved', $e->getMessage());
        }

        return $shippingMethosdResult;
    }

}
