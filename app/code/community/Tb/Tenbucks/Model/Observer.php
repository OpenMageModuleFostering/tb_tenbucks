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

class Tb_Tenbucks_Model_Observer {

    public function handle_adminSystemConfigChangedSection(Varien_Event_Observer $observer) {  
        
        return Mage::getModel('tenbucks/webhooks')->hookGtin();
        
    }
    
    public function handle_catalogProductSaveAfter(Varien_Event_Observer $observer) {  
        
        $productId = $observer->getProduct()->getId();        
        
        return Mage::getModel('tenbucks/webhooks')->hookProduct($productId);
        
    }

}