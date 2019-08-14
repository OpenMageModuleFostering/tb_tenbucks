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

class Tb_Tenbucks_Helper_Data extends Mage_Core_Helper_Abstract 
{
    const URI = 'https://apps.tenbucks.io';
    
    const XML_CONFIG_TENBUCKS_GENERAL_GTIN = 'tenbucks/general/gtin';
    const XML_CONFIG_TENBUCKS_GENERAL_INSTALLED = 'tenbucks/general/installed';
    const XML_CONFIG_TENBUCKS_GENERAL_API_KEY = 'tenbucks/general/api_key';
    
    public function getModuleVersion() {                
        
        return (string)Mage::getConfig()->getModuleConfig('Tb_Tenbucks')->version;        
    }
    
    public function getApiUrl($path = '') {
        
        if($path) {            
            return self::URI . DS . $path;            
        } else {            
            return self::URI;
        }                        
    }
    
    
    public function getGtinCode() {
        return Mage::getStoreConfig(self::XML_CONFIG_TENBUCKS_GENERAL_GTIN);
    }
    
    public function isInstalled() {
        return Mage::getStoreConfigFlag(self::XML_CONFIG_TENBUCKS_GENERAL_INSTALLED);        
    }
    
     public function setisInstalled() {    
        return Mage::getConfig()->saveConfig(self::XML_CONFIG_TENBUCKS_GENERAL_INSTALLED,1);        
    }
    
    public function canSignup() {
        if(!Mage::getStoreConfig('general/store_information/name')) {
            return false;
        }        
        if(!$this->getGtinCode()) {
            return false;
        }        
        
        return true;
    }
    
    public function getApiKey() {
        return Mage::getStoreConfig(self::XML_CONFIG_TENBUCKS_GENERAL_API_KEY);
    }
    
    public function setApiKey($api_key = '') {
        return Mage::getConfig()->saveConfig(self::XML_CONFIG_TENBUCKS_GENERAL_API_KEY,$api_key);
    }


    
    
    
       
}